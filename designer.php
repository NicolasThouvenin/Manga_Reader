<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>My Blog</title>
        <link rel="stylesheet" type="text/css" href="myStyle.css">
    </head>
    <body>
        <div class="page">
            <header>
                <input class="add" type='button' onclick="location.href='myCreations.php';" value="Add Creation">
                <div class="logo"><a href="homePage.php">LOGO</a></div>
                <div class="displayUser">
            <?php
                session_start();
                $picPath = "library/";
                $_SESSION["picId"] = 0;
                if (isset($_SESSION["userName"])) {
                    // SELECT on user table with userName
                    echo "<img src='".$avatar."' alt='avatar'>";
                    echo "<p>".$userName."</p>";
                } else {
                    //header("Location:login.php");
                }

            ?>


            </header>
            <main>
                <?php
                    if (isset($_POST["submit"])) {
                        /**
                         * Check if the picture is valid
                         * 
                         * @return String The picture's extention, or FALSE IF ERROR
                         */
                        function myCheckPic()
                        {
                            $check = explode("/", mime_content_type($_FILES["bubble"]["tmp_name"]));
                            if ($check[0] !== "image") {
                                return false;
                            } else {
                                return $check[1];
                            }
                        }

                        if ($_FILES["bubble"]["tmp_name"] !== "") {
                            if (!$type = myCheckPic()) {
                                //header("Location:designer.php?error=invalid");
                            }
                            $_SESSION["picId"]++;
                            $uploadFile = $picPath.$_SESSION["picId"].".".$type;
                            if (move_uploaded_file($_FILES["bubble"]["tmp_name"], $uploadFile)) {
                                echo "<img src='".$uploadFile."' alt='bubble'>";
                            } else {
                                echo "error, the file ".basename($_FILES["bubble"]["name"])." could not be uploaded.<br>";
                            }

                            
                    }
                }



                ?>
                <form id="uploadFile" action="designer.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="bubble" required="required">
                    <input type="submit" value="Send" name="submit">
                </form>
                <?php
                    if (isset($_GET["error"])) {
                        echo "<span style='color: red;'>The file's format is invalid, accepted format are GIF, JPG, JPEG, PNG<span>";
                    }


            ?>
            </main>
        </div> <!-- page -->
    </body>
</html>
