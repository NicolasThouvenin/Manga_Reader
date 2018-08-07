<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css\main_lg.css">
    </head>
    <body>
        <div class="page">
            <header>
                <input class="add" type='button' onclick="location.href = 'designer.php';" value="Add Creation">

                <div class="displayUser">
                    <?php
                    require('user.class.php');
                    session_start();
                    if (isset($_COOKIE['user'])) {
                        $user = unserialize($_COOKIE['user']);
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
                <div class="banner">
                    <input id="searchbar" type="search" name="q" placeholder="search comic or author">
                </div> <!-- banner -->

            </main>
        </div> <!-- page -->
    </body>
</html>
