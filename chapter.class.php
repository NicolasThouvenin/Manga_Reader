<?php 

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
            try {
                require('connection.php');    

                $result = $db->prepare("SELECT * FROM comicStrips WHERE chapterId = :chapterId");
                $result->execute(array('chapterId' => $this->Id));

                while ($line = $result->fetch()) {
                    $comicStrip = new ComicStrip($line['Id'], $line['Number'], $line['fileName']);
                    $this->comicStrips[$line['Id']] = $comicStrip;
                }
            } catch (Exception $e) {
                throw new Exception("\nErreur lors de la création de la liste de d'objets comicStrip : ".$e->getMessage());
            }
        }

        function GetComicStrips() {
            /* cette function est un générateur renvyant tout les comicstrip d'un chapitre dans l'ordre des numéros */
            if (!$this->ComicStripsLoaded) {
                $this->SetComicStrips();
                $this->ComicStripsLoaded = true;
            }

            $sortedComicIds = array();
            foreach ($this->ComicStrips as $comicStrip) {
                $sortedComicIds[$comicStrip->Number] = $comicStrip->Id;
            }
            krsort($sortedComicIds);

            foreach ($this->sortedComicIds as $comicStripId) {
                yield $this->ComicStrips[$comicStripId];
            }
            $this->ComicStrips;
        }

        function AddComicStrip($bubbleTmpName) {

            try {

                if (!$this->ComicStripsLoaded) {
                    $this->SetComicStrips();
                    $this->ComicStripsLoaded = true;
                }

                $Filename = hash('sha256', uniqid()).'.'.$this->GetExtension($bubbleTmpName);
                $FilePath = 'comics\\'.$this->chapterImagesFolder.'\\'.$Filename;

                if(move_uploaded_file($bubbleTmpName, $FilePath)) {

                    $addComicStrip = $db->prepare('CALL createComicStrip(:fileName, :chapterId, @lastComicStripId)');
                    $addComicStrip->bindParam(':fileName', $Filename, PDO::PARAM_STR, 75);
                    $addComicStrip->bindParam(':chapterId', $this->Id, PDO::PARAM_INT);
                    $addComicStrip->execute();

                    $addComicStrip->closeCursor();
                    $result = $db->query("SELECT @lastComicStripId")->fetch(PDO::FETCH_ASSOC);

                    $comicStrip = new ComicStrip($result['@lastComicStripId'], $Number, $Filename);
                    $this->ComicStrips[$result['@lastComicStripId']] = $comicStrip;

                } else {
                    throw new Exception("\nLe fichier n'a pas pu être poussé sur le serveur");
                }

            } catch (Exception $e) {
                throw new Exception("\nErreur lors de l'ajout du nouveau comicStrip : ".$e->getMessage());
            }
        }

        private function SetChapterImagesFolder() {

            try {

                $getChapterImagesFolder = $db->prepare('CALL createComicStrip(:chapterId, @chapterFolderPath)';
                $getChapterImagesFolder->bindParam(':chapterId', $this->Id, PDO::PARAM_INT);
                $getChapterImagesFolder->execute();

                $getChapterImagesFolder->closeCursor();
                $result = $db->query("SELECT @chapterFolderPath")->fetch(PDO::FETCH_ASSOC);

                $this->chapterImagesFolder = $result['@chapterFolderPath'];

            } catch (Exception $e) {
                throw new Exception("\nErreur lors de la recherche du chemin du dossier image du chapitre : ".$e->getMessage());
            }
        }

        private function GetExtension($tmpName) {
            $check = explode('/', mime_content_type($tmpName));
            if ($check[0] !== 'image') {
                throw new Exception("\nLe fichier n'est pas une image : ".$e->getMessage());
            } else {
                return $check[1];
            }
        }
	}
?>