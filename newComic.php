<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>New Comic</title>
        <link rel="stylesheet" type="text/css" href="css/main_lg.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
    </head>
    <body>
        <div class="page">
            <header>
                <input class="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation" style="visibility: hidden;">
                <div class="displayUser">
                    <?php
                        require('required.php');
                        session_start();
                        if (isset($_COOKIE['authentified'])) {
                            $user = unserialize($_COOKIE['authentified']);
                            // if a user is connected and authentified
                            echo "<p class='userName'>".$user->getLogin()."</p>";
                            echo "<p><a class='userName' href='disconnect.php'>Log out</a></p>";
                        } else {
                            header("Location:homePage.php");
                        }
                    ?>
                </div> <!-- displayUser -->
                <div class="logo"><a href="homePage.php"><a href="homePage.php"><img src="ressources/bubbleLogo.png"></a></div>
            </header>
            <main>
                <?php
                    if (isset($_POST['submit'])) { // if the form is validated, it will begin to check the files to upload
                        try {

                            if (!isset($_SESSION['uniqidNewComic'])) {
                                throw new Exception("La requête post de création de comic ne possède pas de token correspondant à un formulaire envoyé par le serveur");
                            } else if ($_SESSION['uniqidNewComic'] != htmlentities($_POST['uniqidNewComic'])) {
                                throw new Exception("La requête post de création de comic n'indique pas pas le même token d'authentification que celui de la session du serveur");
                            }

                            $check = explode("/", mime_content_type($_FILES["cover"]["tmp_name"])); // checking content type
                            if ($check[0] !== "image") {
                                throw new Exception("\nFile is not an image : " . $e->getMessage());
                            }
                            require('connection.php');
                            $comicTitle = htmlentities($_POST['comicTitle']);
                            $comicSynopsis = htmlentities($_POST['synopsis']);
                            $date = htmlentities($_POST['inStartDate']);
                            $userId = $user->getId();
                            $createComic = $db->prepare("CALL createComic(:Title, :Synopsis, :StartDate, :AuthorId, :inCoverExt, @lastComicId)");
                            $createComic->bindParam(':Title', $comicTitle, PDO::PARAM_STR, 255);
                            $createComic->bindParam(':Synopsis', $comicSynopsis, PDO::PARAM_STR, 255);
                            $createComic->bindParam(':StartDate', $date , PDO::PARAM_STR, 10);
                            $createComic->bindParam(':AuthorId', $userId, PDO::PARAM_INT);
                            $createComic->bindParam(':inCoverExt', $check[1], PDO::PARAM_STR, 10);
                            $createComic->execute();
                            $createComic->closeCursor();

                            $result = $db->query("SELECT @lastComicId")->fetch(PDO::FETCH_ASSOC);
                            $comic = new Comic($result['@lastComicId']);

                            $comic->AddCover($_FILES["cover"]["tmp_name"]);
                            $comic->createVolume(htmlentities($_POST['volumeTitle']), htmlentities($_POST['volumeSynopsis']));

                            foreach ($_POST['genres'] as $genreId) {
                                $attachComicToGenres = $db->prepare("CALL attachComicToGenre(:inGenreId, :inComicId)");
                                $attachComicToGenres->bindParam(':inGenreId', $genreId, PDO::PARAM_INT);
                                $attachComicToGenres->bindParam(':inComicId', $result['@lastComicId'], PDO::PARAM_INT);
                                $attachComicToGenres->execute();
                            }

                            header("Location:newChapter.php?volumeId=".$comic->getLastVolumeId());

                        } catch (Exception $e) {
                            die('Error during Comic creation : '.$e->getMessage());
                        }
                    } else {
                        $_SESSION['uniqidNewComic'] = uniqid(); // and it is based on the uniqid
                        echo '<div id="new_comic"><!--creating a bloc for the new book\'s form-->
                            <form method="POST" action="newComic.php" enctype="multipart/form-data"> 
                                <p>Title : <input type="text" name="comicTitle" placeholder="New Comic Title" required></p>
                                <p>Creation Date : <input type="date" name="inStartDate" required></p> <!-- input for choose a date -->
                                <p>Comic Synopsis : <textarea name="synopsis" placeholder="Comic Synopsis" cols="40" rows="3" required></textarea></p> <!-- input for comments area -->
                                <label>Genres : <select id="genres" multiple name="genres[]" required="required"> <!-- input for selecting in a list of genres -->
                                    '.Util::getGenreOptions().'
                                    </select></label>
                                <p>Comic cover picture : <input type="file" name="cover" id="cover" required></p> <!-- input for uploading files -->
                                <p id="first_volume">First Volume Title : <input type="text" name="volumeTitle" placeholder="Volume Title" required></p>
                                <p>Volume Synopsis : <textarea name="volumeSynopsis" placeholder="Volume Synopsis" cols="40" rows="3" required></textarea></p>  
                                <input id="uniqidNewComic" name="uniqidNewComic" type="hidden" value="'.$_SESSION['uniqidNewComic'].'">
                                <input type="submit" name="submit" value="Create New Comic">
                            </form>
                        </div>';
                    }
                ?>
            </main>
        </div> <!-- page -->
    </body>
</html>