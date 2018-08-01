<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>My Blog</title>
        <link rel="stylesheet" type="text/css" href="myStyle.css">
    </head>
    <body>
        <div class="page">
            <div class="logo_container">
                <div class="logo"><a href="homePage.php">LOGO</a></div>
            </div>
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


            </header>

            <main>
                <div class="banner">
                    <input id="searchbar" type="search" name="q" placeholder="search comic or author">
                </div> <!-- banner -->
                <?php
                /*
                    include 'connexion.php';
                    if ($db) {
                        echo "<p class='log'>Connexion réussie.<br>";
                        echo "Information sur le serveur : ".mysqli_get_host_info($db)."</p>";
                        
                        $sql = "SELECT "
                        $resultat = $db->prepare($sql);
                        $resultat->execute(array())

                        
                        while ($ligne = $resultat->fetch()) {
                            $coverPath = "library\cover\".$name."_cover
                        ?>
                <article id="<?php echo $name ?>">
                    <img src="<?php echo $coverPath ?>" alt="cover">
                    <p class="comics_name"><?php echo $name ?><p>
                    <p class="comics_authors"><?php echo $authors ?><p>
                    <p class="comics_tags"><?php echo $tags ?><p>
                </article>
                <?php
                        }
                    } */
                    

            ?>
                <article>
                    <img src="library\cover\Dragon_Ball_cover.jpg" alt="cover">
                    <p>Dragon Ball</p>
                </article>
                <article>
                    <img src="library\cover\one-punch-man_cover.jpg" alt="cover">
                    <p>One Punch Man</p>
                </article>
                <article>
                    <img src="library\cover\berserk_cover.jpg" alt="cover">
                    <p>Berserk</p>
                </article>

            </main>
        </div> <!-- page -->
    </body>
</html>
