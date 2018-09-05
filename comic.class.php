<?php

class Comic {

    protected $Id;
    private $Title;
    private $Synopsis;
    private $StartDate;
    private $EndDate;
    private $CoverExt;
    private $VolumesLoaded = false;
    private $Volumes = array();
    private $GenreIdsLoaded = false;
    private $GenreIds = array();
    private $AuthorsLoaded = false;
    private $Authors = array();
    private $ImagesFolder;
    private $LastVolumeNumber = -1;

    public function __construct(int $Id) {

        $this->Id = $Id;

        try {

            require('connection.php');

            $result = $db->prepare("SELECT * FROM comics WHERE id = :comicId");
            $result->execute(array('comicId' => $this->Id));

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
            $this->SetImagesFolder();
        } catch (Exception $e) {
            throw new Exception("<br>Error during the comic object creation : " . $e->getMessage());
        }
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

    private function setCoverExt($CoverExt) {
        /* Insert comic cover extension in database */
        try {

            require('connection.php');

            $result = $db->prepare("UPDATE comics SET CoverExt = :CoverExt WHERE Id = :Id");
            $result->execute(array('Id' => $this->Id, 'CoverExt' => $CoverExt));

            $this->CoverExt = $CoverExt;
        } catch (Exception $e) {
            throw new Exception("<br>Error during the insertion in database of the cover image extension : " . $e->getMessage());
        }
    }

    private function SetVolumes() {

        /* This method create an array of volume objetcs */

        try {

            require('connection.php');

            $result = $db->prepare("SELECT * FROM volumes WHERE comicId = :comicId ORDER BY Number");
            $result->execute(array('comicId' => $this->Id));

            while ($line = $result->fetch()) {

                if ($line['EndDate'] === null) {
                    $endDate = '';
                } else {
                    $endDate = $line['EndDate'];
                }

                $volume = new Volume($line['Id'], $line['Number'], $line['Title'], $line['Synopsis'], $line['StartDate'], $endDate);

                $this->Volumes[$line['Number']] = $volume;

                $this->LastVolumeNumber = $line['Number'];
            }
        } catch (Exception $e) {
            throw new Exception("<br>Error during the creation of array of volume objects : " . $e->getMessage());
        }
    }

    public function getVolumes() {
        if (!$this->VolumesLoaded) {
            $this->SetVolumes();
            $this->VolumesLoaded = true;
        }

        foreach ($this->Volumes as $volume) {
            yield $volume;
        }
    }

    public function getLastVolumeNumber() {
        if (!$this->VolumesLoaded) {
            $this->SetVolumes();
            $this->VolumesLoaded = true;
        }
        return $this->LastVolumeNumber;
    }

    public function getLastVolume() {
        if ($this->getLastVolumeNumber() === -1) {
            return null;
        } else {
            $volume = $this->Volumes[$this->getLastVolumeNumber()];
            return $volume;
        }
    }

    public function getLastVolumeId() {
    	$volume = $this->getLastVolume();
        return $volume->getId();
    }

    public function isEmpty() {
        return ($this->LastVolumeNumber == -1);
    }

    private function SetGenreIds() {
        /* Create an array of genre ids */
        try {

            require('connection.php');

            $result = $db->prepare("SELECT genreId FROM comicsgenres WHERE comicId = :comicId");
            $result->execute(array('comicId' => $this->Id));

            while ($line = $result->fetch()) {
                array_push($this->GenreIds, $line['genreId']);
            }
        } catch (Exception $e) {
            throw new Exception("<br>Error during the creation of genre ids list : " . $e->getMessage());
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
        /* Create a array of author objects */
        try {

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
        } catch (Exception $e) {
            throw new Exception("<br>Error during the creation of the array of author objects : " . $e->getMessage());
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

    function AddCover($coverTmpName) {
        /* Put an cover image on the files server */
        try {

            $fileExt = $this->GetExtension($coverTmpName);

            $this->setCoverExt($fileExt);

            $FilePath = $this->ImagesFolder . '//cover.' . $fileExt;
            if (!move_uploaded_file($coverTmpName, $FilePath)) {
                throw new Exception("<br>The cover image could not be adding on the files servers : " . $e->getMessage());
            }
        } catch (Exception $e) {
            throw new Exception("<br>Error during the cover image addition : " . $e->getMessage());
        }
    }

    function getCover() {
        return $this->ImagesFolder . '//cover.' . $this->CoverExt;
    }

    private function SetImagesFolder() {
        /* Create a comic image folder to put all chapters images folders */
        try {
            $this->ImagesFolder = 'comics//' . $this->Id;
            if (!file_exists($this->ImagesFolder)) {
                mkdir($this->ImagesFolder, 0777, true);
            }
        } catch (Exception $e) {
            throw new Exception("<br>Error during the creation of the comic image folder : " . $e->getMessage());
        }
    }

    private function GetExtension($tmpName) {
        /* Return the image extension or an error if it is not an image */
        $check = explode('/', mime_content_type($tmpName));
        if ($check[0] !== 'image') {
            throw new Exception("<br>The file is not an image : " . $e->getMessage());
        } else {
            return $check[1];
        }
    }

    function createVolume($title, $synopsis) {
        /* Create a volume in the database and return a volume object */
        try {
            require('connection.php');

            if (!$this->VolumesLoaded) {
                $this->SetVolumes();
                $this->VolumesLoaded = true;
            }

            $startDate = date('Y-m-d');
            $addVolume = $db->prepare("CALL createVolume(:title, :synopsis, :startDate, :comicId, @lastVolumeId, @LastVolumeNumber)");
            $addVolume->bindParam(':title', $title, PDO::PARAM_STR, 255);
            $addVolume->bindParam(':synopsis', $synopsis, PDO::PARAM_STR, 255);
            $addVolume->bindParam(':startDate', $startDate, PDO::PARAM_STR, 10);
            $addVolume->bindParam(':comicId', $this->Id, PDO::PARAM_INT);
            $addVolume->execute();
            $addVolume->closeCursor();

            $result = $db->query("SELECT @lastVolumeId, @LastVolumeNumber")->fetch(PDO::FETCH_ASSOC);

            $endDate = '';

            $volume = new Volume($result['@lastVolumeId'], $result['@LastVolumeNumber'], $title, $synopsis, $endDate, $endDate);
            $this->Volumes[$result['@LastVolumeNumber']] = $volume;
            $this->LastVolumeNumber = $result['@LastVolumeNumber'];
        } catch (Exception $e) {
            throw new Exception("<br>Error during new volume creation : " . $e->getMessage());
        }
    }

}

?>