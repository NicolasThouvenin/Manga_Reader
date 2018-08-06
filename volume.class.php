<?php 

    require('chapter.class.php'); 

	class Volume {
		private $Id;
		private $Number;
	    private $Title;
	    private $Synopsis;
	    private $StartDate;
	    private $EndDate;
	    private $Chapters = array();


		public function __construct(int $Id, int $Number, string $Title, string $Synopsis, string $StartDate, string $EndDate) {
	      $this->Id = $Id;
	      $this->Number = $Number;
	      $this->Title = $Title;
	      $this->Synopsis = $Synopsis;
	      $this->StartDate = $StartDate;
	      $this->EndDate = $EndDate;
          $this->SetChapters();
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

        private function SetChapters() {

            require('connection.php');
                       

            $result = $db->prepare("SELECT * FROM chapters WHERE volumeId = volumeId");
            $result->execute(array('volumeId' => $this->Id));

            while ($line = $result->fetch()) {

                $validated = ($line['Validated'] === '1' ? true : false);

                if ($line['PublicationDate'] === null) {
                    $publicationDate = '';
                } else {
                    $publicationDate = $line['PublicationDate'];
                }

                $chapter = new Chapter($line['Id'], $line['Number'], $line['Title'], $line['Synopsis'], $validated, $publicationDate);

                $this->Chapters[$line['Id']] = $chapter;
            }
        }

        public function getChapters() {
            foreach ($this->Chapters as $chapter) {
                yield $chapter;
        }
    }

	}
?>