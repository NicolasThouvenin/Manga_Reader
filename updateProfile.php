<?php
	/* Cette page reçoit les élément du formulaire de profile et met à jour les informations d'un utilisateurs dans la base */
    if (isset($_COOKIE['authentified'])) {

    	require('required.php');

    	session_start();

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

	header("Location:profile.php");
?>