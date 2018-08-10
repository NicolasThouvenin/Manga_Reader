<?php

	class Author extends User {

		/* Cette classe correspond aux informations sur un auteur et donne accès à ses bandes dessinnées. */

		private $Comics = array();
		private $ComicsLoaded = false;

		public function __construct(int $Id) {
			parent::__construct($Id);
		}

		private function SetComics() {
			/* Cette fonction permet de créer un array d'objet comics à partir d'une sélection sur la base de données */
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
                throw new Exception("<br>Erreur lors de la création de la liste de comics : ".$e->getMessage());
            }

		}

		function getComics() {
				/* Cette fonction est un générateur permettant d'accéder aux objets comic d'un auteur */
			if (!$this->ComicsLoaded) {
				//On ne crée la liste d'objets comics que si on en a besoin car l'objet Author peut être utilisé sans qu'on ai besoin de ses comics
				$this->SetComics();
				$this->ComicsLoaded = true;
			}
        	foreach ($this->Comics as $comic) {
                yield $comic;
            }
        }
	}
?>
