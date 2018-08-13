<?php
	/* Cette page reçoit les élément du formulaire de profile et met à jour les informations d'un utilisateurs dans la base */
    try {
        if (isset($_COOKIE['authentified'])) {

            require('required.php');

            session_start();

            if (!isset($_SESSION['uniqidProfil'])) {
                throw new Exception("La requête post de mise à jour du profil ne possède pas de token correspondant à un formulaire envoyé par le serveur");
            } else if ($_SESSION['uniqidProfil'] != $checkedData['uniqidProfil']) {
                throw new Exception("La requête post de mise à jour du profil n'indique pas le même token d'authentification que celui de la session du serveur");
            }

            $checkedData = Util::checkPostData($_POST);

            $authentified = unserialize($_COOKIE['authentified']);

            $authentified->setLogin($checkedData['login']);
            $authentified->setFirstname($checkedData['firstname']);
            $authentified->setSurname($checkedData['surname']);
            $authentified->setBirthDate($checkedData['birthDate']);

            $authentified->updateUser();

            unset($_COOKIE['authentified']);

            $authentifiedSerialized = serialize($authentified);

            $expiry = $_COOKIE['cookieExpiryDate'];

            setcookie ('authentified', $authentifiedSerialized, $expiry);
        }     
    } catch (Exception $e) {
        die('Error lors de la mise à jour du profil utilisateur : ' . $e->getMessage());
    }


	header("Location:profile.php");
?>