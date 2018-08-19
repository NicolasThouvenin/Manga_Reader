<?php
require('connection.php');
try {
	if(isset($_GET['userid']) && isset($_GET['emailkey']) && isset($_GET['sendemail'])) {
		$emailKey = htmlspecialchars($_GET['emailkey']);
		$userId = htmlspecialchars($_GET['userid']);		
		if($_GET['sendemail'] == true) {
			$reqUser = $db->prepare("SELECT * FROM users WHERE id = ? AND emailkey = ?");
			$reqUser->execute(array($userId, $emailKey));
			$userExist = $reqUser->rowCount();
			if($userExist == 1){
				$updateUser = $db->prepare("UPDATE users SET emailValidated = 1 WHERE id = ? AND emailKey = ?");
				$updateUser->execute(array($userId,$emailKey));
				echo "<p>Your account is now activated. Welcome to BubbleUp!</p><br>
				<a href='http://ns3272345.ip-5-39-84.eu/homePage.php'><button type='button'>Go to Menu</button></a>";

				$authentified = new Authentified($_GET['userid']);
				$authentifiedSerialized = serialize($authentified);
				setcookie ('authentified', $authentifiedSerialized);
			}
			else{
				echo "Your account is already activated.";
			}
		}
	}
}catch (Exception $e) {

}
?>
