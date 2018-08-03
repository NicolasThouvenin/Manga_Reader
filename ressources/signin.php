<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Sign In</title>
    </head>
    <body>
        <div id="container_signin">
            <p class="titre">S'enregistrer</p>
            <form id="signin" name="sign" action="checklogin.php" method="POST" onsubmit="return myCheck()">
                <p>Nom d'Utilisateur : <input type="text" name="user" required="required"></p>
                <p>Mot de passe : <input type="password" name="pwd" required="required" onkeyup="myPwdCheck()"><span id="strength" style="display: none;"></span></p>
                <p>Confirmez le mot de passe : <input type="password" name="pwd2" required="required"></p>
                <p><input type="submit" value="Valider" name="sign" disabled></p>
            </form>
            <p class="error">
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "badpwd") {
                    echo "Mauvais mot de passe.<br>";
                } else if ($_GET["error"] == "baduser") {
                    echo "Nom inconnu.<br>";
                }
            }
            ?></p>
        </div> <!-- container -->
        <script>
            function myCheck() {
                if (document.forms.sign[1].value !== document.forms.sign[2].value) {
                    alert("les deux mots de passe ne correspondent pas.");
                    return false; 
                }
            }

            function myPwdCheck() {
                var pwd = document.forms.sign[1].value;
                var msg = document.getElementById("strength");
                var ok = false;
                var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
                var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
                msg.style.display = "inline";

                if(strongRegex.test(pwd)) {
                        msg.style.color = "green";
                        msg.innerHTML = "Robuste";
                        ok=true;

                    } else if(mediumRegex.test(pwd)) {
                        msg.style.color = "orange";
                        msg.innerHTML = "Moyen";
                        ok=true;
                    } else {
                        msg.style.color = "Red";
                        msg.innerHTML = "Trop faible";
                        ok = false;
                    }
                if (ok) {
                    document.forms.sign[3].disabled = false;
                } else {
                    document.forms.sign[3].disabled = "disabled";
                }
            }
        </script>
    </body>
</html>