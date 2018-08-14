<!DOCTYPE html>
<html>
    <head>
        <title>Sign In</title>
        <link rel="stylesheet" type="text/css" href="css/main_lg.css">
        <link rel="stylesheet" type="text/css" href="css/form.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
        <meta charset="utf-8">
    </head>
    <body>
        <div id ="page">
             <div class="form-div">
                <a href="homePage.php"><img src="ressources/bubbleSignLogo.png"></a>
                <form id="authentification" name="authentification" method="post" action="checkAuthentification.php">
                    <h2>Sign in</h2>
                    <input type="text" id="login" name="login" placeholder="Login" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <?php
                    session_start(); // session is starting here
                    $_SESSION['uniqid'] = uniqid(); // and it is based on the uniqid
                    echo '<input id="uniqid" name="uniqid" type="hidden" value="' . $_SESSION['uniqid'] . '">';
                    // For security reasons, only the posts with a valid formular token will be accepted
                    ?>
                    <label><input type="checkbox" id="stayConnected" name="stayConnected">Remember me</label>
                    <input type="submit" name="submit" value="Login" class="regularButton">
                </form>
            </div> <!-- form-div-->
        </div> <!-- page -->
    </body>
</html>
