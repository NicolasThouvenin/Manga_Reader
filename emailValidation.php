
<?php
if (isset($_GET['userid']) && isset($_GET['emailkey']) && isset($_GET['sendemail'])) {
	if ($_GET['sendemail'] == true) {
		$subject = "Inscription confirmation to bubbleUp";
		$message = "Hello,\nThanks you for your inscription to bubbleUp. Please, click to follow link to confirm your inscription :\n
		http://localhost/projetWeb1/emailValidation.php?userid=".$_GET['userid'].'&emailkey='.$_GET['@emailkey'].'&sendemail=false'."\nRegards";
		mail($checkedData['email'], $subject, $message);
		$headerMessage = "You have received an email from bubbleUp to confirm your inscription. If you haven't received it check your unwanted mails";
		$resendEmailDisplay = 'initial';
	} else {
		$headerMessage = "Thanks you for your inscription to bubbleup";
		$resendEmailDisplay = 'none';
		$authentified = new Authentified($_GET['userid']);
		$authentifiedSerialized = serialize($authentified);
		setcookie ('authentified', $authentifiedSerialized);
	}
}
?>




<?php
//Getting user mail:
$userEmail = $_GET['email'];
//initiating PHPMailer
require 'PHPMailer-5.2/PHPMailerAutoload.php';
$mail= new PHPMailer;
$mail->isSMTP();
// $mail->SMTPDebug = 2;
$mail->Host="smtp.gmail.com";
$mail->Port=465;
$mail->SMTPAuth=true;
$mail->SMTPSecure="ssl";

$mail->Username='blaisiustristodontor@gmail.com';
$mail->Password='Hn7t31PxGvTy8';

$mail->setFrom('no-reply@bubbleup.fr','BubbleUp.fr');
$mail->addAddress($userEmail);
$mail->addReplyTo('pharob@superuser.fr');

$mail->isHTML(true);
$mail->Subject='Your BubbleUp account confirmation :';
$mail->Body="Hello,\n
Thank you for your registration to BubbleUp. Please, click on the link to activate your account :\n
www.activersoncompte.etc...";
if(!$mail->send()){
	echo "Message couldn't be sent!";
}
else{
	echo "Message has been sent succesfully!";
}

?>

<div>
	<p><h2><?php echo $headerMessage ?></h2></p>
	<input type="button" onclick="location.href =<?php echo 'emailValidation.php?userid='.$_GET['userid'].'&emailkey='.$_GET['@emailkey'].'&sendemail=true';?>" value="Resend email" style="display=<?php $resendEmailDisplay ; ?>">
</div>




</body>
</html>
