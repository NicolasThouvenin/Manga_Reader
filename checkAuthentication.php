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
                throw new Exception("The authentication post request has not token like the form token");
            } else if ($_SESSION['uniqidLogin'] != $checkedData['uniqidLogin']) {
                throw new Exception("The authentication post request has a different token as form token");
            }

            $logger = $db->prepare("SELECT users.* FROM users WHERE Login = :login AND password = PASSWORD(:password) AND EmailValidated = 1 AND Unsubscribed = 0;");

            $logger->execute(array('login' => $checkedData['login'], 'password' => $checkedData['password']));

            if ($logger->rowCount() == 1) {
                while ($line = $logger->fetch()) {
                    if ($line['Unsubscribed'] == 0) {
                        $authentified = new Authentified($line['Id']);
                        $authentifiedSerialized = serialize($authentified);

                        if (isset($checkedData['stayConnected'])) {
                            $expiry = time()+86400*365; //expires after one year
                        } else {
                            $expiry = 0; //expires after the session end
                        }
                        setcookie ('authentified', $authentifiedSerialized, $expiry);
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
            die("Authentication error: ". $e->getMessage());
        }
        ?>
    </body>
</html>