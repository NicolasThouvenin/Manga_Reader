<?php
// require '/includes/connect_db.php';
include('connection.php');
// echo var_dump($_FILES);
// THIS FUNCTION Check the files and send an uploadMessage if not true
if(!empty($_FILES))
{
	// IN CASE OF BUUBBLE -------------------------------------------------------------------------------->
// Here the bubbleNumber represent the variable "name" in the input

	if(isset($_FILES['bubbleNumber']))
	{
		$bubbleName=($_FILES['bubbleNumber']['name']);
		$bubbleFileExtension = strrchr($bubbleName, ".");
		$bubbleTmpName=$_FILES['bubbleNumber']['tmp_name'];
		$bubbleDestination='libraries/BD/'.$bubbleName;
		if(!empty($_FILES))
		{
// Here the bubbleNumber represent the variable "name" in the input
			if(isset($_FILES['bubbleNumber'])){
				$bubbleName=($_FILES['bubbleNumber']['name']);
				$bubbleFileExtension = strrchr($bubbleName, ".");
				$bubbleTmpName=$_FILES['bubbleNumber']['tmp_name'];
				$bubbleDestination='libraries/BD/'.$bubbleName;
			}
			if(isset($_FILES['coverNumber'])){
				$coverName=($_FILES['coverNumber']['name']);
				$coverFileExtension = strrchr($coverName, ".");
				$coverTmpName=$_FILES['coverNumber']['tmp_name'];
				$coverDestination='libraries/covers/'.$coverName;
			}
			$extensionAccepted=array('.gif','.GIF','.jpg','.jpeg','.JPG','.JPEG','.png','.PNG');


			if(in_array($bubbleFileExtension, $extensionAccepted) or (in_array($coverFileExtension, $extensionAccepted)))
			{
		// if it is a bubble
				if(preg_match('/\bimage\b/',$_FILES['bubbleNumber']['type'])or(preg_match('/\bimage\b/',$_FILES['coverNumber']['type'])))
				{
			// It will move the file name to the destination 
					if(move_uploaded_file($bubbleTmpName, $bubbleDestination)){
						$req=$db->prepare('INSERT INTO files (name,fileUrl) VALUES (?,?)');
						$req->execute(array($bubbleName,$bubbleDestination));
					}
				}
		// if it is a cover
				elseif(preg_match('/\bimage\b/',$_FILES['coverNumber']['type']))
				{
			// It will move the file name to the destination 
					if(move_uploaded_file($coverTmpName, $coverDestination)){
						$req=$db->prepare('INSERT INTO files (name,fileUrl) VALUES (?,?)');
						$req->execute(array($coverName,$coverDestination));
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
	}
	//  END OF BUBBLE CASE --------------------------------------------------------------------------->


	// IN CASE OF COVER CASE ------------------------------------------------------------------------->

	if(isset($_FILES['coverNumber'])){
		$coverName=($_FILES['coverNumber']['name']);
		$coverFileExtension = strrchr($coverName, ".");
		$coverTmpName=$_FILES['coverNumber']['tmp_name'];
		$coverDestination='libraries/covers/'.$coverName;
// file check for cover
// THIS FUNCTION Check the files and send an uploadMessage if not true
		if(!empty($_FILES)){
		// Here the bookCover represent the variable "name" in the input
			$fileName=($_FILES['coverNumber']['name']);
			$fileExtension = strrchr($fileName, ".");
			$fileTmpName=$_FILES['coverNumber']['tmp_name'];
			$fileDestination='libraries/covers/'.$fileName;
			$extensionAccepted=array('.gif','.GIF','.jpg','.jpeg','.JPG','.JPEG','.png','.PNG');
			if(in_array($fileExtension, $extensionAccepted)){
				if(preg_match('/\bimage\b/',$_FILES['coverNumber']['type']))
				{
			// It will move the file name to the destination 
					if(move_uploaded_file($fileTmpName, $fileDestination)){
						$req=$db->prepare('INSERT INTO covers (name,fileUrl) VALUES (?,?)');
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
		else{
			echo "errors";
		}
	}
}

?>
<!-- // end of cover case--------------------------------------------------------------- -->
<!-- End of checking $_FILES -->



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
					<label>Synopsis : <textarea rows="5" cols="40" name="synopsis" placeholder="Explain in summary your book" required="required"></textarea></label><br><br>
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


		<?php }	?>
		<!-- BEGIN OF COVER UPLOAD --------------------------------------------------------------------------->
		<br><br>
		<form method="POST">
			<input type="submit" value="Upload your cover" name="uploadCover">
		</form>

		<!-- UPLOAD COVER -->
		<?php if(isset($_POST['uploadCover']) or (isset($_POST['sendCover'])) ){?>
			<br>
			<form method="POST" enctype="multipart/form-data">
				<label for="icone">Upload a Cover (JPG, PNG or GIF | max. 10Mo per files) :</label><br />
				<input type="file" name="coverNumber" id="cover"/><br><br>
				<input type="submit" name="sendCover" value="Send cover" />
			</form>

			<?php if(isset($_POST['sendCover'])){?>
				<!-- HERE YOU WILL HAVE A VIEW OF WHAT YOU HAVE JUST UPLOADED -->
				<h1>Uploaded Cover</h1>

				<!-- <div> -->
					<?php 
					$req=$db->query('SELECT name,fileUrl FROM covers');
					while($data=$req->fetch()){

						$imageData = base64_encode(file_get_contents($data['fileUrl']));
						echo '<br><img src="data:image/jpeg;base64,'.$imageData.'"> 
						<style>
						img{
							width:20%;
							height:auto;
						}
						</style>
						';
					}
					?>
					<!-- </div> -->
				<?php } ?>
			<?php } ?>
			<!-- END OF COVER UPLOAD ----------------------------------------------------------------------------->




			<!-- BEGIN OF BUBBLE UPLOAD -------------------------------------------------------------------------->
			<br><br>
			<form method="POST">
				<input type="submit" value="Upload your bubbles" name="uploadBubble">
			</form>

			<!-- UPLOAD BOOKS -->
			<?php if(isset($_POST['uploadBubble']) or (isset($_POST['sendBubble']))){?>
				<br>
				<form method="POST" enctype="multipart/form-data">
					<label for="icone">Upload a Bubble (JPG, PNG or GIF | max. 10Mo per files) :</label><br />
					<input type="file" name="bubbleNumber" id="bubble"/><br><br>
					<input type="submit" name="sendBubble" value="Send Bubble" />
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
			<!-- END OF BUBBLE UPLOAD ----------------------------------------------------------------------------------------->

		</div><!-- End of page DIV -->

	</body>
	</html>