<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Comic Reader</title>
        <link rel="stylesheet" type="text/css" href="css\main_lg.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="page">
            <header>
                <input class="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation">

                <div class="displayUser">
                    <?php
                    require('required.php');


                    session_start();
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

                <div class="logo"><a href="homePage.php"><a href="homePage.php"><img src="ressources/bubbleLogo.png"></a></div>

            </header>

            <main>
                <div class="banner">
                    <input id="searchbar" type="search" name="q" placeholder="search comic or author">
                </div> <!-- banner -->
                <?php
                try {
                    include 'connection.php';

                    echo "<p class='log'>Connection successful.<br>";
                    ?>
                    <div class="reader">
                        <?php
                        if (isset($_GET["chapterId"]) && isset($_GET["volumeId"]) && isset($_GET["comicId"])) { // checking the chapter,volume and comid Ids transfered by the last form get 
                            $path = "comics\\" . $_GET["comicId"] ."\\". $_GET["volumeId"] ."\\". $_GET["chapterId"]."\\";
                            $chapterId = htmlentities($_GET["chapterId"]);
                            $result = $db->prepare("SELECT Filename FROM comicstrips WHERE chapterId = :chapterId"); 
                            $result->execute(array('chapterId' => $chapterId)); // executing the chapterId's gotten by GET method as the chapter 
                            $i = 1;
                            while ($line = $result->fetch()) {
                                ?>
                                <div class="bubble">
                                    <div class="bubble_number"><?php echo $i ?> </div>
                                    <div class="strip_container">
                                        <img class="comicstrip" src="<?php echo $path . $line["Filename"]; ?>">
                                    </div>
                                    <div class="text"><?php echo $i ?></div>
                                </div>
                                <?php
                            }
                        } else {
                            header("Location:homePage.php");
                        }
                        ?>
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                    <?php
                } catch (Exception $e) {
                    die('Error : ' . $e->getMessage());
                }
                ?>
            </main>
        </div> <!-- page -->
    </body>
    <script src="script/comicReader.js"></script>
</html>
