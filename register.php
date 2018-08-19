<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css\general.css">
            <link rel="stylesheet" type="text/css" media="screen and (max-width: 640px)" href="css\small.css">
            <link rel="stylesheet" type="text/css" media="screen and (min-width: 641px)" href="css\large.css">
            <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
        <meta charset="utf-8">
    </head>
    <body>
        <div class="form-div">
            <div id="login-logo">
                <img src="ressources/bubbleSignLogo.png" onclick="location.href = 'homePage.php';">
            </div>
            <form  class='main-form' id="register" name="register" method="post" action="addUser.php">
                <h2>Create your account</h2> <!-- form for sign up -->
                <input class="input_login" type="text" id="login" name="login" placeholder="Login" required>
                <input class="input_login" type="text" id="firstname" name="firstname" placeholder="First Name" required>
                <input class="input_login" type="text" id="surname" name="surname" placeholder="Last Name" required>
                <input class="input_login" type="date" id="birthDate" name="birthDate" placeholder="Birthdate" required>
                <input class="input_login" type="password" id="password" name="password" placeholder="Password" required>
                <input class="input_login" type="email" id="email" name="email" placeholder="E-mail" required>
                <?php
                    session_start();
                    $_SESSION['uniqidRegister'] = uniqid();
                    echo '<input id="uniqidRegister" name="uniqidRegister" type="hidden" value="'.$_SESSION['uniqidRegister'].'">';
                    // For security reasons, only the posts with a valid formular token will be accepted
                ?>
                <input type="submit" name="submit" value="Create Account"  class="form-submit-button">
            </form>
        </div>
    </body>
</html>
