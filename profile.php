<?php
require('required.php');

session_start();
if (isset($_COOKIE['authentified'])) {
    $user = unserialize($_COOKIE['authentified']);
} else {
    header("Location:login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title><?php echo $user->getLogin(); ?></title>
        <link rel = "stylesheet" type = "text/css" href = "css\main_lg.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
    </head>
    <body>
        <div class="page">

            <!-- *********** Generating Page Header ******************* -->
            <header>
                <input class="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation">
                <div class="displayUser">
                    <!--     if connected, user info clickable profile                 -->
                    <p class='userName'><a href='profile.php'><?php echo $user->getLogin(); ?></a></p>
                    <p><a class='userName' href='disconnect.php'>Log out</a></p>
                </div> <!-- displayUser -->
                <div class="logo"><a href="homePage.php"><a href="homePage.php"><img src="ressources/bubbleLogo.png"></a></div>
            </header>
            <main>
                <div class="banner">
                    <span>My Profile</span>
                </div> <!-- banner -->

                <!-- *****************    Page Content ***************** -->
                <?php
                    try {
                        require('connection.php');
                        echo "<p class='log'>Connection succeeded.</p>";
                        ?>

                        <form id="profile" name="profile" method="POST" action="updateProfile.php">
                            <input type="file" id="avatar_form" name="avatar" style="display: none;">
                            
                            <div id="avatar" style="height: 250px;">
                                <label for="avatar_form">
                                <img title="<?php echo $user->getLogin(); ?>" src="ressources/avatar.jpg" alt="avatar">
                                </label>
                            </div> <!-- avatar -->

                            <!-- All info about the user   -->
                            <div id="user_info">
                                <p>Login<input type="text" id="login" name="login" value="<?php echo $user->getLogin(); ?>"></p>
                                <p>Firstname<input type="text" id="firstname" name="firstname" value="<?php echo $user->getFirstname(); ?>"></p>
                                <p>Surname<input type="text" id="surname" name="surname" value="<?php echo $user->getSurname(); ?>"></p>
                                <p>Birth Date<input type="date" id="birthDate" name="birthDate" value="<?php echo $user->getBirthDate(); ?>"></p>
                                <p>Email<input type="email" id="email" name="email" value="<?php echo $user->getEmail(); ?>" disabled></p>
                                <?php
                                    $_SESSION['uniqidProfil'] = uniqid(); // and it is based on the uniqid
                                    echo '<input id="uniqidProfil" name="uniqidProfil" type="hidden" value="'.$_SESSION['uniqidProfil'].'">';
                                    //Pour des raisons de sécurité, on acceptera que les post renvoyant le token du formulaire de login
                                ?>
                                <input type="submit" name="submit" value="Save" style="margin-top: 30px;">
                            </div>  <!-- book_meta -->
                        </form>
                            <?php
                        } catch (Exception $e) {
                            die('Error : ' . $e->getMessage());
                        }
                    ?>

                    <form id="unsubscribe" name="unsubscribe" method="post" action="unsubscribe.php">
                        <?php
                            $_SESSION['uniqidUnsubscribe'] = uniqid(); // and it is based on the uniqid
                            echo '<input id="uniqidUnsubscribe" name="uniqidUnsubscribe" type="hidden" value="'.$_SESSION['uniqidUnsubscribe'].'">';
                            //Pour des raisons de sécurité, on acceptera que les post renvoyant le token du formulaire de login
                        ?>
                        <input type="submit" name="submit" value="Unsubscribe" style="margin-top: 30px;">
                    </form>

            </main>

        </div> <!-- page -->
    </body>
</html>
