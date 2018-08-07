<?php

	class Author extends User {

		/* Cette classe correspond aux informations sur un auteur et donne accès à ses bandes dessinnées. */

		private $Comics = array();
		private $ComicsLoaded = false;

		public function __construct(int $Id) {
			parent::__construct($Id);
		}

		private function SetComics() {
			try {
				require('connection.php');
				$query = "SELECT comics.Id FROM comics
				JOIN authors
				ON comics.Id = authors.comicId
				WHERE authors.userId = :authorId;";

				$result = $db->prepare($query);
	            $result->execute(array('authorId' => $this->Id));

	            while ($line = $result->fetch()) {
	            	$comic = new Comic($line['Id']);
	            	$this->Comics[$line['Id']] = $comic;
	            }
			}  catch (Exception $e) {
                throw new Exception("\nErreur lors de la création du token dans la base de données : ".$e->getMessage());
            }

		}

		function getComics() {
			if (!$this->ComicsLoaded) {
				//On ne crée la liste d'objet comic que si on en a besoin car l'objet Auther peut être utilisé sans qu'on ai besoin de ces comics
				$this->SetComics();
				$$this->ComicsLoaded = true;
			}
        	foreach ($this->Comics as $comic) {
                yield $comic;
            }
        }
	}
?>
