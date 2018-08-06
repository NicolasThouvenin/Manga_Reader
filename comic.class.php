<?php

    require('volume.class.php');

    class Comic {
        
        private $Id;
        private $Title;
        private $Synopsis;
        private $StartDate;
        private $EndDate;
        private $CoverExt;
        private $Volumes = array();
        private $GenreIds = array();
        private $Authors = array();


        public function __construct(int $Id, string $Title, string $Synopsis, string $StartDate, string $EndDate, string $CoverExt) {
          $this->Id = $Id;
          $this->Title = $Title;
          $this->Synopsis = $Synopsis;
          $this->StartDate = $StartDate;
          $this->EndDate = $EndDate;
          $this->CoverExt = $CoverExt;
          $this->SetVolumes();
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
            	$token = ''; //Cette utilisateur n'est pas connecté
            	$author = new User($line['Id'], $line['Login'], $line['Firstname'], $line['Surname'], $line['BirthDate'], $line['Email'], $line['EmailValidated'], $token);
            	$this->Authors[$line['Id']] = $author;
            }
        }

        function getAuthors() {
        	foreach ($this->Authors as $author) {
                yield $author;
            }
        }        

    }
?>