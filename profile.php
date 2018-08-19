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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css\general.css">
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 640px)" href="css\small.css">
        <link rel="stylesheet" media="screen and (min-width: 641px) and (max-width: 1008px)" href="css\medium.css">
        <link rel="stylesheet" media="screen and (min-width: 1008px)" href="css\large.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
    </head>
    <body>
        <div class="page">

            <!-- *********** Generating Page Header ******************* -->
            <header>
                <input id="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation">
                <div class="displayUser">
                    <img class='smallLog connected' src='ressources/avatar-icon-614x460.png' onclick='toggleUserTab()'>
                    <div id="userTab">
                        <p class='userName'><a href='profile.php'><?php echo $user->getLogin(); ?></a></p>
                        <p class='userName'><a href='disconnect.php'>Log out</a></p>
                    </div>
                </div> <!-- displayUser -->
                <div class="logo"><a href="homePage.php"><img src="ressources/bubbleLogo.png"></a></div>
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

                        <div id="avatar">
                            <label for="avatar_form">
                                <img id="avatar_pic" title="<?php echo $user->getLogin(); ?>" src="ressources/avatar.jpg" alt="avatar">
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
                            echo '<input id="uniqidProfil" name="uniqidProfil" type="hidden" value="' . $_SESSION['uniqidProfil'] . '">';
                            // For security reasons, only the posts with a valid formular token will be accepted
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
                    echo '<input id="uniqidUnsubscribe" name="uniqidUnsubscribe" type="hidden" value="' . $_SESSION['uniqidUnsubscribe'] . '">';
                    // For security reasons, only the posts with a valid formular token will be accepted
                    ?>
                    <input type="submit" name="submit" value="Unsubscribe">
                </form>

            </main>

        </div> <!-- page -->
        <script src="script/headerAdjust.js"></script>
        <script src="script/profileAdjust.js"></script>
    </body>
</html>
