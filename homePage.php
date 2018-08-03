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
                    session_start();
                    if (isset($_SESSION["userId"])) {
                        // if a user is connected
                        echo "<p class='userName'>" . $_SESSION["Login"] . "</p>";
                        echo "<p><a class='userName' href='deconnect.php'>Log out</a></p>";
                    } else {
                        ?>
                        <input type='button' onclick="location.href = 'login.php';" value="Log in" >
                        <input type='button' onclick="location.href = 'createAccount.php';" value="Register" >
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

                            // for testing purposes, printed in a display: none <p>
                            // print_r($line);
                            // Path to the comic cover
                            $coverPath = "library\\" . $line['Id'] . "\\" . $line['Id'] . "_cover" . "." . $line['CoverExt'];
                            ?>

                            <article id="<?php echo $line['Id'] ?>">
                                <a href="book.php?bookId=<?php echo $line['Id'] ?>"><img src="<?php echo $coverPath ?>" alt="cover" width="150" height="225"></a>
                                <p class="comics_name"><a href="book.php?bookId=<?php echo $line['Id'] ?>"><?php echo $line['Title'] ?></a><p>
                            </article>

                            <?php
                        }
                    }
                } catch (Exception $e) {
                    die('Error : ' . $e->getMessage());
                }
                ?>
            </main>
        </div> <!-- page -->
    </body>
</html>
