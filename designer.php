<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css\main_lg.css">
    </head>
    <body>
        <div class="page">
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
                <?php
// require '/includes/connect_db.php';
include('connection.php');
// echo var_dump($_FILES);
// THIS FUNCTION Check the files and send an uploadMessage if not true
if(!empty($_FILES))
{

    // IN CASE OF COVER  ------------------------------------------------------------------------->

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
            $fileDestination='comics/2/'.$fileName;
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

    <div id="Page" align="center">
        <h1>Designer</h1>
<!--        <form method="POST">
            <input type="submit" value="Create a New Book" name="createANewBook">
        </form>
        <br> -->


        <!-- HERE YOU WILL CREATE AND UPLOAD YOUR NEW BOOK -->
            <fieldset>
                <legend><h3>Comic information</h3></legend>
                <form method="POST" enctype="multipart/form-data">
                    <label>Title : <input type="text" name="inTitle" placeholder="Name of your book" required="required" /></label><br/><br>
                    <label>Creation date :<input type="date" name="inStartDate" required="required"></label><br><br>
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
                    <label>Synopsis : <textarea rows="5" cols="40" name="inSynopsis" placeholder="Explain in summary your book" required="required"></textarea></label><br><br>
                    



                    <!-- BEGIN OF COVER UPLOAD --------------------------------------------------------------------------->
<!--
        <br>
        <!-- <form method="POST" enctype="multipart/form-data"> -->
            <label for="icone">Upload a Cover (JPG, PNG or GIF | max. 10Mo per files) :</label><br />
            <input type="file" name="coverNumber" id="cover"/><br><br>
            <!-- <input type="submit" name="sendCover" value="Send cover" /> -->
            <!-- </form> -->


            <!-- END OF COVER UPLOAD ----------------------------------------------------------------------------->



<fieldset>
    <legend><h3>First volume information</h3></legend>
<label>First volume title : <input type="text" name="volumeTitle" placeholder="Title of the volume" required="required" /></label><br/><br>
<label>Volume synopsis : <textarea rows="5" cols="40" name="volumeSynopsis" placeholder="Enter the synopsis of the volume" required="required"></textarea></label><br><br>
</fieldset>
<br>


            <!-- don't forget to put a catcha here  -->
            <input type="submit" name="validateNewBook" value="Validate"/>
        </form>
    </fieldset>


<!-- This block summarizes all the information provided by the user >>>>>>>>>>>>>>>>>>>>>>>-->
<?php
if(isset($_POST['validateNewBook'])){
    ?>



<br><br>

    <div class="bookInformation">
        <fieldset>
            <legend><h2>Uploaded Book information :</h2></legend>

            <!-- HERE YOU WILL HAVE A VIEW OF WHAT YOU HAVE JUST UPLOADED -->
            <label>Cover :

<!-- <?php 
echo '<br><img src="data:image/jpeg;base64,'.$imageData.'">
                <style>
                img{
                    width:20%;
                    height:auto;
                }
                </style>
                ';
 ?> -->
<!-- <?php echo base64_encode(file_get_contents($fileDestination)); ?> -->

             <?php 
            $req=$db->query('SELECT name,fileUrl FROM covers');
            if($data=$req->fetch()){
                $imageData = base64_encode(file_get_contents($fileDestination));
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
                
            </label><br>
            <br>
            Title : <br>
            <?php echo $_POST['inTitle']; ?>
            <br><br>
            Creation date :<br>
            <?php echo $_POST['inStartDate']; ?><br><br>
            Genres : <br>
            <?php foreach(($_POST['genres'])as $bookGenres){echo $bookGenres."<br>";} ?> 
            <br>
            Synopsis : <br>
            <?php echo $_POST['inSynopsis']; ?>

            <br><br>
                        <input type="submit" name="confirmNewBook" value="Confirm volume"/>
        </fieldset>
    </div>
    <br><br>

    <!-- END OF SUMMARIZE<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< -->
<?php
// if(isset($_POST['confirmNewBook'])){header}
?>
<?php } ?>





<!-- BEGIN OF BUBBLE UPLOAD -------------------------------------------------------------------------->
<!--            <br><br>
            <form method="POST">
                <input type="submit" value="Upload your bubbles" name="uploadBubble">
            </form> -->

            <!-- UPLOAD BOOKS -->
<!--            <?php if(isset($_POST['uploadBubble']) or (isset($_POST['sendBubble']))){?>
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




<!--                        <?php 
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
                        ?> -->


                    </div>
                <?php } ?>
                <?php } ?> -->
                <!-- END OF BUBBLE UPLOAD ----------------------------------------------------------------------------------------->

            </div><!-- End of page DIV -->

            </main>


        </div> <!-- page -->
    </body>
</html>
