

<!DOCTYPE html>
<html>
<head>
	<title>Email validation</title>
	<meta charset="utf-8">
</head>
<body>

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


	<div>
		<p><?php $headerMessage ?></p>
		<input type='button' onclick="location.href =
			<?php echo 'emailValidation.php?userid='.$_GET['userid'].'&emailkey='.$_GET['@emailkey'].'&sendemail=true';
			?>
		
		value="Resend email" style="display=<?php $resendEmailDisplay ?>;">
	</div>
</body>
</html>