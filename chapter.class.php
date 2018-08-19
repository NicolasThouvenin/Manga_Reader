<?php

    /*
        This class representes a chapter of comic.
        It provides access and modification in the database and in the files server.
    */

    class Chapter {

        private $Id;
        private $Number;
        private $Title;
        private $Synopsis;
        private $Validated;
        private $PublicationDate;
        private $comicStrips = array();
        private $comicStripsLoaded = false;
        private $chapterImagesFolder;

        public function __construct(int $Id, int $Number, string $Title, string $Synopsis, bool $Validated, string $PublicationDate) {
            $this->Id = $Id;
            $this->Number = $Number;
            $this->Title = $Title;
            $this->Synopsis = $Synopsis;
            $this->Validated = $Validated;
            $this->PublicationDate = $PublicationDate;
            $this->ComicStripsLoaded = false;
            $this->ComicStrips = array();
            $this->SetChapterImagesFolder();
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
            /* This method creates an array of comicstrip objetcs with data from database */
            try {

                require('connection.php');

                $result = $db->prepare("SELECT * FROM comicstrips WHERE chapterId = :chapterId");
                $result->execute(array('chapterId' => $this->Id));

                while ($line = $result->fetch()) {
                    $comicStrip = new ComicStrip($line['Id'], $line['Number'], $line['fileName']);
                    $this->comicStrips[$line['Id']] = $comicStrip;
                }
            } catch (Exception $e) {
                throw new Exception("<br>Error during the creation of the array of comicstrip objetcs : ". $e->getMessage());
            }
        }

        function GetComicStrips() {
            /* 
                This method returns all comicstrip of the chapter sorted by number.
             */
            if (!$this->ComicStripsLoaded) {
                $this->SetComicStrips();
                $this->ComicStripsLoaded = true;
            }

            $sortedComicIds = array();
            foreach ($this->ComicStrips as $comicStrip) {
                $sortedComicIds[$comicStrip->getNumber()] = $comicStrip->getId();
            }
            krsort($sortedComicIds);

            foreach ($this->sortedComicIds as $comicStripId) {
                yield $this->ComicStrips[$comicStripId];
            }
        }

        function AddComicStrip($comicStripTmpName) {
            /*
                This method adds new comicstrip in the database and in the files server.
            */
            try {

                if (!$this->ComicStripsLoaded) {
                    $this->SetComicStrips();
                    $this->ComicStripsLoaded = true;
                }

                $Filename = hash('sha256', uniqid()).'.'.$this->GetExtension($comicStripTmpName); //In order to protect images from aspiration, a crypted name is use.
                $FilePath = $this->chapterImagesFolder.'\\'. $Filename;

                if (move_uploaded_file($comicStripTmpName, $FilePath)) {

                    require('connection.php');

                    $addComicStrip = $db->prepare("CALL createComicStrip(:fileName, :chapterId, @lastComicStripId, @lastComicStripNumber)");
                    $addComicStrip->bindParam(':fileName', $Filename, PDO::PARAM_STR, 75);
                    $addComicStrip->bindParam(':chapterId', $this->Id, PDO::PARAM_INT);
                    $addComicStrip->execute();

                    $addComicStrip->closeCursor();
                    $result = $db->query("SELECT @lastComicStripId, @lastComicStripNumber")->fetch(PDO::FETCH_ASSOC);

                    $comicStrip = new ComicStrip($result['@lastComicStripId'], $result['@lastComicStripNumber'], $Filename);
                    $this->ComicStrips[$result['@lastComicStripId']] = $comicStrip;
                } else {
                    throw new Exception("<br>The file could not send to the files server");
                }
            } catch (Exception $e) {
                throw new Exception("<br>Error during the comicstrip addition : " . $e->getMessage());
            }
        }

        private function SetChapterImagesFolder() {
            /* This method creates a folder in the files server. The chapter's images are put in this folder */
            try {

                require('connection.php');

                $getChapterImagesFolder = $db->prepare("CALL getChapterFolderPath(:chapterId, @chapterFolderPath)");
                $getChapterImagesFolder->bindParam(':chapterId', $this->Id, PDO::PARAM_INT);
                $getChapterImagesFolder->execute();

                $getChapterImagesFolder->closeCursor();
                $result = $db->query("SELECT @chapterFolderPath")->fetch(PDO::FETCH_ASSOC);

                $this->chapterImagesFolder = 'comics' . '\\' . $result['@chapterFolderPath'];

                if (!file_exists($this->chapterImagesFolder)) {
                    mkdir($this->chapterImagesFolder, 0777, true);
                }
            } catch (Exception $e) {
                throw new Exception("<br>Error during the images folder creation of the chapter : " . $e->getMessage());
            }
        }

        private function GetExtension($tmpName) {
            /*
                This method get the extension of a file and checks if it is a true image file.
                It is a method to avoid uploading dangerous files in the files server.
            */
            $check = explode('/', mime_content_type($tmpName));
            if ($check[0] !== 'image') {
                throw new Exception("<br>This file is not an image : " . $e->getMessage());
            } else {
                return $check[1];
            }
        }

    }
?>