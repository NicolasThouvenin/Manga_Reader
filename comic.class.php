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
    private $ImagesFolder;

    public function __construct(int $Id) {

        $this->Id = $Id;

        try {

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
            $this->SetImagesFolder();
        } catch (Exception $e) {
            throw new Exception("\nErreur lors de la création de l'objet comic : " . $e->getMessage());
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

        try {

            require('connection.php');

            $result = $db->prepare("UPDATE comics SET CoverExt = :CoverExt WHERE Id = :Id");
            $result->execute(array('Id' => $this->Id, 'CoverExt' => $CoverExt));

            $this->CoverExt = $CoverExt;
        } catch (Exception $e) {
            throw new Exception("\nErreur lors l'insertion de la nouvelle extension du cover dans la base de données : " . $e->getMessage());
        }
    }

    private function SetVolumes() {

        try {

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
        } catch (Exception $e) {
            throw new Exception("\nErreur lors de la création de la liste de volumes : " . $e->getMessage());
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

        try {

            require('connection.php');

            $result = $db->prepare("SELECT genreId FROM comicsgenres WHERE comicId = :comicId");
            $result->execute(array('comicId' => $this->Id));

            while ($line = $result->fetch()) {
                array_push($this->GenreIds, $line['genreId']);
            }
        } catch (Exception $e) {
            throw new Exception("\nErreur lors de la création de la liste de d'indentifiant de genres : " . $e->getMessage());
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
            throw new Exception("\nErreur lors de la création de la liste d'objets auteurs : " . $e->getMessage());
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
        try {

            $fileExt = $this->GetExtension($coverTmpName);

            $this->setCoverExt($fileExt);

            $FilePath = $this->ImagesFolder . '\\cover.' . $fileExt;
            if (!move_uploaded_file($coverTmpName, $FilePath)) {
                throw new Exception("\nL'image du cover n'a pas pu être ajouté par move_uploaded_file : " . $e->getMessage());
            }
        } catch (Exception $e) {
            throw new Exception("\nErreur lors de l'ajout du cover : " . $e->getMessage());
        }
    }

    function getCover() {
        return $this->ImagesFolder . '\\cover.' . $this->CoverExt;
    }

    private function SetImagesFolder() {
        try {
            $this->ImagesFolder = 'comics\\' . $this->Id;
            if (!file_exists($this->ImagesFolder)) {
                mkdir($this->ImagesFolder, 0777, true);
            }
        } catch (Exception $e) {
            throw new Exception("\nErreur lors de la création du dossier d'image du comic : " . $e->getMessage());
        }
    }

    private function GetExtension($tmpName) {
        $check = explode('/', mime_content_type($tmpName));
        if ($check[0] !== 'image') {
            throw new Exception("\nLe fichier n'est pas une image : " . $e->getMessage());
        } else {
            return $check[1];
        }
    }

    function createVolume($title, $synopsis) {
        try {
            require('connection.php');
            $date = date("Y-m-d");
            $addVolume = $db->prepare("CALL createVolume(:title, :synopsis, :date, :comicId, @lastVolumeId");
            $addVolume->bindParam(':title', $title, PDO::PARAM_STR, 255);
            $addVolume->bindParam(':synopsis', $synopsis, PDO::PARAM_STR, 255);
            $addVolume->bindParam(':date', $date, PDO::PARAM_STR, 10);
            $addVolume->bindParam(':comicId', $this->Id, PDO::PARAM_INT);
            $addVolume->execute();
            $addVolume->closeCursor();

            $result = $db->query("SELECT @lastVolumeId")->fetch(PDO::FETCH_ASSOC);

            $volume = new Volume($result['@lastVolumeId'], $Number, $title, $synopsis, $date, "");
            $this->Volumes[$result['@lastVolumeId']] = $volume;
        } catch (Exception $e) {
            throw new Exception("\nError during new volume creation : " . $e->getMessage());
        }
    }

}

?>