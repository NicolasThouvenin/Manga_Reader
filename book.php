<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Comic  Page</title>
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
                    require('user.class.php');
                    session_start();
                    if (isset($_COOKIE['user'])) {
                        $user = unserialize($_COOKIE['user']);
                        // if a user is connected
                        echo "<p class='userName'>" . $user->getLogin() . "</p>";
                        echo "<p><a class='userName' href='deconnect.php'>Log out</a></p>";
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
                if (isset($_GET["bookId"])) {
                    try {
                        require('connection.php');
                        require('comic.class.php');

                        echo "<p class='log'>Connection succeeded.</p>";

                        $result = $db->prepare("SELECT * FROM comics WHERE id = :comicId");
                        $result->execute(array('comicId' => $_GET["bookId"]));

                        if ($result->rowCount() == 0) {
                            echo "<p>Sorry, we haven't found any results matching this search.</p>";
                        } else {
                            $line = $result->fetch();

                            if ($line['EndDate'] === null) {
                                $endDate = '';
                            } else {
                                $endDate = $line['EndDate'];
                            }
                            $comic = new Comic($line['Id'], $line['Title'], $line['Synopsis'], $line['StartDate'], $endDate, $line['CoverExt']);
                            $serializedComic = serialize($comic);

                            echo '<script>';
                            echo 'var title = "' . $comic->getTitle() . '";';
                            echo '</script>';
                            ?>
                            <div id="book_cover">
                                <img title="<?php echo $comic->getTitle(); ?>" src="<?php echo "library\\" . $_GET['bookId'] . "\\" . $_GET['bookId'] . "_cover." . $comic->getCoverExt(); ?>" alt="cover" height="375" width="250">
                            </div> <!-- book_cover -->
                            <div id="book_meta">
                                <p id="book_title"><?php echo $comic->getTitle(); ?></p>
                                <p id="book_author"><?php
                                    foreach ($comic->getAuthors() as $author) {
                                        echo $author->getLogin() . ", ";
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

                            </div>  <!-- book_meta -->
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
                                                    <p class='chapter'><a href="reader.php">Chapter <?php echo $chapter->getNumber(); ?>
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
                                <!--        List format
                                <div id="vol1">
                                    <p class='volume'>Volume 1 :
                                        <span class='volume_title'>Le trés méchant Tutu</span>
                                        <span class="volume_synopsis">Le gars et le cochon doivent détruire les armées du méchant Tutu</span>
                                        <span class="volume_release">2018-07-31</span></p>
                                    <ul>
                                        <li>
                                            <p class='chapter'>Chapter 2 :
                                                <span class='chapter_title' title="le garçon et le cochon croisent la route d'un inquiétant bandit">Un nouvel ennemi?</span>
                                                <span class="chapter_release">2018-08-03</span>
                                            </p>
                                        </li>
                                        <li>
                                            <p class='chapter'>Chapter 1 :
                                                <span class='chapter_title' title="Le gars rencontre le cochon">La rencontre</span>
                                                <span class="chapter_release">2018-08-01</span>
                                            </p>
                                        </li>
                                    </ul>
                                </div>-->




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
