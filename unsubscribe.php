<?php
    try {
        require('connection.php');
        session_start();

        if (isset($_COOKIE['authentified'])) {

            $authentified = unserialize($_COOKIE['authentified']);

            if ($authentified->CheckToken()) {

                $deleteUser = $db->prepare("DELETE FROM users where Id = :Id;");
                $deleteUser->bindParam(':Id', $authentified->getId(), PDO::PARAM_INT);
                $deleteUser->execute();

            } else {
                throw new Exception("<br>Erreur lors de la vérification du token du cookie authentified.");
            }

        }
        header("Location:homePage.php");

    } catch (Exception $e) {
        die("Erreur lors de la désincription: ". $e->getMessage());
    };
?>