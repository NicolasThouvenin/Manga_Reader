<?php 
	

	function checkData($data) {
	    foreach ($data as $key => $value) {
	        $data[$key] = htmlentities($value);
	    }
	    return $data;
	}



    if (isset($_COOKIE['authentified'])) {

    	require('required.php');

    	session_start();

    	$checkedData = checkData($_POST);

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