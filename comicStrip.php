<?php 
	/* Cette classe regroupe les information et méthode relatif à un Comic strip
	L'objet est construit à partir des informations de la base de données et permet de pousser des données sur la base et sur le serveur de fichier.*/

	class ComicStrip
	{
		private $Id;
		private $Number;
		private $FileName;
		
		function __construct(int $Id, int $Number, string $FileName) {
			$this->Id = $Id;
			$this->Number = $Number;
			$this->FileName = $FileName;
		}

        function getId() {
            return $this->Id;
        }

        function getNumber() {
            return $this->Number;
        }

        function getFileName() {
            return $this->FileName;
        }

        function setNumber($Number) {
            $this->Number = $Number;
        }

        function setFileName($FileName) {
            $this->FileName = $FileName;
        }
	}   
?>