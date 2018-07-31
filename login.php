<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Manga Reader Online</title>
    </head>
    <body>
        <div id="page">
            <div id="logo">
                <h1>LOGO</h1>
            </div> <!-- logo -->
            <div id="container">
                <form id="login" action="check_login.php" method="POST">
                    <input type="email" name="email" placeholder="email" required="required">
                    <input type="password" name="pwd" placeholder="1234" required="required">
                    <input type="checkbox" id="remember" value="remember">
                    <label for="remember">Remember Me</label>
                    <input type="submit" value="login" name="login">
            </div> <!-- container -->
        </div> <!-- page -->
    </body>
</html>