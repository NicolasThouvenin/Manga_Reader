<?php
require('required.php');

//If no comic have been passed in GET, return to homepage
if (!isset($_GET["bookId"])) {
    header("Location:homePage.php");
}
if (isset($_POST["submit"])) {
    try {
        $comic = new Comic($_GET["bookId"]);
        $comic->createVolume(htmlentities($_POST["submit"]), htmlentities($_POST["submit"]));
        header("Location:newChapter.php");
    } catch (Exception $e) {
        die('Error : ' . $e->getMessage());
    }
}





?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Comic Page</title>
        <link rel="stylesheet" type="text/css" href="css\main_lg.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="script/bubbleBook.js"></script>
    </head>
    <body>
        <div class="page">

            <!-- *********** Generating Page Header ******************* -->
            <header>
                <input class="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation">

                <div class="displayUser">
                    <?php
                    if (isset($_COOKIE['authentified'])) {
                        $user = unserialize($_COOKIE['authentified']);
                        // if a user is connected
                        echo "<p class='userName'><a href='profile.php'>" . $user->getLogin() . "</a></p>";
                        echo "<p><a class='userName' href='disconnect.php'>Log out</a></p>";
                    } else {
                        ?>
                        <input type='button' onclick="location.href = 'login.php';" value="Log in" >
                        <input type='button' onclick="location.href = 'register.php';" value="Register" >
                        <?php
                    }
                    ?>
                </div> <!-- displayUser -->
                <div class="logo"><a href="homePage.php">LOGO</a></div>
            </header>
            <main>
                <div class="banner">
                    <input id="searchbar" type="search" name="q" placeholder="search comic or author">
                </div> <!-- banner -->

                <!-- *****************    Page Content ***************** -->
                <?php
                try {

                    $comic = new Comic($_GET["bookId"]);

                    echo '<script>';
                    echo 'var title = "' . $comic->getTitle() . '";';
                    echo '</script>';
                    ?>
                    <div id="book_cover">
                        <img title="<?php echo $comic->getTitle(); ?>" src="<?php echo "comics\\" . $_GET['bookId'] . "\\cover." . $comic->getCoverExt(); ?>" alt="cover" height="375" width="250">
                    </div> <!-- book_cover -->
                    <div id="book_meta">
                        <p id="book_title"><?php echo $comic->getTitle(); ?></p>
                        <p id="book_author"><?php
                            foreach ($comic->getAuthors() as $author) {
                                if ($author->getId() == $user->getId()) {
                                    echo "<b>" . $author->getLogin() . "</b>, ";
                                    $isAuthor = true;
                                } else {
                                    echo $author->getLogin() . ", ";
                                }
                            }
                            ?></p>
                        <p id="book_release"><?php echo $comic->getStartDate(); ?></p>
                        <p id="book_genre"><?php
                            foreach ($comic->getGenreIds() as $genreId) {
                                echo $genreId . ", ";
                            }
                            ?>
                        </p>
                        <p id="synopsis"><?php echo $comic->getSynopsis(); ?></p>
                        <?php echo date("Y-m-d"); ?>

                    </div>  <!-- book_meta -->
                    <div id="add_new">
                        <span id="add_volume" onclick="toggleForm()">Create New Volume</span>
                        <span id="add_chapter"><a href="newChapter.php">Create New Chapter</a></span>
                        <form id="new_volume_form" method="POST" action="comic.php">
                            <p></p><input type="text" name="title" placeholder="Volume Title" required></p>
                            <p><textarea name="synopsis" placeholder="Volume Synopsis" cols="40" rows="3" required></textarea></p>
                            <input type="submit" name="submit" value="Create Volume">
                        </form>
                    </div>
                    <div id="chapters">
                        <p id="chapters_header"><?php echo $comic->getTitle(); ?> Chapters</p>

                        <!--   Generated Part    -->

                        <?php
                        foreach ($comic->getVolumes() as $volume) {
                            ?>
                            <div id='Volume <?php echo $volume->getNumber(); ?> '>
                                <p class="volume">Volume <?php echo $volume->getNumber(); ?>
                                    <span class='volume_title'><?php echo $volume->getTitle(); ?></span>
                                    <span class="volume_synopsis"><?php echo $volume->getSynopsis(); ?></span>                                    
                                    <span class="volume_release"><?php echo $volume->getStartDate(); ?></span></p>
                                <ul>
                                    <?php
                                    foreach ($volume->getChapters() as $chapter) {
                                        ?>
                                        <li>
                                            <p class='chapter'><a href="comicsReader.php">Chapter <?php echo $chapter->getNumber(); ?>
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
                    die('Error : ' . $e->getMessage());
                }
                ?>

            </main>
        </div> <!-- page -->
    </body>
</html>
