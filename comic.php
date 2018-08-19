<?php
require('required.php');

//If no comic have been passed in GET, return to homepage
if (!isset($_GET["bookId"])) {
    header("Location:homePage.php");
}
$comic = new Comic($_GET["bookId"]);
/**
 *   New Volume Creation
 * Create a new volume for the current comic
 * then redirect on chapter creation
 */
if (isset($_POST["submit"])) {
    try {
        $comic->createVolume(htmlentities($_POST["title"]), htmlentities($_POST["synopsis"]));
        header("Location:newChapter.php?volumeId=" . $comic->getLastVolumeId());
    } catch (Exception $e) {
        die('Error during volume creation.' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $comic->getTitle(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css\general.css">
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 640px)" href="css\small.css">
        <link rel="stylesheet" media="screen and (min-width: 641px) and (max-width: 1008px)" href="css\medium.css">
        <link rel="stylesheet" media="screen and (min-width: 1008px)" href="css\large.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="script/bubbleBook.js"></script>
    </head>
    <body>
        <div class="page">

            <!-- *********** Generating Page Header ******************* -->
            <header>
                <input id="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation">

                <div class="displayUser">
                    <?php
                    if (isset($_COOKIE['authentified'])) {
                        $user = unserialize($_COOKIE['authentified']);
                        // if a user is connected
                        ?>
                        <img class='smallLog connected' src='ressources/avatar-icon-614x460.png' onclick='toggleUserTab()'>
                        <div id="userTab">
                            <p class='userName'><a href='profile.php'><?php echo $user->getLogin(); ?></a></p>
                            <p class='userName'><a href='disconnect.php'>Log out</a></p>
                        </div>
                        <?php
                    } else {
                        ?>
                        <a href="login.php"><img class="smallLog disconnected" src="ressources/avatar-icon-614x460.png"></a>
                        <input type='button' onclick="location.href = 'login.php';" value="LOG IN" class="regularButton">
                        <input type='button' onclick="location.href = 'register.php';" value="REGISTER" class="registerButton">
                        <?php
                    }
                    ?>
                </div> <!-- displayUser -->
                <div class="logo"><a href="homePage.php"><img src="ressources/bubbleLogo.png"></a></div>
            </header>
            <main>
                <div class="banner">
                    <span><?php echo $comic->getTitle(); ?></span>
                </div> <!-- banner -->

                <!-- *****************    Page Content ***************** -->
                <?php
                try {
                    ?>
                    <div id="book_cover">
                        <img id="cover" title="<?php echo $comic->getTitle(); ?>" src="<?php echo "comics\\" . $_GET['bookId'] . "\\cover." . $comic->getCoverExt(); ?>" alt="cover" height="225" width="150">
                    </div> <!-- book_cover -->
                    <div id="book_meta">
                        <p id="book_title"><?php echo $comic->getTitle(); ?></p>
                        <p id="book_author"><?php
                            // generate author list, in bold if it's the connected user
                            foreach ($comic->getAuthors() as $author) {
                                if (isset($_COOKIE['authentified'])) {
                                    if ($author->getId() == $user->getId()) {
                                        echo "<b>" . $author->getLogin() . "</b>, ";
                                    }
                                } else {
                                    echo $author->getLogin() . ", ";
                                }
                            }
                            ?></p>
                        <p id="book_release"><?php echo $comic->getStartDate(); ?></p>
                        <p id="book_genre"><?php
                            // generate genre list
                            foreach ($comic->getGenreIds() as $genreId) {
                                echo $genreId . ", ";
                            }
                            ?>
                        </p>
                    </div>  <!-- book_meta -->
                    <p id="synopsis"><?php echo $comic->getSynopsis(); ?></p>


                    <?php
                    // If the user connected is the author, displays the creation links
                    if (isset($_COOKIE['authentified'])) {
                        if ($author->getId() == $user->getId()) {
                            ?>

                            <!--Creation Links-->
                            <div id="add_new">
                                <?php
                                $lastVolume = $comic->getLastVolume();
                                ?>
                                <span id="add_volume" onclick="toggleForm()">Create New Volume</span>
                                <span id="add_chapter"><a href="newChapter.php?volumeId=<?php echo $lastVolume->getId(); ?>">Create New Chapter</a></span>
                                <?php
                                if ($lastVolume->isEmpty() == 1) {
                                    // If the last volume created is empty, the author can't create a new one
                                    ?>
                                    <p id="new_volume_form">You can't create a new volume when the last one is empty.</p>
                                    <?php
                                } else {
                                    ?>
                                    <!-- New volume creation form-->
                                    <form id="new_volume_form" method="POST" action="comic.php?bookId=<?php echo $_GET["bookId"]; ?>">
                                        <p></p><input type="text" name="title" placeholder="Volume Title" required></p>
                                        <p><textarea name="synopsis" placeholder="Volume Synopsis" cols="40" rows="3" required></textarea></p>
                                        <input type="submit" name="submit" value="Create Volume">
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div id="chapters">
                        <p id="chapters_header"><?php echo $comic->getTitle(); ?> Chapters</p>

                        <!--   Generated volume and chapter list    -->

                        <?php
                        foreach ($comic->getVolumes() as $volume) {
                            // generation of volume list
                            ?>
                            <div id='Volume <?php echo $volume->getNumber(); ?> '>
                                <p class="volume">Volume <?php echo $volume->getNumber(); ?>
                                    <span class='volume_title'><?php echo $volume->getTitle(); ?></span>
                                    <span class="volume_synopsis"><?php echo $volume->getSynopsis(); ?></span>                                    
                                    <span class="volume_release"><?php echo $volume->getStartDate(); ?></span></p>
                                <ul>
                                    <?php
                                    foreach ($volume->getChapters() as $chapter) {
                                        // generation of chapter list
                                        ?>
                                        <li>
                                            <p class='chapter'><a href="comicsReader.php?chapterId=<?php echo $chapter->getId() . "&comicId=" . $_GET["bookId"] . "&volumeId=" . $volume->getId(); ?>">Chapter <?php echo $chapter->getNumber(); ?>
                                                    <span class='chapter_title' title="<?php echo $chapter->getSynopsis() ?>"><?php echo $chapter->getTitle() ?></span>
                                                    <span class="chapter_release"><?php echo $chapter->getPublicationDate() ?></span>
                                                </a></p>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div> <!-- Volume <?php echo $volume->getNumber(); ?>  "--> 
                            <?php
                        }
                        ?>
                    </div> <!-- chapters -->
                    <?php
                } catch (Exception $e) {
                    die('Error on comic page' . $e->getMessage());
                }
                ?>
            </main>
        </div> <!-- page -->
        <script src="script/headerAdjust.js"></script>
        <script src="script/comicAdjust.js"></script>
    </body>
</html>
