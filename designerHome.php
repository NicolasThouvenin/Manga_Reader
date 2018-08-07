<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>DesignerHome</title>
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
                        $authentified = unserialize($_COOKIE['authentified']);

                        // if a user is connected
                        echo "<p class='userName'><a href='profile.php'>" . $authentified->getLogin() . "</a></p>";
                        echo "<p><a class='userName' href='disconnect.php'>Log out</a></p>";
                    } else {
                        header("Location:login.php");
                    }
                    ?>
                </div> <!-- displayUser -->

                <div class="logo"><a href="homePage.php">LOGO</a></div>

            </header>

            <main>
                <div class="banner">
                    <input id="searchbar" type="search" name="q" placeholder="search comic or author">
                    <p>My Comics</p>
                </div> <!-- banner -->
                <?php
                try {
                    include 'connection.php';

                    echo "<p class='log'>Connection successful.<br>";
                    ?>
                    <article id="new">
                        <a href="book.php?bookId=#"><div id="new_icon"><img src="ressources\\plus.png"></div></a>
                        <p class="comics_name"><a href="#">New Comic</a><p>
                    </article>

                    <?php
                    $author = new Author($authentified->getId());

                    foreach ($author->getComics() as $comic) {
                        $comicId = $comic->getId();

                        // Path to the comic cover
                        $coverPath = "comics\\" . $comicId . "\\cover." . $comic->getCoverExt();
                        ?>

                        <article id="<?php echo $comic->getId() ?>">
                            <a href="comic.php?bookId=<?php echo $comic->getId() ?>"><img src="<?php echo $coverPath ?>" alt="cover" width="150" height="225"></a>
                            <p class="comics_name"><a href="comic.php?bookId=<?php $comic->getId() ?>"><?php echo $comic->getTitle() ?></a><p>
                        </article>

                        <?php
                    }
                } catch (Exception $e) {
                    die('Error : ' . $e->getMessage());
                }
                ?>
            </main>
        </div> <!-- page -->
    </body>
</html>
