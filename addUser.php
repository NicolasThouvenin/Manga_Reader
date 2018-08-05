<!DOCTYPE html>
<html>
<head>
    <title>Ajout d'un utilisateur</title>
    <meta charset="utf-8">
</head>
<body>
    <?php
        function checkData($data) {
            foreach ($data as $key => $value) {
                $data[$key] = htmlentities($value);
            }
            return $data;
        }

        try {

            session_start();

            if (!isset($_SESSION['registerToken'])) {
                throw new Exception("La requ�te post d'inscription ne poss�de pas de token correspondant � un formulaire d'inscription envoy� par le serveur");
            } else if ($_SESSION['registerToken'] != $_POST['registerToken']) {
                throw new Exception("La requ�te post d'inscription n'indique pas pas le m�me token d'inscription que celui de la session du serveur");
            }

            if (!isset($_COOKIE['user'])) {

                include('connection.php');

                $checkedData = checkData($_POST);
                $addUser = $db->prepare("CALL createUser(:login, :firstname, :surname, :birthDate, :password, :email, :token, @lastUserId)");

                $addUser->bindParam(':login', $checkedData['login'], PDO::PARAM_STR, 255);
                $addUser->bindParam(':firstname', $checkedData['firstname'], PDO::PARAM_STR, 255);
                $addUser->bindParam(':surname', $checkedData['surname'], PDO::PARAM_STR, 255);
                $addUser->bindParam(':birthDate', $checkedData['birthDate'], PDO::PARAM_STR, 10);
                $addUser->bindParam(':password', $checkedData['password'], PDO::PARAM_STR, 255);
                $addUser->bindParam(':email', $checkedData['email'], PDO::PARAM_STR, 254);

                $addUser->execute();
                $addUser->closeCursor();

                $result = $db->query("SELECT @lastUserId")->fetch(PDO::FETCH_ASSOC);


                $token = hash('sha256', session_id().$_SESSION['registerToken'].$checkedData['login']);

                $addToken = $db->prepare("CALL addToken(:token, :login)");
                $addToken->bindParam(':token', $token, PDO::PARAM_STR, 64);
                $addToken->bindParam(':login', $checkedData['login'], PDO::PARAM_STR, 255);

                $validated = false;              
                $user = new User($result['@lastUserId'], $line['Login'], $line['Firstname'], $line['Surname'], $line['BirthDate'], $line['Email'], $validated, $token);
                setcookie ('user', serialize($user));

                header('Location: homePage.php');
            }



        } catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
        };
    ?>
</body>
</html>