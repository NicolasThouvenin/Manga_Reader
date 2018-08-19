<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>DesignerHome</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css\general.css">
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 640px)" href="css\small.css">
        <link rel="stylesheet" media="screen and (min-width: 641px) and (max-width: 1008px)" href="css\medium.css">
        <link rel="stylesheet" media="screen and (min-width: 1008px)" href="css\large.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
    </head>
    <body>
        <div class="page">
            <header>
                <input id="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation" style="visibility: hidden;">

                <div class="displayUser">
                    <?php
                    require('required.php');

                    session_start();
                    if (isset($_COOKIE['authentified'])) {
                        $authentified = unserialize($_COOKIE['authentified']);
                        // if a user is connected
                        ?>
                        <img class='smallLog connected' src='ressources/avatar-icon-614x460.png' onclick='toggleUserTab()'>
                        <div id="userTab" style="display: none;">
                            <p class='userName'><a href='profile.php'><?php echo $authentified->getLogin(); ?></a></p>
                            <p class='userName'><a href='disconnect.php'>Log out</a></p>
                        </div>
                        <?php
                    } else {
                        header("Location:login.php");
                    }
                    ?>
                </div> <!-- displayUser -->
                <img id="magnifier" src="ressources/magnifier.png" onclick="toggleSearch()">

                <div class="logo"><a href="homePage.php"><img src="ressources/bubbleLogo.png"></a></div>
            </header>

            <main>
                <div class="banner">
                    <input id="searchbar" type="search" name="q" placeholder="filter by comic title or author" oninput="toFilterComic(this)">
                    <p>My Comics</p>
                </div> <!-- banner -->
                <?php
                try {
                    include 'connection.php';

                    echo "<p class='log'>Connection successful.<br>";
                    ?>
                    <article id="new">
                        <a href="newComic.php"><div id="new_icon"><img src="ressources\\plus.png"></div></a>
                        <p class="comics_name"><a href="#">New Comic</a><p>
                    </article>

                    <?php
                    // creating new object and getting its Id for the comics it owns and display it
                    $author = new Author($authentified->getId());

                    foreach ($author->getComics() as $comic) {
                        $comicId = $comic->getId();

                        // Path to the comic cover
                        $coverPath = "comics\\" . $comicId . "\\cover." . $comic->getCoverExt();
                        ?>

                        <article id="<?php echo $comic->getId() ?>">
                            <a href="comic.php?bookId=<?php echo $comic->getId() ?>"><img src="<?php echo $coverPath ?>" alt="cover" width="100" height="150"></a>
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
        <script src="script/headerAdjust.js"></script>
        <script src="script/homeAdjust.js"></script>
        <script src="script/comicFilter.js"></script>
    </body>
</html>
