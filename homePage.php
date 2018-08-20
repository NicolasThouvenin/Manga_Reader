<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css\general.css">
        <link rel="stylesheet" media="screen and (max-width: 640px)" href="css\small.css">
        <link rel="stylesheet" media="screen and (min-width: 641px) and (max-width: 1008px)" href="css\medium.css">
        <link rel="stylesheet" media="screen and (min-width: 1008px)" href="css\large.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="page">
            <header>
                <input id="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation" >
                <div class="displayUser"> <!--displayUser's block-->
                    <?php
                    require('required.php');

                    session_start();
                    if (isset($_COOKIE['authentified'])) {
                        $user = unserialize($_COOKIE['authentified']);
                        // if a user is connected
                        ?>
                        <img class='smallLog connected' src='ressources/avatar-icon-614x460.png' onclick='toggleUserTab()'>
                        <div id="userTab">
                            <p class='userName'><a href='profile.php'><?php echo $user->getLogin(); ?></a></p>
                            <p class='userName'><a href='disconnect.php'>Log out</a></p>
                        </div>
                        <?php
                    } else {
                        ?>
                        <a href="login.php"><img class="smallLog disconnected" src="ressources/avatar-icon-614x460.png"></a>
                        <input type='button' onclick="location.href = 'login.php';" value="LOG IN" class="regularButton header_button">
                        <input type='button' onclick="location.href = 'register.php';" value="REGISTER" class="form-submit-button header_button">
                        <?php
                    }
                    ?>
                </div> <!-- displayUser -->
                <img id="magnifier" src="ressources/magnifier.png" onclick="toggleSearch()">

                <div class="logo"><a href="homePage.php"><img src="ressources/bubbleLogo.png"></a></div>

            </header>

            <main>
                <div class="banner"> <!-- search block-->
                    <input id="searchbar" type="search" name="q" placeholder="filter by comic title or author" oninput="toFilterComic(this)">
                </div> <!-- banner -->
                <?php
                try {
                    include 'connection.php';

                    echo "<p class='log'>Connection successful.<br>";

                    $stmt = $db->prepare('CALL getComicsWithValidatedChapter()'); // checking for comics 
                    $stmt->execute();
                    if ($stmt->rowCount() == 0) { // if no results, error
                        echo "<p class='error'>Sorry we haven't found any results matching this search.</p>";
                    } else {
                        while ($line = $stmt->fetch()) {

                            // Path to the comic cover
                            $coverPath = "comics\\" . $line['Id'] . "\\cover" . "." . $line['CoverExt'];
                            ?>

                            <article class="comic" id="comicId_<?php echo $line['Id'] ?>">
                                <a href="comic.php?bookId=<?php echo $line['Id'] ?>"><img src="<?php echo $coverPath ?>" alt="cover" width="100" height="150"></a>
                                <p class="comics_name"><a href="comic.php?bookId=<?php echo $line['Id'] ?>"><?php echo $line['Title'] ?></a><p>
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

        <script src="script/headerAdjust.js"></script>
        <script src="script/homeAdjust.js"></script>
        <script src="script/comicFilter.js"></script>
    </body>
</html>
