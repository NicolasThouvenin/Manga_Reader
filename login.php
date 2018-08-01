    <?php
    session_start();



    include('connection.php');





    global $validationConnetion;

    global $messageConnection;







    $errorConnection="";

    $validationConnetion="";



    function checkAccount()

    {



    	$validationConnetion="";

    	$messageConnection="";



    	global $validationConnetion;

    	global $messageConnection;


    	include('connection.php');


    	$req=$db->prepare("SELECT * FROM members WHERE email ='".$email."' AND password='".$mdp."' LIMIT 1");


    	$req->execute();



    }


    function Init()

    {

    	global $email;

    	global $mail;

    	global $mail2;

    	global $mdp;


    	global $validationConnetion;

    	global $messageConnection;


    	$email = "";



    }






    if (isset($_POST['connectionForm'])) 
    {

        //prevent special chars
    	$email = (htmlspecialchars($_POST['email']));
    	$mdp = (sha1($_POST['mdp']));

//if ok, next hop
    	if (empty($_POST['email']))
    	{

    		$messageConnection="Please enter a email";
    	}
    	else
    	{

            //if mdp is empty, message
    		if(empty($_POST['mdp'])) 
    		{
    			$messageConnection="Please enter a password";
    		}
    		else
    		{

    			$requser=$db->prepare("SELECT * FROM members WHERE email=? AND password=?");
    			$requser->execute(array($email, $mdp));
    			$userexists=$requser->rowCount();
    			if($userexists==1)
    			{
    				$userinfo = $requser->fetch();
    				$_SESSION['id'] = $userinfo['id'];
    				$_SESSION['email'] = $userinfo['email'];
    				$_SESSION['tentatives']=0;
    				// header("Location: profil.php?id=".$_SESSION['id']);
                    echo "You are now connected";

    			}
    			else
    			{
    				$messageConnection= "Wrong Email or Password.";
    			}
    		}
    	}
    }




    init();


    ?>

    <!DOCTYPE html>

    <html lang="en">

    <head>

    	<title>Login</title>

    	<meta http-equiv="Content-Type" content="text/html;charset=utf8" />

    	<link rel="stylesheet" type="text/css" href="style.css">



    </head>

    <body>

    	<div align="center" id="blockForm" class="center">

    		<fieldset>

    			<legend align="Center"><h2>LOGIN</h2></legend>

    			<br/>



    			<form method="POST" action="">



    				<table>

    					<tr align="right">

    						<td>


    						</td>

    						<td>

    							<input type="mail" placeholder="Your Email" name="email" id="email" value="<?php if(isset($email)){echo $email;}?>"/>

    						</td>

    					</tr>

    					<tr align="right">
                            

    						<td>


    						</td>

    						<td>

    							<input type="password" placeholder="Your Password" name="mdp" id="mdp"/>

    						</td>

    					</tr>





    				</table>





    				<br/>

    				<br/>





    				<div align="center">

    					<tr>

    						<td></td>

    						<td>

    							<input type="submit" name="connectionForm" value="Connect" class="button"/>

    						</td>

    					</tr>

    					<tr>

    						<td></td>

    						<br>

    						<td></td>

    						<td>
    							<br>
    							<a href="homePage.php" class="button"><span>&lt </span>Go back to menu</a>



    						</td>

    					</tr>

    				</div>









    			</form>



    			<?php






    			echo "<p style='color:red'>$messageConnection</p>";



    			echo "<p style='color:green'>$validationConnetion</p>";

    			?>



    		</fieldset>

    	</div>







    </body>

    </html>