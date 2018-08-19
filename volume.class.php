<?php

	class Volume {

		/* This class reprents a volume */

	    private $Id;
	    private $Number;
	    private $Title;
	    private $Synopsis;
	    private $StartDate;
	    private $EndDate;
	    private $Chapters = array();
	    private $LastChapterNumber = -1;

	    public function __construct(int $Id, int $Number, string $Title, string $Synopsis, string $StartDate, string $EndDate) {
	        $this->Id = $Id;
	        $this->Number = $Number;
	        $this->Title = $Title;
	        $this->Synopsis = $Synopsis;
	        $this->StartDate = $StartDate;
	        $this->EndDate = $EndDate;
	        $this->ChaptersLoaded = false;
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
	    	/* This metode  function create an array of chapter objects. It queries the database itself */
	        try {
	            require('connection.php');

	            $result = $db->prepare("SELECT * FROM chapters WHERE volumeId = :volumeId ORDER BY Number");
	            $result->execute(array('volumeId' => $this->Id));

	            while ($line = $result->fetch()) {

	                $validated = ($line['Validated'] === '1' ? true : false);

	                if ($line['PublicationDate'] === null) {
	                    $publicationDate = '';
	                } else {
	                    $publicationDate = $line['PublicationDate'];
	                }

	                $chapter = new Chapter($line['Id'], $line['Number'], $line['Title'], $line['Synopsis'], $validated, $publicationDate);

	                $this->Chapters[$line['Number']] = $chapter;
	                $this->LastChapterNumber = $line['Number'];
	            }
	        } catch (Exception $e) {
	            throw new Exception("<br>Error during the creation of chapter objects array : " . $e->getMessage());
	        }
	    }

	    public function getChapters() {
	        if (!$this->ChaptersLoaded) {
	            $this->SetChapters();
	            $this->ChaptersLoaded = true;
	        }
	        foreach ($this->Chapters as $chapter) {
	            yield $chapter;
	        }
	    }

	    public function getLastChapterNumber() {
	        if (!$this->ChaptersLoaded) {
	            $this->SetChapters();
	            $this->ChaptersLoaded = true;
	        }
	        return $this->LastChapterNumber;
	    }

	    public function getLastChapter() {
	        $chapter = $this->chapters[$this->getLastChapterNumber()];
	        return $chapter;
	    }

	    public function getLastChapterId() {
	        return $this->getLastChapter()->Id;
	    }

	    public function isEmpty() {
	        return ($this->getLastChapterNumber() == -1);
	    }

	}

?>