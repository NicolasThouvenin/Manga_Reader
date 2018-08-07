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
            require('required.php');
            require('connection.php');
            session_start();

            if (!isset($_SESSION['uniqid'])) {
                throw new Exception("La requête post d'authentification ne possède pas de token correspondant à un formulaire envoyé par le serveur");
            } else if ($_SESSION['uniqid'] != $_POST['uniqid']) {
                throw new Exception("La requête post n'indique pas pas le même token d'authentification que celui de la session du serveur");
            }

            $checkedData = checkData($_POST);

            $logger = $db->prepare("SELECT users.* FROM users WHERE Login = :login AND password = PASSWORD(:password);");

            $logger->execute(array('login' => $_POST['login'], 'password' => $_POST['password']));

            if ($logger->rowCount() == 1) {
                while ($line = $logger->fetch()) {
                    $authentified = new Authentified($line['Id'], $_SESSION['uniqid']);
                    $authentifiedSerialized = serialize($authentified);

                    if (isset($_POST['stayConnected'])) {
                        setcookie ('authentified', $authentifiedSerialized, time()+86400*365); //expire au bout d'un an
                    } else {
                        setcookie ('authentified', $authentifiedSerialized, 0); //expire à la fin de la session
                    }
                }

                $logger->closeCursor();
                header('Location: homePage.php');
            } else {
                $logger->closeCursor();
                header('Location: login.php');
            };
        } catch (Exception $e) {
            die("Erreur de l'authentification: ". $e->getMessage());
        };
        ?>
    </body>
</html>