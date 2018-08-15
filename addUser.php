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
                throw new Exception("<br>The session doesn't have a form token from a server form");
            } else if ($_SESSION['uniqid'] != $_POST['uniqid']) {
                throw new Exception("<br>The post request form token as different as session token");
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

            header('Location: emailValidation.php?userid'.$result['@lastUserId'].'&emailkey='.$result['@lastUserEmailKey'].'&sendemail=true');

        } catch(Exception $e) {
            die('<br>Erreur de la création du nouvel utilisateur: '.$e->getMessage());
        };
    ?>
</body>
</html>