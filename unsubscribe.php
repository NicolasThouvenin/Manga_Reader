<?php
    try {
        require('connection.php');
        require('required.php');
        session_start();

        if (!isset($_SESSION['uniqidUnsubscribe'])) {
            throw new Exception("La requête post de suppression de compte ne possède pas de token correspondant à un formulaire envoyé par le serveur");
        } else if ($_SESSION['uniqidUnsubscribe'] != $_POST['uniqidUnsubscribe']) {
            throw new Exception("La requête post de suppression de compte n'indique pas le même token d'authentification que celui de la session du serveur");
        }

        if (isset($_COOKIE['authentified'])) {

            $authentified = unserialize($_COOKIE['authentified']);

            if ($authentified->CheckToken()) {

                $deleteUser = $db->prepare("UPDATE users SET Unsubscribed = 1 where Id = :Id;");
                $id = $authentified->getId();
                $deleteUser->bindParam(':Id', $id, PDO::PARAM_INT);
                $deleteUser->execute();

            } else {
                throw new Exception("<br>Erreur lors de la vérification du token du cookie authentified.");
            }
        }
        header("Location:disconnect.php"); //On utilise la page disconnect.php pour supprimer les cookies et les informations personnelles de la session.

    } catch (Exception $e) {
        die("Erreur lors de la désincription: ". $e->getMessage());
    };
?>