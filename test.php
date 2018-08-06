<?php
	require('connection.php');
	require('comic.class.php');
	require('volume.class.php');
	require('chapter.class.php');
	require('user.class.php');
	require('author.class.php');
	require('authentified.class.php');
	

	$result = $db->prepare("SELECT * FROM comics WHERE id = :comicId");
	$result->execute(array('comicId' => 1));

	while ($line = $result->fetch()) {

		if ($line['EndDate'] === null) {
			$endDate = '';
		} else {
			$endDate = $line['EndDate'];
		}
		$comic = new Comic($line['Id'], $line['Title'], $line['Synopsis'], $line['StartDate'], $endDate, $line['CoverExt']);
		
		echo $comic->getTitle().'<br>';
		foreach ($comic->getAuthors() as $author) {
			echo 'Auteur : '.$author->getLogin().'<br>';
		}
		foreach ($comic->getVolumes() as $volume) {
			echo '.... '.$volume->getTitle().'<br>';
			foreach ($volume->getChapters() as $chapter) {
				echo '........ '.$chapter->getTitle().'<br>';
			}
		}
	}
?>