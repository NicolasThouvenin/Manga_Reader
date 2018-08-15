<?php
require('required.php');
if (isset($_POST['settleChapter'])) {
    /**
     * Check the type of every image uploaded
     */
    try {
        $nbr_file = count($_FILES["uploadedBubble"]["tmp_name"]);

        for ($i = 0; $i < $nbr_file; $i++) {
            $check = explode("/", mime_content_type($_FILES["uploadedBubble"]["tmp_name"][$i]));
            if ($check[0] !== "image") {
                // The file isn't an valid image
                echo "<script>alert('Error : File " . $_FILES["uploadedBubble"]["name"][$i] . " is not a valid image.');</script>";
                unset($_POST['settleChapter']);
            }
        }
        require('connection.php');


        /* Set the parameters for createChapter.sql */
        $chapterTitle = htmlentities($_POST['chapterTitle']);
        $chapterSynopsis = htmlentities($_POST['chapterSynopsis']);
        $date = date("Y-m-d");
        $volumeId = htmlentities($_GET["volumeId"]);

        /* Prepare and execute the stored procedure createChapter */
        $createChapter = $db->prepare("CALL createChapter(:title, :synopsis, :date, :volumeId, @lastChapterId, @lastChapterNumber)");
        $createChapter->bindParam(':title', $chapterTitle, PDO::PARAM_STR, 255); // binding all parameters
        $createChapter->bindParam(':synopsis', $chapterSynopsis, PDO::PARAM_STR, 255);
        $createChapter->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $createChapter->bindParam(':volumeId', $volumeId, PDO::PARAM_INT);
        $createChapter->execute();
        $createChapter->closeCursor();

        /* Fetch the result of the procedure */
        $result = $db->query("SELECT @lastChapterId, @lastChapterNumber")->fetch(PDO::FETCH_ASSOC);

        /* Create the Chapter object corresponding to the chapter inserted */
        $chapter = new Chapter($result['@lastChapterId'], $result['@lastChapterNumber'], $chapterTitle, $chapterSynopsis, false, $date);

        foreach ($_FILES["uploadedBubble"]["tmp_name"] as $strip) {
            /* Add each strip to the Chapter object */
            $chapter->AddComicStrip($strip);
        }

        /* SQL Querry to fetch the corresponding Comic Id */
        try {
            require('connection.php');
            $result = $db->prepare("SELECT comicId FROM volumes WHERE Id = :volumeId");
            $result->execute(array('volumeId' => $volumeId));
            $line = $result->fetch();

            /* Redirect to the comic page */
            header("Location:comic.php?bookId=".$line['comicId']);
        } catch (Exception $e) {
            throw new Exception("<br>Error fetching the comicId of the new chapter : " . $e->getMessage());
        }
    } catch (Exception $e) {
        die('Error during chapter creation : ' . $e->getMessage());
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
if (isset($_COOKIE['authentified'])) {
    $user = unserialize($_COOKIE['authentified']);
    // Only a connected user can upload
    echo "<p class='userName'>" . $user->getLogin() . "</p>";
    echo "<p><a class='userName' href='disconnect.php'>Log out</a></p>";
} else {
    // Redirect to Login
    header("Location:login.php");
}
?>
                </div> <!-- displayUser -->
                <div class="logo"><a href="homePage.php"><a href="homePage.php"><img src="ressources/bubbleLogo.png"></a></div>
            </header>

            <main>
                <h1>New Chapter</h1>
                <fieldset><legend>Bubbles Upload</legend> <!-- form for informations about the chapter and upload -->
                    <form method="POST" enctype="multipart/form-data" action="newChapter.php?volumeId=<?php echo $_GET["volumeId"]; ?>">
                        <p id="first_chapter">Chapter Title : <input type="text" name="chapterTitle" placeholder="Chapter Title" required></p><br>
                        <p>Chapter Synopsis : <textarea name="chapterSynopsis" placeholder="Chapter Synopsis" cols="40" rows="3" required="required"></textarea></p><br>
                        <p>Upload your bubbles here, once you confirm you will settle your chapter.</p>
                        <label for="gallery-photo-add">Upload a file (JPG, PNG or GIF) :</label><br>
                        <input type="file" accept="image/*"  multiple id="gallery-photo-add" name="uploadedBubble[]" required>
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
