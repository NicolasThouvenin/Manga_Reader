<!DOCTYPE html>
<html>
    <head>
        <title>Authentication check</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
 
        try {
            require('required.php');
            require('connection.php');
            session_start();
            
            $checkedData = Util::checkPostData($_POST);

            if (!isset($_SESSION['uniqidLogin'])) {
                throw new Exception("La requête post d'authentification ne possède pas de token correspondant à un formulaire envoyé par le serveur");
            } else if ($_SESSION['uniqidLogin'] != $checkedData['uniqidLogin']) {
                throw new Exception("La requête post n'indique pas pas le même token d'authentification que celui de la session du serveur");
            }

            $logger = $db->prepare("SELECT users.* FROM users WHERE Login = :login AND password = PASSWORD(:password) AND EmailValidated = 1 AND Unsubscribed = 0;");

            $logger->execute(array('login' => $checkedData['login'], 'password' => $checkedData['password']));

            if ($logger->rowCount() == 1) {
                while ($line = $logger->fetch()) {
                    if ($line['Unsubscribed'] == 0) {
                        $authentified = new Authentified($line['Id']);
                        $authentifiedSerialized = serialize($authentified);

                        if (isset($checkedData['stayConnected'])) {
                            $expiry = time()+86400*365; //expire au bout d'un an
                        } else {
                            $expiry = 0; //expire à la fin de la session
                        }
                        setcookie ('authentified', $authentifiedSerialized, $expiry); //expire à la fin de la session
                        setcookie('cookieExpiryDate', $expiry, $expiry);
                    } else {
                        header('Location: register.php');
                    }
                }

                $logger->closeCursor();
                header('Location: homePage.php');
            } else {
                $logger->closeCursor();
                header('Location: login.php');
            }
        } catch (Exception $e) {
            die("Authentication Error: ". $e->getMessage());
        }
        ?>
    </body>
</html>