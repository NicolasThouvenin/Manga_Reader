<?php
	require('connection.php');
	require('comic.class.php');

	$result = $db->prepare("SELECT * FROM comics WHERE id = :comicId");
	$result->execute(array('comicId' => 1));

	while ($line = $result->fetch()) {

		if ($line['EndDate'] === null) {
			$endDate = '';
		} else {
			$endDate = $line['EndDate'];
		}
		$comic = new Comic($line['Id'], $line['Title'], $line['Synopsis'], $line['StartDate'], $endDate, $line['CoverExt']);
		$serializedComic = serialize($comic);
		echo $serializedComic;
	}
?>