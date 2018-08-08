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
            
            $checkedData = checkData($_POST);

            if (!isset($_SESSION['uniqid'])) {
                throw new Exception("La requête post d'authentification ne possède pas de token correspondant à un formulaire envoyé par le serveur");
            } else if ($_SESSION['uniqid'] != $checkedData['uniqid']) {
                throw new Exception("La requête post n'indique pas pas le même token d'authentification que celui de la session du serveur");
            }

            $logger = $db->prepare("SELECT users.* FROM users WHERE Login = :login AND password = PASSWORD(:password);");

            $logger->execute(array('login' => $checkedData['login'], 'password' => $checkedData['password']));

            if ($logger->rowCount() == 1) {
                while ($line = $logger->fetch()) {
                    $authentified = new Authentified($line['Id'], $_SESSION['uniqid']);
                    $authentifiedSerialized = serialize($authentified);

                    if (isset($checkedData['stayConnected'])) {
                        $expiry = time()+86400*365; //expire au bout d'un an
                    } else {
                        $expiry = time()-1; //expire à la fin de la session
                    }
                    setcookie ('authentified', $authentifiedSerialized, $expiry); //expire à la fin de la session
                    setcookie('cookieExpiryDate', $expiry, $expiry);
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