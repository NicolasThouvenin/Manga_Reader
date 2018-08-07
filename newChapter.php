<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css\main_lg.css">
</head>
<body>
	<div class="page" align="center">
		<header>
			<input class="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation">

			<div class="displayUser">
				<?php
				require('required.php');

				session_start();
				if (isset($_COOKIE['user'])) {
					$user = unserialize($_COOKIE['user']);
                        // if a user is connected
					echo "<p class='userName'>" . $user->getLogin() . "</p>";
					echo "<p><a class='userName' href='disconnect.php'>Log out</a></p>";
				} else {
					?>
					<input type='button' onclick="location.href = 'login.php';" value="Log in" >
					<input type='button' onclick="location.href = 'register.php';" value="Register" >
					<?php
				}
				?>
			</div> <!-- displayUser -->

			<div class="logo"><a href="homePage.php">LOGO</a></div>

		</header>



		<main>
	
        <h1>New Chapter</h1>
        <fieldset><legend>Bubbles Upload</legend>
            <p>Upload your bubbles here, once you confirm you will settle your chapter.</p>

            <?php
// THIS BLOCK IS FOR BUBBLE UPLOADING
// THIS FUNCTION Check the files and send an uploadMessage if not true
            if(!empty($_FILES))
            {
        // Here the uploadedBubble represent the variable "name" in the input
                $fileName=($_FILES['uploadedBubble']['name']);
                $fileExtension = strrchr($fileName, ".");
                $fileTmpName=$_FILES['uploadedBubble']['tmp_name'];
                $fileDestination='comics/2/1/1/'.$fileName;
                $extensionAccepted=array('.gif','.GIF','.jpg','.jpeg','.JPG','.JPEG','.png','.PNG');

                if(in_array($fileExtension, $extensionAccepted))
                {
                    if(preg_match('/\bimage\b/',$_FILES['uploadedBubble']['type']))
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
            <!-- END OF BUBBLE UPLOADING BLOCK -->

            <br>
            <form method="POST" enctype="multipart/form-data">
                <label for="icone">Upload a file (JPG, PNG or GIF) :</label><br>
                <input type="file" name="uploadedBubble" id="bubble"/><br><br>
                <input type="submit" name="sendBubble" value="upload this bubble" />
            </form>

            <?php 
            if(isset($_POST['sendBubble'])){?>
                <h1>Uploaded bubbles</h1><!-- HERE YOU WILL HAVE A VIEW OF WHAT YOU HAVE JUST UPLOADED -->
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

        </fieldset><br><br>

        <form method="POST">
            <input type="submit" value="Settle Chapter" name="settleChapter">
        </form>     <!-- End of book cover upload -->
        </main>


    </div> <!-- page -->
</body>
</html>
