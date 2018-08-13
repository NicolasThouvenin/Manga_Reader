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
        <div class="form-div">
            <a href="homePage.php"><img src="ressources/bubbleSignLogo.png"></a>
            <form id="authentification" name="authentification" method="post" action="checkAuthentification.php">
                <h2>Sign in</h2>
                <input type="text" id="login" name="login" placeholder="Login" required>
                <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                <?php
	                session_start(); // session is starting here
	                $_SESSION['uniqidLogin'] = uniqid(); // and it is based on the uniqid
	                echo '<input id="uniqidLogin" name="uniqidLogin" type="hidden" value="' . $_SESSION['uniqidLogin'] . '">';
	                //Pour des raisons de sécurité, on acceptera que les post  renvoyant le token du formulaire de login
                ?>
                <label><input type="checkbox" id="stayConnected" name="stayConnected"> rester connecté</label>
                <input type="submit" name="submit" value="Login" class="regularButton">
            </form>
            <a href="register.php">S'inscrire</a>
        </div>
    </body>
</html>