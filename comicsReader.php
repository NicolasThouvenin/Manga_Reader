<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Comic Reader</title>
        <link rel="stylesheet" type="text/css" href="css\main_lg.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>
    <body>
        <div class="page">
            <header>
                <input class="add" type='button' onclick="location.href = 'designer.php';" value="Add Creation">

                <div class="displayUser">
                    <?php
                    require('user.class.php');
                    require('comic.class.php');


                    session_start();
                    if (isset($_COOKIE['user'])) {
                        $user = unserialize($_COOKIE['user']);
                        // if a user is connected
                        echo "<p class='userName'>" . $user->getLogin() . "</p>";
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
                <?php
                try {
                    include 'connection.php';

                    echo "<p class='log'>Connection successful.<br>";
                    ?>
                    <div class="reader">
                        <?php
                        for ($id = 1; $id < 97; $id++) {
                            //$message = 'Hello ' . ($user->is_logged_in() ? $user->get('first_name') : 'Guest');
                            ?>
                            <div class="bubble">
                                <div class="bubble_number"><?php echo $id ?> / 96</div>

                                <img src="<?php echo "comics\\1\\1\\" . ($id < 10 ? "0" . $id : $id) . ".jpg"; ?>" height="600">
                                <div class="text"><?php echo $id ?></div>
                            </div>
                            <?php
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
