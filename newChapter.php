<?php
if (isset($_POST['settleChapter'])) {
    try {

        $nbr_file = count($_FILES["uploadedBubble"]["tmp_name"]);
        echo $nbr_file;

        for ($i = 0; $i < $nbr_file; $i++) {
            $check = explode("/", mime_content_type($_FILES["uploadedBubble"]["tmp_name"][$i]));
            if ($check[0] !== "image") {
                echo "<script>alert('Error : File " . $_FILES["uploadedBubble"]["name"][$i] . " is not a valid image.');</script>";
                unset($_POST['settleChapter']);
                //echo "<script>location.href = 'newChapter.php'</script>";
                //header("Location:login.php");
            }
        }
        require('connection.php');

        $chapterTitle = htmlentities($_POST['chapterTitle']);
        $chapterSynopsis = htmlentities($_POST['chapterSynopsis']);
        $date = date("Y-m-d");
        $volumeId = htmlentities($_GET["volumeId"]);
        $createChapter = $db->prepare("CALL createChapter(:Title, :Synopsis, :VolumeId, @lastChapterId)");
        $createChapter->bindParam(':Title', $chapterTitle, PDO::PARAM_STR, 255);
        $createChapter->bindParam(':Synopsis', $chapterSynopsis, PDO::PARAM_STR, 255);
        $createChapter->bindParam(':VolumeId', $volumeId, PDO::PARAM_INT);
        $createChapter->execute();
        $createChapter->closeCursor();
        $result = $db->query("SELECT @lastChapterId")->fetch(PDO::FETCH_ASSOC);
        $chapter = new Chapter($result['@lastChapterId']);
        
        foreach ($_FILES["uploadedBubble"]["tmp_name"] as $strip) {
            $chapter->AddComicStrip($strip);
        }
        
          header("Location:homePage.php");
    } catch (Exception $e) {
        die('Error during bubble creation : ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>New Chapter</title>
        <link rel="stylesheet" type="text/css" href="css\main_lg.css">
        <link rel="icon" href="ressources/favicon.ico" type="image/x-icon" >
    </head>
    <body>

        <div class="page">
            <header>
                <input class="add" type='button' onclick="location.href = 'designerHome.php';" value="Add Creation" style="visibility: hidden;">

                <div class="displayUser">
                    <?php
                    require('required.php');


                    if (isset($_COOKIE['authentified'])) {
                        $user = unserialize($_COOKIE['authentified']);
                        // if a user is connected
                        echo "<p class='userName'>" . $user->getLogin() . "</p>";
                        echo "<p><a class='userName' href='disconnect.php'>Log out</a></p>";
                    } else {
                        header("Location:login.php");
                    }
                    ?>
                </div> <!-- displayUser -->
                <div class="logo"><a href="homePage.php">LOGO</a></div>
            </header>

            <main>
                <h1>New Chapter</h1>
                <fieldset><legend>Bubbles Upload</legend>
                    <form method="POST" enctype="multipart/form-data" action="newChapter.php">
                        <p id="first_chapter">Chapter Title : <input type="text" name="chapterTitle" placeholder="Chapter Title" required></p><br>
                        <p>Chapter Synopsis : <textarea name="chapterSynopsis" placeholder="Chapter Synopsis" cols="40" rows="3" required="required"></textarea></p><br>
                        <p>Upload your bubbles here, once you confirm you will settle your chapter.</p>
                        <label for="gallery-photo-add">Upload a file (JPG, PNG or GIF) :</label><br>
                        <input type="file" accept="image/*"  multiple id="gallery-photo-add" name="uploadedBubble[]" required>
                        <!-- <input type="submit" name="sendBubble" value="upload this bubble" /> -->
                        <input type="submit" value="Settle Chapter" name="settleChapter">

                    </form>
                </fieldset>


                <!-- Some style for test ----------------should be put in separated file .css ----------------->
                <style type="text/css">
                    img{
                        max-width:180px;
                    }
                    input[type=file]{
                        padding:10px;
                        background:#2d2d2d;}
                    </style>

                    <!-- Some script for test --------------should be put in separated file .js ------------------->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                    <div class="gallery"></div>
                <script type="text/javascript">
                    $(function () {
                        // Multiple images preview in browser
                        var imagesPreview = function (input, placeToInsertImagePreview) {
                            if (input.files) {
                                var filesAmount = input.files.length;
                                for (i = 0; i < filesAmount; i++) {
                                    var reader = new FileReader();
                                    reader.onload = function (event) {
                                        $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                                    };
                                    reader.readAsDataURL(input.files[i]);
                                }
                            }
                        };
                        $('#gallery-photo-add').on('change', function () {
                            imagesPreview(this, 'div.gallery');
                        });
                    });
                </script>
        </div> <!-- page -->
    </body>
</html>