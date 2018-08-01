<?php
require '/includes/connect_db.php';
include('connection.php');
// echo var_dump($_FILES);

if(!empty($_FILES))
{
		// Here the bubbleNumber represent the variable "name" in the input
	$fileName=($_FILES['bubbleNumber']['name']);
	$fileExtension = strrchr($fileName, ".");


	$fileTmpName=$_FILES['bubbleNumber']['tmp_name'];
	$fileDestination='files/'.$fileName;

	$extensionAccepted=array('.gif','.GIF','.jpg','.jpeg','.JPG','.JPEG','.png','.PNG');


	
	if(in_array($fileExtension, $extensionAccepted))
	{

		// echo mime_content_type($fileTmpName);
		// if(mime_content_type($fileTmpName) =='image'){echo "yomama";}

		// $check = explode("/", mime_content_type($_FILES["bubbleNumber"]["tmp_name"]));

		// if ($check[0] !== "image")
		// {
		// 	$uploadMessage = "Only GIF, JPG or PNG are accepted.";

		// 	// return false;
		// } 
		// var_dump($_FILES);

		if(preg_match('/\bimage\b/',$_FILES['bubbleNumber']['type']))
		{

			if(move_uploaded_file($fileTmpName, $fileDestination)){
			// echo "$fileName <br>$fileDestination";
				$req=$db->prepare('INSERT INTO files (name,fileUrl) VALUES (?,?)');
				$req->execute(array($fileName,$fileDestination));
			}


		}

		else
		{
			$uploadMessage = "Only GIF, JPG or PNG are accepted.";

		}

	}
	
	else
	{
		echo "Error while uploading, try to upload again.";

	}
}



?>


<!DOCTYPE html>
<html>
<head>
	<title>HomePage</title>
</head>
<body>

	<div id="Page" align="center">
<!-- 		<h2>Welcome!</h2>
		<form method="POST" action="login.php">
			<input type="submit" value="Connect">
		</form>

		<br>

		<form method="POST" action="createAccount.php">
			<input type="submit" value="Register">
		</form>

		<br>

		<form method="POST" action="testCode.php">
			<input type="submit" value="Test Code">
		</form> -->

		<br>
		<!-- UPLOAD A FILE -->
		<fieldset>
			<legend>Upload your book</legend>
			<br>
			<?php 

			if(isset($uploadMessage))
			{
				echo "<span style='color:red'>$uploadMessage</span><br><br>";
			}
			?>
			<form method="post" enctype="multipart/form-data">



				<label for="icone">1 - Upload a file (JPG, PNG or GIF | max. 10Mo per files) :</label><br />
				<input type="file" name="bubbleNumber" id="bubble"/>
				<!-- <label for="mon_fichier">Fichier (tous formats | max. 1 Mo) :</label><br /> -->
				<!-- <input type="hidden" name="MAX_FILE_SIZE" value="1048576" /> -->
				<!--      <input type="file" name="mon_fichier" id="mon_fichier" /><br /> -->
				<br>

				<br>
				<tr>
					<td>
						<label for="titre">2 - Enter bubble's number :</label>
					</td>
					<td>
						<input type="text" name="titre" placeholder="Bubble's N°" id="titre" />
					</td>
				</tr>

				<br>
<!--      <label for="description">Description de votre fichier (max. 255 caractères) :</label><br />
	<textarea name="description" id="description"></textarea><br /> -->
	<br>
	<input type="submit" name="submit" value="Send file" />
</form>





	<h1>Uploaded images</h1>
	<div class="scrollBubbles">
	<?php 
	$req=$db->query('SELECT name,fileUrl FROM files');

	while($data=$req->fetch()){

	// echo $data['name'];
	// echo $data['fileUrl'];
		$imageData = base64_encode(file_get_contents($data['fileUrl']));
		echo '<br><img src="data:image/jpeg;base64,'.$imageData.'"> 
		<style>
		img{
			width:20%;
			height:auto;
		}
		.scrollBubbles{
			height:400px;
			overflow-y:scroll;
		}
		</style>
		';

	}

	?>
</div>
</fieldset>


</div>



</body>
</html>