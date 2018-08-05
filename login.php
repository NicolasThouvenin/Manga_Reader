<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="css/main_lg.css">
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<meta charset="utf-8">
</head>
<body>
	<div class="form-div">
		<form id="authentification" name="authentification" method="post" action="checkAuthentification.php">
			<input type="text" id="login" name="login" placeholder="Login" required>
			<input type="password" id="password" name="password" placeholder="Mot de passe" required>
			<?php
                session_start();
                $_SESSION['uniqid'] = uniqid();
                echo '<input id="uniqid" name="uniqid" type="hidden" value="'.$_SESSION['uniqid'].'">';
                //Pour des raisons de sécurité, on acceptera que les post  renvoyant le token du formulaire de login
			?>
			<input type="submit" name="submit" value="Login">
		</form>
	</div>
</body>
</html>