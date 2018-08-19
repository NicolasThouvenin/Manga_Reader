<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/main_lg.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
    <meta charset="utf-8">
</head>
<body>
    <div class="form-div">
        <a href="homePage.php"><img src="ressources/bubbleSignLogo.png"></a> <!-- logo -->
        <h2>Create your account</h2> <!-- form for sign up -->
        <form id="register" name="register" method="post" action="addUser.php">
            <input type="text" id="login" name="login" placeholder="Login" required>
            <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
            <input type="text" id="surname" name="surname" placeholder="Last Name" required>
            <input type="date" id="birthDate" name="birthDate" placeholder="Birthdate" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="email" id="email" name="email" placeholder="E-mail" required>
            <?php
                session_start();
                $_SESSION['uniqidRegister'] = uniqid();
                echo '<input id="uniqidRegister" name="uniqidRegister" type="hidden" value="'.$_SESSION['uniqidRegister'].'">';
                // For security reasons, only the posts with a valid formular token will be accepted
            ?>
            <input type="submit" name="submit" value="Create Account" class="registerButton">
        </form>
    </div>
</body>
</html>
