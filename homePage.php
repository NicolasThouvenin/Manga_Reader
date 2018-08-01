<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>My Blog</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
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
                /*        Commented until the connection to database is functional
                try {
                    include 'connection.php';
                    
                    echo "<p class='log'>Connexion réussie.<br>";
                        
                    $stmt = $db->prepare('CALL getComics();');
                    $stmt->execute();
                    if ($stmt->rowCount() !== 0) {
                        echo "<p class='error'>Sorry we haven't found any results matching this search.</p>";
                    } else {
                        while ($ligne = $stmt->fetch()) {
                            $coverPath = "library\\".$line['Id']."\\".$line['Id']."_cover".$line['CoverExt'];
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
                }*/
            ?>
            </p>
            <!-- These articles are only for apparence testing, and are to be eventualy deleted -->
                <article>
                    <img src="library\cover\Dragon_Ball_cover.jpg" alt="cover" height="225" width="150">
                    <p>Dragon Ball</p>
                </article>
                <article>
                    <img src="library\cover\one-punch-man_cover.jpg" alt="cover" height="225" width="150">
                    <p>One Punch Man</p>
                </article>
                <article>
                    <img src="library\cover\Hellsing_cover.jpg" alt="cover" height="225" width="150">
                    <p>Hellsing</p>
                </article>
                <article>
                    <img src="library\cover\berserk_cover.jpg" alt="cover" height="225" width="150">
                    <p>Berserk</p>
                </article>
                <article>
                    <img src="library\cover\bleach_cover.png" alt="cover" height="225" width="150">
                    <p>Bleach</p>
                </article>
                <article>
                    <img src="library\cover\D.Gray-man_cover.png" alt="cover" height="225" width="150">
                    <p>D.Gray-man</p>
                </article>
                <article>
                    <img src="library\cover\One_Piece_cover.png" alt="cover" height="225" width="150">
                    <p>One Piece</p>
                </article>
                <article>
                    <img src="library\cover\Dragon_Ball_cover.jpg" alt="cover" height="225" width="150">
                    <p>Dragon Ball</p>
                </article>
                <article>
                    <img src="library\cover\one-punch-man_cover.jpg" alt="cover" height="225" width="150">
                    <p>One Punch Man</p>
                </article>
                <article>
                    <img src="library\cover\Hellsing_cover.jpg" alt="cover" height="225" width="150">
                    <p>Hellsing</p>
                </article>
                <article>
                    <img src="library\cover\berserk_cover.jpg" alt="cover" height="225" width="150">
                    <p>Berserk</p>
                </article>
                <article>
                    <img src="library\cover\bleach_cover.png" alt="cover" height="225" width="150">
                    <p>Bleach</p>
                </article>
                <article>
                    <img src="library\cover\D.Gray-man_cover.png" alt="cover" height="225" width="150">
                    <p>D.Gray-man</p>
                </article>
                <article>
                    <img src="library\cover\One_Piece_cover.png" alt="cover" height="225" width="150">
                    <p>One Piece</p>
                </article>
                <article>
                    <img src="library\cover\Dragon_Ball_cover.jpg" alt="cover" height="225" width="150">
                    <p>Dragon Ball</p>
                </article>
                <article>
                    <img src="library\cover\one-punch-man_cover.jpg" alt="cover" height="225" width="150">
                    <p>One Punch Man</p>
                </article>
                <article>
                    <img src="library\cover\Hellsing_cover.jpg" alt="cover" height="225" width="150">
                    <p>Hellsing</p>
                </article>
                <article>
                    <img src="library\cover\berserk_cover.jpg" alt="cover" height="225" width="150">
                    <p>Berserk</p>
                </article>
                <article>
                    <img src="library\cover\bleach_cover.png" alt="cover" height="225" width="150">
                    <p>Bleach</p>
                </article>
                <article>
                    <img src="library\cover\D.Gray-man_cover.png" alt="cover" height="225" width="150">
                    <p>D.Gray-man</p>
                </article>
                <article>
                    <img src="library\cover\One_Piece_cover.png" alt="cover" height="225" width="150">
                    <p>One Piece</p>
                </article>
                <article>
                    <img src="library\cover\Dragon_Ball_cover.jpg" alt="cover" height="225" width="150">
                    <p>Dragon Ball</p>
                </article>
                <article>
                    <img src="library\cover\one-punch-man_cover.jpg" alt="cover" height="225" width="150">
                    <p>One Punch Man</p>
                </article>
                <article>
                    <img src="library\cover\Hellsing_cover.jpg" alt="cover" height="225" width="150">
                    <p>Hellsing</p>
                </article>
                <article>
                    <img src="library\cover\berserk_cover.jpg" alt="cover" height="225" width="150">
                    <p>Berserk</p>
                </article>
                <article>
                    <img src="library\cover\bleach_cover.png" alt="cover" height="225" width="150">
                    <p>Bleach</p>
                </article>
                <article>
                    <img src="library\cover\D.Gray-man_cover.png" alt="cover" height="225" width="150">
                    <p>D.Gray-man</p>
                </article>
                <article>
                    <img src="library\cover\One_Piece_cover.png" alt="cover" height="225" width="150">
                    <p>One Piece</p>
                </article>
            
            </main>
        </div> <!-- page -->
    </body>
</html>
