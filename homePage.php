<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css\main_lg.css">
    <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
</head>
<body>
    <div class="page">
        <header>


      <input class="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation" class="creationButton">

      <div class="displayUser"> <!--displayUser's block-->
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
            <input type='button' onclick="location.href = 'login.php';" value="Log in" class="regularButton">
            <input type='button' onclick="location.href = 'register.php';" value="Register" class="registerButton">
            <?php
        }
        ?>
    </div> <!-- displayUser -->


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
                    <a href="comic.php?bookId=<?php echo $line['Id'] ?>"><img src="<?php echo $coverPath ?>" alt="cover" width="150" height="225"></a>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="script/comicFilter.js"></script>
</body>
</html>
