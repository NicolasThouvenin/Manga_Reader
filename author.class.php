<?php

	class Author extends User {

		private $Comics = array();
		private $ComicsLoaded = false;

		public function __construct(int $Id) {
			$this->Id = $Id;
		}

		private function SetComics() {
            $result = $db->prepare("SELECT comics.Id FROM comics WHERE Id = :comicId");
            $result->execute(array('comicId' => $this->Id));

            while ($line = $result->fetch()) {

            	$comic = Comic($line['Id']);
            	$this->Comics[$line['Id']] = $comic;
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