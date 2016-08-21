<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:41 PM
 */

define('DB_SERVER', 'ap-cdbr-azure-east-c.cloudapp.net');
define('DB_USERNAME', 'b39034f942fc7b');
define('DB_PASSWORD', 'c9441472');
define('DB_DATABASE', 'abscdb');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);






function savePic(){
    $target_dir = "assets/images";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
    if(isset($_POST["submitImage"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


function saveImage() {
    if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
        $maxsize = 20000000;
        $size = $_FILES["file"]['size'];
        if (is_valid_type($_FILES['file']['type'])) {
            if ($size < $maxsize) {
                $TARGET_PATH = 'images/users/';
                $TARGET_PATH.=$_FILES['file']['name'];
//                echo $TARGET_PATH;
//                echo '';
//                die();
                move_uploaded_file($_FILES['file']['tmp_name'], $TARGET_PATH);
                return $TARGET_PATH;
            }
        }
    } else {
        return "";
    }
}
//end function
function is_valid_type($type) {
    // This is an array that holds all the valid image MIME types
    $valid_types = array("image/jpg", "image/jpeg", "image/bmp", "image/gif", "image/png");
    if (in_array($type, $valid_types))
        return true;
    return false;
}
//end is_valid_type()


function verifyUserName($username) {
    $sql = "select * from administrators where email='$username'";
    //echo $sql;
    //	echo "";
    //	die();
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " .connect_error);
    }

    $result = $mysqli->query($sql);

    if (mysqli_num_rows($result) > 0) {
        return TRUE;
    }
    return FALSE;
}
//end function

function verifyPassword($username, $password) {
    $sql = "select * from administrators where ad_email='$username' and ad_password = '$password'";
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    $result = $mysqli->query($sql);
    if (mysqli_num_rows($result) > 0) {
        return TRUE;
    }
    return FALSE;
}
//end function


function verifyUser($username, $password) {
    if (verifyUserName($username)) {
        if (verifyPassword($username, $password)) {
            return true;
        }
        return true;
    }
    return false;
}
//end function


function is_admin() {
    if (isset($_SESSION['is_admin_logged_in'])) {
        return true;
    } else {
        return false;
    }
}
//end function



// Simple function to avoid SQL Injection.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// end function



?>