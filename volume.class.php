<?php 

	class Volume {
		private $Id;
		private $Number;
	    private $Title;
	    private $Synopsis;
	    private $StartDate;
	    private $EndDate;
	    private $Volumes = array();


		public function __construct(int $Id, int $Number, string $Title, string $Synopsis, string $StartDate, string $EndDate) {
	      $this->Id = $Id;
	      $this->Number = $Number;
	      $this->Title = $Title;
	      $this->Synopsis = $Synopsis;
	      $this->StartDate = $StartDate;
	      $this->EndDate = $EndDate;
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

        function getStartDate() {
            return $this->StartDate;
        }

        function getEndDate() {
            return $this->EndDate;
        }

        function getVolumes() {
            return $this->Volumes;
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

        function setStartDate($StartDate) {
            $this->StartDate = $StartDate;
        }

        function setEndDate($EndDate) {
            $this->EndDate = $EndDate;
        }

        function setVolumes($Volumes) {
            $this->Volumes = $Volumes;
        }

	}
?>