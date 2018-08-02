<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>
    <body>
        <div class="page">
            <header>
                <input class="add" type='button' onclick="location.href='designer.php';" value="Add Creation">
                
                <div class="displayUser">
                <?php
                    session_start();
                    if (isset($_SESSION["userId"])) {
                     // SELECT on user table with userNameLogin
                        echo "<p class='userName'>".$_SESSION["Login"]."</p>";
                        echo "<p><a class='userName' href='deconnect.php'>Logout</a></p>";
                    } else {
                    ?>
                    <input type='button' onclick="location.href='login.php';" value="Login" >
                    <input type='button' onclick="location.href='createAccount.php';" value="Register" >
                    <?php
                    }
                ?>
                </div>

                <div class="logo"><a href="homePage.php">LOGO</a></div>

            </header>

            <main>
                <div class="banner">
                    <input id="searchbar" type="search" name="q" placeholder="search comic or author">
                </div> <!-- banner -->
                <?php

                try {
                    include 'connection.php';
                    
                    echo "<p class='log'>Connexion réussie.<br>";
                        
                    $stmt = $db->prepare('CALL getComicsWithValidatedChapter()');
                    $stmt->execute();
                    if ($stmt->rowCount() == 0) {
                        echo "<p class='error'>Sorry we haven't found any results matching this search.</p>";
                    } else {
                        while ($line = $stmt->fetch()) {
                            print_r($line);
                            $coverPath = "library\\".$line['Id']."\\".$line['Id']."_cover".".".$line['CoverExt'];
                ?>
                <article id="<?php echo $line['Id'] ?>">
                    <img src="<?php echo $coverPath ?>" alt="cover">
                    <p class="comics_name"><?php echo $line['Title'] ?><p>
                </article>

                <p class="error">
                <?php
                        }
                    }
                }
                catch(Exception $e) {
                    die('Error : '.$e->getMessage());
                }
            ?>
                </p> <!--  CONNECTION ERROR -->
            </main>
        </div> <!-- page -->
    </body>
</html>
