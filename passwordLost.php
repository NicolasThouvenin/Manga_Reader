<!DOCTYPE html>
<html>
<head>
    <title>Ajout d'un utilisateur</title>
    <meta charset="utf-8">
</head>
<body>



    <?php
    require('required.php');
    require('connection.php');
    try {
        session_start();
        if(isset($_GET['email']) AND isset($_GET['passwordKey']))
        {

            echo "<h3>Enter your new password :</h3>
            <form name='passwordLost' method='post' action=''>
            <input type='password'  name='newPassword1' placeholder='New password' required>
            <input type='password'  name='newPassword2' placeholder='Confirm new password' required>
            <input type='submit' name='submitPassword' value='Confirm' class='registerButton'>
            </form>";
            if (isset($_POST['submitPassword']) && $_POST['newPassword1']==$_POST['newPassword2']) {
                // echo "your new password is now set!";

                $userEmail = $_GET['email'];
                $newPassword1 = sha1($_POST['newPassword1']);
                $reqUser = $db->prepare("SELECT * FROM users WHERE email = ?");
                $reqUser->execute(array($userEmail));
                $userExist = $reqUser->rowCount();
                if($userExist == 1){
                    $updatePassword = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
                    $updatePassword->execute(array($newPassword1,$userEmail));
                }
                echo "Password changed!";
            }
            else{
                echo "Passwords are not matching.";
            }
        }
        else{

            echo "<h3>Enter your email to recover your password</h3>
            <form name='passwordLost' method='post' action='passwordLost.php'>
            <input type='email' id='email' name='email' placeholder='E-mail' required>
            <input type='submit' name='submit' value='Confirm' class='registerButton'>
            </form>";


//SENDiNG EMAIL
    // initiating PHPMailer
            if(isset($_POST['submit'])&& isset($_POST['email'])){
                function generateRandomString($length = 64) {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                }
                $generateRandomString = generateRandomString();

            // Inserting new key to the db
                $userEmail = $_POST['email'];
                $reqUser = $db->prepare("SELECT * FROM users WHERE email = ?");
                $reqUser->execute(array($userEmail));
                $userExist = $reqUser->rowCount();
                if($userExist == 1){
                    $updatePassword = $db->prepare("UPDATE users SET passwordKey = ? WHERE email = ?");
                    $updatePassword->execute(array($generateRandomString,$userEmail));


                    require 'PHPMailer-5.2/PHPMailerAutoload.php';
                    $sendemail= new PHPMailer;
                    $sendemail->isSMTP();
                    $sendemail->Host="smtp.gmail.com";
                    $sendemail->Port=465;
                    $sendemail->SMTPAuth=true;
                    $sendemail->SMTPSecure="ssl";
                     //webmail server credentials
                    $sendemail->Username='blaisiustristodontor@gmail.com';
                    $sendemail->Password='Hn7t31PxGvTy8';
                     //email sending setup
                    $sendemail->setFrom('no-reply@bubbleup.fr','BubbleUp.fr');
                    $sendemail->addAddress($_POST['email']);
                    $sendemail->addReplyTo('pharob@superuser.fr');
                    $sendemail->isHTML(true);
                    $sendemail->Subject='Your BubbleUp Password lost:';
                    $sendemail->Body="<p>Hello!</p>
                    <p>You have requested a password change, to change it, click on the following link :</p>
                    <p>   <a href='http://ns3272345.ip-5-39-84.eu/passwordLost.php?email=".$userEmail.'&passwordKey='.$generateRandomString."'/>Change your password</a></p>
                    <p>Regards</p>";
                    if(!$sendemail->send()){
                        echo "Message couldn't be sent!";
                    }
                    else{
                        echo "You have received an email from BubbleUp, to change your password.<br> If you haven't received it check your unwanted emails <br>
                        <a href='http://ns3272345.ip-5-39-84.eu/homePage.php'><button type='button'>Go back to Menu</button></a>
                        ";
                    }

                }
                else{
                    echo "Wrong email, it doesn't exist.";
                }                
            }
        }
    }catch(Exception $e) {
        die('<br>Erreur de la création du nouvel utilisateur: '.$e->getMessage());
    };
    ?>
</body>
</html>
