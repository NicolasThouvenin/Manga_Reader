<?php 

	class Chapter {
        
		private $Id;
		private $Number;
	    private $Title;
	    private $Synopsis;
        private $Validated;
	    private $PublicationDate;
        private $comicStrips = array();


		public function __construct(int $Id, int $Number, string $Title, string $Synopsis, bool $Validated, string $PublicationDate) {
	      $this->Id = $Id;
	      $this->Number = $Number;
	      $this->Title = $Title;
	      $this->Synopsis = $Synopsis;
	      $this->Validated = $Validated;
	      $this->PublicationDate = $PublicationDate;
          $this->ComicStripsLoaded = false;
	    }

        function getId() {
            return $this->Id;
        }

        function getNumber() {
            return $this->Number;
        }

        function getTitle() {
            return $this->Title;
        }

        function getSynopsis() {
            return $this->Synopsis;
        }

        function getValidated() {
            return $this->Validated;
        }

        function getPublicationDate() {
            return $this->PublicationDate;
        }

        function setNumber($Number) {
            $this->Number = $Number;
        }

        function setTitle($Title) {
            $this->Title = $Title;
        }

        function setSynopsis($Synopsis) {
            $this->Synopsis = $Synopsis;
        }

        function setValidated($Validated) {
            $this->Validated = $Validated;
        }

        function setPublicationDate($PublicationDate) {
            $this->PublicationDate = $PublicationDate;
        }

        private function SetComicStrips() {
            $this->comicStrips = '';
        }

        function GetComicStrips() {
            if (!$this->ComicStripsLoaded) {
                $this->SetComicStrips();
                $this->ComicStripsLoaded = true;
            }
            $this->comicStrips;
        }
	}
?>