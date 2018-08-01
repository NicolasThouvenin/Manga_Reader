<?php
include('connection.php');
$registererror="";

$registervalidate="";



function Init()

{
	$nickname = "";

	$email = "";

	$email2 = "";

	$mdp = "";

	global $nickname;

	global $email;

	global $email2;

	global $mdp;






}


Init();


function insertmember(){
	include('connection.php');
	$insertmember=$db->prepare("INSERT INTO members(nickname,email,password) VALUES(:nickname,:email,:password)");
	$insertmember->execute(array('nickname'=>$_POST['nickname'],'email'=>$_POST['email'],'password'=>sha1($_POST['mdp'])));

}





if (isset($_POST['subscriptionform'])) 
{



	$nickname = (htmlspecialchars($_POST['nickname']));

	$email = (htmlspecialchars($_POST['email']));

	$email2 = (htmlspecialchars($_POST['email2']));

	$mdp = (sha1($_POST['mdp']));

	$mdp2 = (sha1($_POST['mdp2']));



	if (!empty($_POST['nickname']) AND ! empty($_POST['email']) AND ! empty($_POST['email2']) AND ! empty($_POST['mdp']) AND ! empty($_POST['mdp2'])) 
	{



				 //Verify nickname length
		$nicknamelength = strlen($nickname);

		$pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
		if (!preg_match($pattern, $nickname) AND ($nicknamelength <= 40)){


			if ($email == $email2) 
			{

				if(filter_var($email, FILTER_VALIDATE_EMAIL))
				{

                	//Si le nickname respectait la longueur, on poursuit sur la vérification des emails

					if ($mdp == $mdp2) 
					{
						//CHECKING THE nickname 
						$reqnickname=$db->prepare("SELECT * FROM members WHERE nickname=?");
						$reqnickname->execute(array($nickname));
						$nicknameexists=$reqnickname->rowCount();
						if($nicknameexists==0)
						{
							//CHECKING MAIL
							$reqemail=$db->prepare("SELECT * FROM members WHERE email=?");
							$reqemail->execute(array($email));
							$emailexists=$reqemail->rowCount();
							if($emailexists==0)
							{
								insertmember($nickname,$email,$mdp);
								$registervalidate="Succesfully registered!";
							}
							else
							{
								$registererror="Email already taken.";
							}


						}

						else
						{
							$registererror= "Nickname already taken";

						}
					}
					else 
					{

						$registererror = "Passwords doesn't match.";

					}
				}
				else
				{

					$registererror = "Email not valid";

				}

			} 
			else 
			{

				$registererror = "The emails are not matching.";

			}

		} 
		else 
		{

			$registererror = "Nickname too long or must not contain any special characters.";

		}
	}




	else
	{

		$registererror = "Please fill in the missing parts.";

	}
}




?>




<!DOCTYPE html>

<html lang="fr">

<head>

	<title>Sign Up</title>

	<meta http-equiv="Content-Type" content="text/html;charset=utf8" />

	<link rel="stylesheet" type="text/css" href="style.css">




</head>

<body>

	<div align="center" id="page">

		<fieldset>

			<legend align="Center"><h2>Sign Up</h2></legend>

			<!-- <br/> -->



			<form method="POST">

				<table>

					<tr align="right">

						<td>


						</td>

						<td>

							<input type="text" placeholder="Your nickname" name="nickname" id="nickname" value="<?php if(isset($nickname)){echo $nickname;} ?>"/>

						</td>

					</tr>








					<tr align="right">

						<td>


						</td>

						<td>

							<input type="email" placeholder="Your email" name="email" id="email" value="<?php if(isset($email)){echo $email;} ?>"/>

						</td>

					</tr>






					<tr align="right">

						<td>


						</td>

						<td>

							<input type="email" placeholder="Confirm email" name="email2" id="email2" value="<?php if(isset($email2)){echo $email2;} ?>"/>

						</td>

					</tr>









					<tr align="right">

						<td>


						</td>

						<td>

							<input type="password" placeholder="Your password" name="mdp" id="mdp"/>

						</td>

					</tr>









					<tr align="right">

						<td>


						</td>

						<td>

							<input type="password" placeholder="Confirm your password" name="mdp2" id="mdp2"/>

						</td>

					</tr>





				</table>





				<br/>







				<div align="center">

					<br>
					<tr>

						<td></td>

						<td>

							<input type="submit" name="subscriptionform" value="Create your account" class="button" />

						</td>

					</tr>

					<tr>

						<td></td>

						<br>

						<td></td>
						<br>
						<td>

							<a href="homePage.php" class="button"><span>&lt </span>Return to menu</a>

						</td>

					</tr>

				</div>









			</form>



			<?php


			echo "<p style='color:red'>$registererror</p>";


			echo "<p style='color:green'>$registervalidate</p>";


			?>

		</fieldset>

	</div>









</body>

</html>