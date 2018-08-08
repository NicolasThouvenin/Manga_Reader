<?php

	

	function getComicsIdsByAuthors($keyWordLower) {

		require('connection.php');

		$param = "%{$keyWordLower}%";

		$query = "SELECT DISTINCT comics.Id, CONCAT(users.Login, ' (', users.Firstname, ' ', users.Surname, ')') AS Author FROM comics
					JOIN authors
					ON authors.comicId = comics.Id
					JOIN users
					ON authors.userId = users.Id
					WHERE CONCAT(LOWER(users.Login), ' (', LOWER(users.Firstname), ' ', LOWER(users.Surname), ')') LIKE :param";

		$result = $db->prepare($query);
		$result->execute(array('param' => $param));

	    while ($line = $result->fetch()) {
        	yield $line;
        }
	}

	function getComicsIdsByTitle($keyWordLower) {

		require('connection.php');

		$param = "%{$keyWordLower}%";

		$query = "SELECT Id, Title FROM comics WHERE Title LIKE :param";
		$result = $db->prepare($query);
		$result->execute(array('param' => $param));

		while ($line = $result->fetch()) {
        	yield $line;
        }
	}

	$keyWordLower = strtolower($_GET['keyword']);

	$foundComics = array();

	foreach (getComicsIdsByTitle($keyWordLower) as $foundComic) {
		$foundComics[$foundComic['Title']] = $foundComic['Id'];
	}

	foreach (getComicsIdsByAuthors($keyWordLower) as $foundComic) {
		$foundComics[$foundComic['Author']] = $foundComic['Id'];
	}

	header('Content-type: application/json');

	echo json_encode($foundComics);

?>