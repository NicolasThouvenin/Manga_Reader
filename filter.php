<?php

	require('connection.php');

	function getComicsIds($keyWord) {

		$param = "%{$keyWord}%";

		$query = "SELECT DISTINCT comics.Id FROM comics
					JOIN authors
					ON authors.comicId = comics.Id
					JOIN users
					ON authors.userId = users.Id
					WHERE LOWER(users.Login) LIKE :param OR LOWER(users.Firstname) LIKE :param OR LOWER(users.Surname) LIKE :param";


					$query = "SELECT Id FROM comics WHERE Title LIKE :param";

		$result = $db->prepare($query);
		$result->execute(array('param' => $param));

	    while ($line = $result->fetch()) {
        	yield $line['Id'];
        }
	}

	function getComicsIdsByName($keyWord) {

		$param = "%{$keyWord}%";

		$query = "SELECT Id FROM comics WHERE Title LIKE :param";
		$result = $db->prepare($query);
		$result->execute(array('param' => $param));

		while ($line = $result->fetch()) {
        	yield $line['Id'];
        }
	}


?>