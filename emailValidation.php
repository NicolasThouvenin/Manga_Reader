<?php
if (isset($_GET['userid']) && isset($_GET['emailkey']) && isset($_GET['sendemail'])) {
	if ($_GET['sendemail'] == true) {
		$headerMessage = "You have received an email from bubbleUp to confirm your registration. If you haven't received it check your unwanted mails";
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

<div>
	<p><h2><?php echo $headerMessage ?></h2></p>
	<input type="button" onclick="location.href =<?php echo 'emailValidation.php?'.'&userid='.$_GET['userid'].'&emailkey='.$_GET['@emailkey'].'&sendemail=true';?>" value="Resend email" style="display=<?php $resendEmailDisplay ; ?>">
</div>




</body>
</html>
