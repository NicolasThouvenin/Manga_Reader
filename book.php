<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>My Blog</title>
        <link rel="stylesheet" type="text/css" href="css\main_lg.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="script/bubbleBook.js"></script>
    </head>
    <body>
        <div class="page">
            
            <!-- *********** Generating Page Header ******************* -->
            <header>
                <input class="add" type='button' onclick="location.href = 'designer.php';" value="Add Creation">

                <div class="displayUser">
                    
                    <?php
                    session_start();
                    if (isset($_SESSION["user"])) {
                        // SELECT on user table with userNameLogin
                        echo "<p class='userName'>" . $_SESSION["user"]->getLogin() . "</p>";
                        echo "<p><a class='userName' href='deconnect.php'>Log out</a></p>";
                    } else {
                        ?>
                        <input type='button' onclick="location.href = 'login.php';" value="Log in" >
                        <input type='button' onclick="location.href = 'createAccount.php';" value="Register" >
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
                if (isset($_GET["bookId"])) {
                    try {
                        include 'connection.php';

                        echo "<p class='log'>Connexion rÃ©ussie.</p>";

                        $stmt = $db->prepare('CALL getComicData(:Id)');
                        $stmt->bindParam(':Id', $_GET['bookId'], PDO::PARAM_INT);
                        $stmt->execute();

                        if ($stmt->rowCount() == 0) {
                            echo "<p>Sorry we haven't found any results matching this search.</p>";
                        } else {
                            $book = $stmt->fetch();

                            //print_r($book);

                            echo '<script>';
                            echo 'var book = ' . $book["arcs"] . ';';
                            echo 'var title = "' . $book["Title"] . '";';
                            echo '</script>';
                            ?>
                            <div id="book_cover">
                                <img src="<?php echo "library\\" . $_GET['bookId'] . "\\" . $_GET['bookId'] . "_cover." . $book["CoverExt"]; ?>" alt="cover" height="375" width="250">
                            </div> <!-- book_cover -->
                            <div id="book_meta">
                                <p id="book_title"><?php echo $book["Title"]; ?></p>
                                <p id="book_author"><?php echo $book["Login"]; ?></p>
                                <p id="book_release"><?php echo $book["StartDate"]; ?></p>
                                <p id="book_genre"><?php echo $book["Genres"]; ?></p>
                                <p id="synopsis"><?php echo $book["Synopsie"]; ?></p>

                            </div>  <!-- book_meta -->
                            <div id="chapters">
                                <p id="chapters_header"><?php echo $book["Title"]; ?> Chapters</p>
                                <div id="vol1">
                                    <p class='volume'>Volume 1
                                        <span class='volume_title'>Le très méchant Tutu</span>
                                        <span class="volume_synopsis">Le gars et le cochon doivent détruire les armées du méchant Tutu</span>
                                        <span class="volume_release">2018-07-31</span></p>
                                </div>




                            </div> <!-- chapters -->
                            <?php
                        }
                    } catch (Exception $e) {
                        die('Error : ' . $e->getMessage());
                    }
                } else {
                    header("Location:homePage.php");
                }
                ?>

            </main>

        </div> <!-- page -->
    </body>
</html>
