<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<meta charset="utf-8">
</head>
<body>
	<div class="form-div">
		<form id="authentification" name="authentification" method="post" action="checkAuthentification.php">
			<input type="text" id="login" name="login" placeholder="Login" required>
			<input type="password" id="password" name="password" placeholder="Mot de passe" required>
			<?php
                session_start();
                $_SESSION['loginToken'] = uniqid();
                echo '<input id="loginToken" name="loginToken" type="hidden" value="'.$_SESSION['loginToken'].'">';
                echo $_SESSION['loginToken'];
                //Pour des raisons de sécurité, on acceptera que les post  renvoyant le token du formulaire de login
			?>
			<input type="submit" name="submit">
		</form>
	</div>
</body>
</html>