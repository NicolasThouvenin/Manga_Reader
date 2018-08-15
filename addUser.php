<!DOCTYPE html>
<html>
<head>
    <title>Ajout d'un utilisateur</title>
    <meta charset="utf-8">
</head>
<body>
    <?php

    	/* Cette page reçoit le post du formulaire d'incription des utilisateurs et pousse créer un utilisateur dans la base de données. */

        try {

            require('required.php');
            require('connection.php');

            session_start();

            if (!isset($_SESSION['uniqid'])) {
                throw new Exception("<br>La requête post d'inscription ne possède pas de token correspondant à un formulaire d'inscription envoyé par le serveur");
            } else if ($_SESSION['uniqid'] != $_POST['uniqid']) {
                throw new Exception("<br>La requête post d'inscription n'indique pas pas le même token d'inscription que celui de la session du serveur");
            }

            $checkedData = Util::checkPostData($_POST);
            $addUser = $db->prepare("CALL createUser(:login, :firstname, :surname, :birthDate, :password, :email, @lastUserId, @lastUserEmailKey)");

            $addUser->bindParam(':login', $checkedData['login'], PDO::PARAM_STR, 255);
            $addUser->bindParam(':firstname', $checkedData['firstname'], PDO::PARAM_STR, 255);
            $addUser->bindParam(':surname', $checkedData['surname'], PDO::PARAM_STR, 255);
            $addUser->bindParam(':birthDate', $checkedData['birthDate'], PDO::PARAM_STR, 10);
            $addUser->bindParam(':password', $checkedData['password'], PDO::PARAM_STR, 255);
            $addUser->bindParam(':email', $checkedData['email'], PDO::PARAM_STR, 254);

            $addUser->execute();
            $addUser->closeCursor();

            $result = $db->query("SELECT @lastUserId, @lastUserEmailKey")->fetch(PDO::FETCH_ASSOC);

            $subject = "confirmation d'inscription bubbleup";
            $message = "Bonjour,\nMerci de votre inscription sur bubbleup. Pour confirmer votre inscription, merci de cliquer sur l'url suivante :\n
            http://localhost/projetWeb1/emailValidation.php?userid=".$result['@lastUserId'].'&emailkey='.$result['@lastUserEmailKey'];
            
            mail($checkedData['email'], $subject, $message);

            header('Location: emailValidation.php?');

        } catch(Exception $e) {
            die('<br>Erreur de la création du nouvel utilisateur: '.$e->getMessage());
        };
    ?>
</body>
</html>