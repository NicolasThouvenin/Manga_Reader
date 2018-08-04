<?php
// require '/includes/connect_db.php';
include('connection.php');
// echo var_dump($_FILES);

// THIS FUNCTION Check the files and send an uploadMessage if not true
if(!empty($_FILES))
{
		// Here the bubbleNumber represent the variable "name" in the input
	$fileName=($_FILES['bubbleNumber']['name']);
	$fileExtension = strrchr($fileName, ".");
	$fileTmpName=$_FILES['bubbleNumber']['tmp_name'];
	$fileDestination='libraries/BD/'.$fileName;
	$extensionAccepted=array('.gif','.GIF','.jpg','.jpeg','.JPG','.JPEG','.png','.PNG');
	
	if(in_array($fileExtension, $extensionAccepted))
	{
		if(preg_match('/\bimage\b/',$_FILES['bubbleNumber']['type']))
		{
			// It will move the file name to the destination 
			if(move_uploaded_file($fileTmpName, $fileDestination)){
				$req=$db->prepare('INSERT INTO files (name,fileUrl) VALUES (?,?)');
				$req->execute(array($fileName,$fileDestination));
			}
		}
		else{
			$uploadMessage = "Only GIF, JPG or PNG are accepted.";
		}
	}	
	else
	{
		echo "Error while uploading, try to upload again.";
	}
}
?>
<!-- End of checking Files -->



<!DOCTYPE html>
<html>
<head>
	<title>Designer</title>
</head>
<body>

	<div id="Page" align="center">
		<h1>Designer</h1>
		<form method="POST">
			<input type="submit" value="Create a New Book" name="createANewBook">
		</form>
		<br>


		<!-- HERE YOU WILL CREATE AND UPLOAD YOUR NEW BOOK -->
		<?php
		if(isset($_POST['createANewBook'])){
			?>
			<fieldset>
				<legend>Your Book</legend>
				<form method="POST">
					<label>Title : <input type="text" name="title" placeholder="Name of your book" required="required" /></label><br/><br>
					<!-- <label>Author : <input type="text" name="author" placeholder="Name of the author" required="required"/></label><br/><br> -->
					<label>Genres : <select id="genres" multiple name="genres[]" required="required">
						<option value="action">Action</option> 
						<option value="adventure">Adventure</option>
						<option value="comedy">Comedy</option>
						<option value="horror">Horror</option>
						<option value="fantasy">Fantasy</option>
						<option value="psychological">Psychological</option>
						<option value="scienceFiction">Science fiction</option>
						<option value="thriller">Thriller</option>
					</select></label><br/><br>
					<label>Synopsys : <textarea rows="5" cols="40" name="synopsis" placeholder="Explain in summary your book" required="required"></textarea></label><br><br>
					<!-- don't forget to put a catcha here  -->
					<input type="submit" name="validateNewBook" value="Validate"/>
				</form>
			</fieldset>
		<?php } ?>

		<!-- This block summarizes all the information provided by the user -->
		<?php
		if(isset($_POST['validateNewBook'])){
			?>
			
			<div class="bookInformation">
				<fieldset>
					<legend>Your Book information :</legend>
					Title : <br>
					<?php echo $_POST['title']; ?>
					<br><br>
					Genres : <br>
					<?php foreach(($_POST['genres'])as $bookGenres){echo $bookGenres."<br>";} ?> 
					<br>
					Synopsis : <br>
					<?php echo $_POST['synopsis']; ?>
				</fieldset>
			</div>
			<br><br>
			<form method="POST">
				<input type="submit" value="Start to upload your bubbles" name="uploadBubble">
			</form>
		<?php }	?>


		<!-- UPLOAD BOOKS -->
		<?php if(isset($_POST['uploadBubble']) or (isset($_POST['sendBubble']))){?>
			<br>
			<form method="POST" enctype="multipart/form-data">
				<label for="icone">Upload a file (JPG, PNG or GIF | max. 10Mo per files) :</label><br />
				<input type="file" name="bubbleNumber" id="bubble"/><br><br>
				<input type="submit" name="sendBubble" value="Send file" />
			</form>

			<?php if(isset($_POST['sendBubble'])){?>
				<!-- HERE YOU WILL HAVE A VIEW OF WHAT YOU HAVE JUST UPLOADED -->
				<h1>Uploaded bubbles</h1>
				<div class="scrollBubbles">
					<?php 
					$req=$db->query('SELECT name,fileUrl FROM files');
					while($data=$req->fetch()){
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
			<?php } ?>
		<?php } ?>

	</div><!-- End of page DIV -->

</body>
</html>