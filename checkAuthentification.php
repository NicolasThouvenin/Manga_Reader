<!DOCTYPE html>
<html>
<head>
    <title>Vérification de l'authentification</title>
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

            if (!isset($_SESSION['loginToken'])) {
                throw new Exception("La requête post d'authentification ne possède pas de token correspondant à un formulaire envoyé par le serveur");
            } else if ($_SESSION['loginToken'] != $_POST['loginToken']) {
                throw new Exception("La requête post n'indique pas pas le même token d'authentification que celui de la session du serveur");
            }

            include('connection.php');

            $checkedData = checkData($_POST);

            $logger = $db->prepare("SELECT users.* FROM users WHERE Login = :login AND password = PASSWORD(:password);");            

            $logger->execute(array('login' => $_POST['login'], 'password' => $_POST['password']));

            if ($logger->rowCount() == 1) {
                include('user.class.php');
                while ($line = $logger->fetch()) {
                    $_SESSION['user'] = new User($line['Id'], $line['Login'], $line['Firstname'], $line['Surname'], $line['BirthDate'], $line['Email'], $line['EmailValidated']);
                }

                $logger->closeCursor();
                header('Location: homePage.php');

            } else {
                $logger->closeCursor();
                header('Location: login.php');
            };


        } catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
        };
    ?>
</body>
</html>