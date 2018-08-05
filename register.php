<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <meta charset="utf-8">
</head>
<body>
    <div class="form-div">
        <form id="register" name="register" method="post" action="addUser.php" onsubmit="return validateRegisterForm(this)" method="post">
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
            <input type="submit" name="submit">
        </form>
    </div>
    <script type="text/javascript" src="script/checkForm.js"></script>
</body>
</html>