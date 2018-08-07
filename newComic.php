<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>New Comic</title>
        <link rel="stylesheet" type="text/css" href="css\main_lg.css">
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
                        // if a user is connected
                        echo "<p class='userName'>" . $user->getLogin() . "</p>";
                        echo "<p><a class='userName' href='disconnect.php'>Log out</a></p>";
                    } else {
                        header("Location:login.php");
                    }
                    ?>
                </div> <!-- displayUser -->

                <div class="logo"><a href="homePage.php">LOGO</a></div>

            </header>

            <main>
                <?php
                if (isset($_POST['submit'])) {
                    try {
                        $check = explode("/", mime_content_type($_FILES["cover"]["tmp_name"]));
                        if ($check[0] !== "image") {
                            throw new Exception("\nLe fichier n'est pas une image : " . $e->getMessage());
                        }
                        require('connection.php');

                        $createComic = $db->prepare("CALL createComic(:Title, :Synopsis, :StartDate, :AuthorId, :inCoverExt, @lastComicId)");
                        $updatUser->bindParam(':Title', htmlentities($_POST['comicTitle']), PDO::PARAM_STR, 255);
                        $updatUser->bindParam(':Synopsis', htmlentities($_POST['synopsis']), PDO::PARAM_STR, 255);
                        $updatUser->bindParam(':StartDate', htmlentities($_POST['inStartDate']), PDO::PARAM_STR, 10);
                        $updatUser->bindParam(':AuthorId', $user->getId(), PDO::PARAM_INT);
                        $updatUser->bindParam(':inCoverExt', $check[1], PDO::PARAM_STR, 10);
                        $updatUser->execute();
                        $updatUser->closeCursor();


                        $result = $db->query("SELECT @lastComicId")->fetch(PDO::FETCH_ASSOC);
                        $comic = new Comic($result['@lastComicId']);
                        $comic->AddCover($_FILES["cover"]["tmp_name"]);
                        $comic->createVolume(htmlentities($_POST['volumeTitle']), htmlentities($_POST['volumeSynopsis']));

                        header("Location:newChapter.php");
                    } catch (Exception $ex) {
                        die('Error during Comic creation : ' . $e->getMessage());
                    }
                } else {
                    ?>
                    <div id="new_comic">
                        <form method="POST" action="newComic.php" enctype="multipart/form-data">
                            <p>Title : <input type="text" name="comicTitle" placeholder="New Comic Title" required></p>
                            <p>Creation Date : <input type="date" name="inStartDate" value="<?php echo date("Y-m-d"); ?>" required"></p>
                            <p>Comic Synopsis : <textarea name="synopsis" placeholder="Comic Synopsis" cols="40" rows="3" required></textarea></p>
                            <label>Genres : <select id="genres" multiple name="genres[]" required="required">
                                    <option value="action">Action</option> 
                                    <option value="adventure">Adventure</option>
                                    <option value="comedy">Comedy</option>
                                    <option value="drama">Drama</option>
                                    <option value="fantasy">Fantasy</option>
                                    <option value="historical">Historical</option>
                                    <option value="horror">Horror</option>
                                    <option value="scienceFiction">Sci-fi</option>
                                </select></label>
                            <p>Comic cover picture : <input type="file" name="cover" id="cover" required></p>
                            <p id="first_volume">First Volume Title : <input type="text" name="volumeTitle" placeholder="Volume Title" required></p>
                            <p>Volume Synopsis : <textarea name="volumeSynopsis" placeholder="Volume Synopsis" cols="40" rows="3" required></textarea></p>
                            <input type="submit" name="submit" value="Create New Comic">
                        </form>

                    </div>
                    <?php
                }
                ?>

            </main>


        </div> <!-- page -->
    </body>
</html>
