<?php

    /*
        Cette classe représente un chapitre de comic. Elle permet d'accéder et de modifier au information de celle-ci sur la base de données.
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
            /* Cette fonction permet de créer une liste d'objet comicstrip (vignettes) d'un chapitre à partir de la base de données */
            try {

                require('connection.php');

                $result = $db->prepare("SELECT * FROM comicstrips WHERE chapterId = :chapterId");
                $result->execute(array('chapterId' => $this->Id));

                while ($line = $result->fetch()) {
                    $comicStrip = new ComicStrip($line['Id'], $line['Number'], $line['fileName']);
                    $this->comicStrips[$line['Id']] = $comicStrip;
                }
            } catch (Exception $e) {
                throw new Exception("<br>Erreur lors de la création de la liste de d'objets comicStrip : ". $e->getMessage());
            }
        }

        function GetComicStrips() {
            /* 
                Cette function est un générateur renvoyant tout les comicstrips (vignettes) d'un chapitre dans l'ordre des numéros.
                Les éléments sont renvoyés dans le bon ordre grâce aux numéros.
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
                Cette fonction permet d'ajouter un nouveau comicStrip (vignette) dans la base de données et de chargé l'image sur le serveur d'image.
                Afin de géner l'apiration des images par des robotsles images ont un nom aléatoire.
            */
            try {

                if (!$this->ComicStripsLoaded) {
                    $this->SetComicStrips();
                    $this->ComicStripsLoaded = true;
                }

                $Filename = hash('sha256', uniqid()).'.'.$this->GetExtension($comicStripTmpName);
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
                    throw new Exception("<br>Le fichier n'a pas pu être poussé sur le serveur");
                }
            } catch (Exception $e) {
                throw new Exception("<br>Erreur lors de l'ajout du nouveau comicStrip : " . $e->getMessage());
            }
        }

        private function SetChapterImagesFolder() {
            /* Cette fonction sert à créer le dossier sur le serveur d'image où les images d'un chapitre seront stockées */
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
                throw new Exception("<br>Erreur lors de la recherche du chemin du dossier image du chapitre : " . $e->getMessage());
            }
        }

        private function GetExtension($tmpName) {
            /*
                Cette fonction permet de rechercher l'extension d'un fichier et de valider qu'il s'agisse bien d'une image.
                Cela évite d'uploader des fichiers potentiellement dangereux sur le serveur.
            */
            $check = explode('/', mime_content_type($tmpName));
            if ($check[0] !== 'image') {
                throw new Exception("<br>Le fichier n'est pas une image : " . $e->getMessage());
            } else {
                return $check[1];
            }
        }

    }
?>