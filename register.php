<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="css/main_lg.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
    <meta charset="utf-8">
</head>
<body>
    <div class="form-div">
        <form id="register" name="register" method="post" action="addUser.php">
            <h2>Create your account</h2>
            <input type="text" id="login" name="login" placeholder="Login" required>
            <input type="text" id="firstname" name="firstname" placeholder="Prénom" required>
            <input type="text" id="surname" name="surname" placeholder="Nom" required>
            <input type="date" id="birthDate" name="birthDate" placeholder="Date de naissance" required>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
            <input type="email" id="email" name="email" placeholder="Entrez une adresse email valide" required>
            <?php
                session_start();
                $_SESSION['uniqid'] = uniqid();
                echo '<input id="uniqid" name="uniqid" type="hidden" value="'.$_SESSION['uniqid'].'">';
                //Pour des raisons de sécurité, on acceptera que les post d'inscription renvoyant le token d'inscription
            ?>
            <input type="submit" name="submit" value="Create Account" class="registerButton">
        </form>
    </div>
</body>
</html>
