<?php

    class Comic {
        
        protected $Id;
        private $Title;
        private $Synopsis;
        private $StartDate;
        private $EndDate;
        private $CoverExt;
        private $volumesLoaded = false;
        private $Volumes = array();
        private $GenreIdsLoaded = false;
        private $GenreIds = array();
        private $AuthorsLoaded = false;
        private $Authors = array();

        public function __construct(int $Id) {

            $this->Id = $Id;

            require('connection.php');

            $result = $db->prepare("SELECT * FROM comics WHERE id = :comicId");
            $result->execute(array('comicId' => 1));

            while ($line = $result->fetch()) {

                $this->Title = $line['Title'];
                $this->Synopsis = $line['Synopsis'];
                $this->StartDate = $line['StartDate'];
                $this->CoverExt = $line['CoverExt'];

                if ($line['EndDate'] === null) {
                    $this->EndDate = '';
                } else {
                    $this->EndDate = $line['EndDate'];
                }
            }

            $this->SetGenreIds();
            $this->SetAuthors();
        }
        
        function getId() {
            return $this->Id;
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

        function getCoverExt() {
            return $this->CoverExt;
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

        function setCoverExt($CoverExt) {
            $this->CoverExt = $CoverExt;
        }

        private function SetVolumes() {
            require('connection.php');
            
            $result = $db->prepare("SELECT * FROM volumes WHERE comicId = :comicId");
            $result->execute(array('comicId' => $this->Id));

            while ($line = $result->fetch()) {

                if ($line['EndDate'] === null) {
                    $endDate = '';
                } else {
                    $endDate = $line['EndDate'];
                }

                $volume = new Volume($line['Id'], $line['Number'], $line['Title'], $line['Synopsis'], $line['StartDate'], $endDate);

                $this->Volumes[$line['Id']] = $volume;
            }
        }

        public function getVolumes() {
            if (!$this->volumesLoaded) {
               $this->SetVolumes();
               $this->volumesLoaded = true;
            }
            
            foreach ($this->Volumes as $volume) {
                yield $volume;
            }
        }

        private function SetGenreIds() {
        	require('connection.php');
            
            $result = $db->prepare("SELECT genreId FROM comicsgenres WHERE comicId = :comicId");
            $result->execute(array('comicId' => $this->Id));

            while ($line = $result->fetch()) {
            	array_push($this->GenreIds, $line['genreId']);
            }
        }

        function getGenreIds() {
            if (!$this->GenreIdsLoaded) {
                $this->SetGenreIds();
                $this->GenreIdsLoaded = true;
            }
        	foreach ($this->GenreIds as $genreId) {
                yield $genreId;
            }
        }

        private function SetAuthors() {

        	require('connection.php');

        	$query = "SELECT users.* FROM users 
        	JOIN authors
        	ON users.Id = authors.userId
        	WHERE authors.comicId = :comicId";
            
            $result = $db->prepare($query);
            $result->execute(array('comicId' => $this->Id));

            while ($line = $result->fetch()) {
            	$author = new Author($line['Id']);
            	$this->Authors[$line['Id']] = $author;
            }
        }

        function getAuthors() {
            if (!$this->AuthorsLoaded) {
                $this->SetAuthors();
                $this->AuthorsLoaded = true;
            }
        	foreach ($this->Authors as $author) {
                yield $author;
            }
        }        

    }
?>