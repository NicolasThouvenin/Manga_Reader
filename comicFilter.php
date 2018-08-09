<?php

	/* 
		Cette page intérroge la base de données à partir d'un mot clé reçus en GET.
		Elle regarde si le mot clé correspond partiellement à un nom d'auteur ou à un titre de comic.
		Et renvoi un "JSON" avec comme clé le mot clé d'origine et comme valeur les identifiants de comic.
	*/

	function getComicsIdsByAuthors($keyWordLower) {

		require('connection.php');

		$param = "%{$keyWordLower}%";

		$query = "SELECT DISTINCT comics.Id, CONCAT(users.Login, ' (', users.Firstname, ' ', users.Surname, ')') AS Author FROM comics
					JOIN authors
					ON authors.comicId = comics.Id
					JOIN users
					ON authors.userId = users.Id
					WHERE CONCAT(LOWER(users.Login), LOWER(users.Firstname), LOWER(users.Surname)) LIKE :param";

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
		$foundComics[$foundComic['Title']] = [$foundComic['Id']];
	}

	foreach (getComicsIdsByAuthors($keyWordLower) as $foundComic) {
		//On gère le fait qu'un auteur peut avoir plusieurs comics
		if (array_key_exists($foundComic['Author'], $foundComics)) {
			$foundComics[$foundComic['Author']][] = $foundComic['Id'];
		} else {
			$foundComics[$foundComic['Author']] = [$foundComic['Id']];
		};		
	}

	header('Content-type: application/json');

	echo json_encode($foundComics);

	/*
		Structure du "JSON"
		{ 	"nom d'auteur X" : [liste de comic Id],
			"Titre de comic Y" : [liste de comic Id],
			...
		}
	*/

?>