<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>My Blog</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="script/bubbleBook.js"></script>
    </head>
    <body>
        <div class="page">
            <header>
                <input class="add" type='button' onclick="location.href='designer.php';" value="Add Creation">
                
                <div class="displayUser">
            <?php
                session_start();
                if (isset($_SESSION["userName"])) {
                    // SELECT on user table with userName
                    echo "<img src='".$avatar."' alt='avatar'>";
                    echo "<p>".$userName."</p>";
                } else {
                    ?>
                    <input type='button' onclick="location.href='login.php';" value="Login" >
                    <input type='button' onclick="location.href='createAccount.php';" value="Register" >
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

                <!-- Page Content -->

                <div id="book_cover">
                    <img src="library\cover\Dragon_Ball_cover.jpg" alt="cover" height="375" width="250">
                </div> <!-- book_cover -->
                <div id="book_meta">
                    <p id="book_title">Dragon Ball</p>
                    <p id="book_author">Toriyama Akira</p>
                    <p id="book_release">1984</p>
                    <p id="book_genre">Action, Adventure, Comedy, Fantasy, Martial Arts, Shounen</p>
                    <p id="synopsis">Dragon Ball follows the adventures of Goku from his childhood through adulthood as he trains in martial arts and explores the world in search of the seven mystical orbs known as the Dragon Balls, which can summon a wish-granting dragon when gathered. Along his journey, Goku makes several friends and battles a wide variety of villains, many of whom also seek the Dragon Balls.</p>
                </div>  <!-- book_meta -->
                <div id="chapter">
                    <p>Dragon Ball Chapters</p>

                        



                </div> <!-- chapter -->
            </main>
        </div> <!-- page -->
    </body>
</html>
