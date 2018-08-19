<?php

	class Author extends User {

		/* This class has the author data. It give access to its comics. */

		private $Comics = array();
		private $ComicsLoaded = false;

		public function __construct(int $Id) {
			parent::__construct($Id);
		}

		private function SetComics() {
			/* This method creates an array with comic objects set up by a database query */
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
                throw new Exception("<br>Error during the creation of an array with comic objetcs : ".$e->getMessage());
            }

		}

		function getComics() {
				/* This method is an generator that return each comic objects of the author */
			if (!$this->ComicsLoaded) {
				//The array of comic objects is created only if necessary
				$this->SetComics();
				$this->ComicsLoaded = true;
			}
        	foreach ($this->Comics as $comic) {
                yield $comic;
            }
        }
	}
?>
