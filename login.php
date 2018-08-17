<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sign In</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css\general.css">
        <link rel="stylesheet" media="screen and (max-width: 640px)" href="css\small.css">
        <link rel="stylesheet" media="screen and (min-width: 641px)" href="css\main_lg.css">
        <!--        <link rel="stylesheet" type="text/css" href="css/form.css">-->
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
        <meta charset="utf-8">
    </head>
    <body>
        <div class="form-div">
            <div id="login-logo">
                <img src="ressources/bubbleSignLogo.png" onclick="location.href = 'homePage.php';"
            </div>
            <form id="authentication" name="authentication" method="post" action="checkAuthentication.php">
                <h2>Sign in</h2>
                <input class="input_login" type="text" id="login" name="login" placeholder="Login" required>
                <input class="input_login" type="password" id="password" name="password" placeholder="Password" required>
                <?php
                session_start(); // session is starting here
                $_SESSION['uniqidLogin'] = uniqid(); // and it is based on the uniqid
                echo '<input id="uniqidLogin" name="uniqidLogin" type="hidden" value="' . $_SESSION['uniqidLogin'] . '">';
                // For security reasons, only the posts with a valid formular token will be accepted
                ?>
                <label><input type="checkbox" id="stayConnected" name="stayConnected">Remember me</label>
                <input type="submit" name="submit" value="Login" class="loginButton">
            </form>
        </div> <!-- form-div-->
    </body>
</html>
