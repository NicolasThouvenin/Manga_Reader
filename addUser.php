<!DOCTYPE html>
<html>
<head>
    <title>Ajout d'un utilisateur</title>
    <meta charset="utf-8">
</head>
<body>
    <?php

    /* Cette page reçoit le post du formulaire d'incription des utilisateurs et pousse créer un utilisateur dans la base de données. */

    try {

        require('required.php');
        require('connection.php');

        session_start();

        if (!isset($_SESSION['uniqidRegister'])) {
            throw new Exception("<br>The session doesn't have a form token from a server form");
        } else if ($_SESSION['uniqidRegister'] != $_POST['uniqidRegister']) {
            throw new Exception("<br>The post request form token as different as session token");
        }

        $checkedData = Util::checkPostData($_POST);
        $addUser = $db->prepare("CALL createUser(:login, :firstname, :surname, :birthDate, :password, :email, @lastUserId, @lastUserEmailKey)");

        $addUser->bindParam(':login', $checkedData['login'], PDO::PARAM_STR, 255);
        $addUser->bindParam(':firstname', $checkedData['firstname'], PDO::PARAM_STR, 255);
        $addUser->bindParam(':surname', $checkedData['surname'], PDO::PARAM_STR, 255);
        $addUser->bindParam(':birthDate', $checkedData['birthDate'], PDO::PARAM_STR, 10);
        $addUser->bindParam(':password', $checkedData['password'], PDO::PARAM_STR, 255);
        $addUser->bindParam(':email', $checkedData['email'], PDO::PARAM_STR, 254);

        $addUser->execute();
        $addUser->closeCursor();

        $result = $db->query("SELECT @lastUserId, @lastUserEmailKey")->fetch(PDO::FETCH_ASSOC);

        // header('Location: emailValidation.php?'.'&userid='.$result['@lastUserId'].'&emailkey='.$result['@lastUserEmailKey'].'&sendemail=true');

//SENDiNG EMAIL
    // initiating PHPMailer
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
        $sendemail->addAddress($checkedData['email']);
        $sendemail->addReplyTo('pharob@superuser.fr');
        $sendemail->isHTML(true);
        $sendemail->Subject='Your BubbleUp account confirmation :';
        $sendemail->Body="<p>Hello!</p>
        <p>Thank you for your registration to bubbleUp. Please, click on this link to activate your account :</p>
        <p>   <a href='http://ns3272345.ip-5-39-84.eu/emailValidation.php?userid=".$result['@lastUserId'].'&emailkey='.$result['@lastUserEmailKey'].'&sendemail=true'."'/>Click here</a></p>
        <p>Regards</p>";
        if(!$sendemail->send()){
            echo "Message couldn't be sent!";
        }
        else{
            echo "You have received an email from BubbleUp, to confirm your registration. If you haven't received it check your unwanted emails <br>
            <a href='http://ns3272345.ip-5-39-84.eu/homePage.php'><button type='button'>Go back to Menu</button></a>
            ";
        }

    } catch(Exception $e) {
        die('<br>Erreur de la création du nouvel utilisateur: '.$e->getMessage());
    };
    ?>
</body>
</html>
