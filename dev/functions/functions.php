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



function add_asset() {
    $asset_ID = $_POST['assetID'];
    $asset_Name = $_POST['assetName'];
    $asset_Type = $_POST['assetType'];
    $asset_Description = $_POST['assetDescription'];
    $quantity = $_POST['quantity'];
    $cat_ID = $_POST['categoryID'];
    $image = saveImage();

    $sql = "insert into asset (assetID,assetName,assetType,assetDescription,image,quantity,categoryID)
            values('$asset_ID','$asset_Name','$asset_Type','$asset_Description','$quantity','$image','$cat_ID')";

    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    $mysqli->query($sql);
    $mysqli->close();
}
//end function


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
    $sql = "select * from administrators where ad_email='$username'";
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


function getAllRegisteredUsers() {
    $sql = "select * from volunteers ORDER BY vol_firstname";
    $mysqli = new mysqli(host, user, password, database);
    $result = $mysqli->query($sql);
    $mysqli->close();
    return $result;
}
//end function
function getUserSubmissions($vol_email){
    $sql = "select * from submissions where vol_id= (select vol_id from volunteers where vol_email='$vol_email')";
    $mysqli = new mysqli(host, user, password, database);
    $result = $mysqli->query($sql);
    $mysqli->close();
    return $result;
}
function getEventDetails($event_date, $vol_email){
    $sql = "select question_text, answer_text_req, answer_text_opt from answers, questions where submission_id =(select submission_id from submissions where event_date ='$event_date' and vol_id =(select vol_id from volunteers where vol_email='$vol_email')) and questions.question_id = answers.question_id group by answers.question_id";
    $mysqli = new mysqli(host, user, password, database);
    $result = $mysqli->query($sql);
    $mysqli->close();
    return $result;
}
function deleteUser($login_name) {
    $sql = "delete from volunteers where vol_email='$login_name'";
    $mysqli = new mysqli(host, user, password, database);
    $mysqli->query($sql);
    $mysqli->close();
}
//end function
function getUser($login_name) {
    $sql = "select * from volunteers where vol_email='$login_name'";
    $mysqli = new mysqli(host, user, password, database);
    $result = $mysqli->query($sql);
//    $mysqli->close();
    return $result;
}
//end function
function updateUser() {
    $login_name = $_POST['loginName'];
    $password = $_POST['password'];
    $firstName = $_POST['firstName'];
    $surName = $_POST['surName'];
    $childMatched = $_POST['child_matched'];
    $login_name_prev = $_POST['user_login_prev'];
    $result = getUser($login_name_prev);
    $row = mysqli_fetch_array($result);
    $imageurl_old = $row['imageurl'];
    $imageurl = saveImage();
    if (strlen($imageurl) == 0) {

        $imageurl = $imageurl_old;
    } else {
        unlink($imageurl_old);
    }
    if($childMatched==true){
        $child_gender=$_POST['child_gender'];
        $child_date_of_birth = $_POST['date_of_birth'];
        $dob="date'".$child_date_of_birth."'";
        $sql = "update volunteers
            set vol_email='$login_name',
                vol_password='$password',
                vol_firstname='$firstName',
                vol_surname='$surName',
                vol_child_matched=".$childMatched.",
                vol_child_gender='$child_gender',
                vol_child_dob=".$dob."
            where vol_email='$login_name_prev'";
    }
    else{
        /*$child_gender = "other";
        $dob = "date'1991-03-12'";*/
        $sql = "update volunteers
            set vol_email='$login_name',
                vol_password='$password',
                vol_firstname='$firstName',
                vol_surname='$surName',
                vol_child_matched=".$childMatched.",
                vol_child_gender=NULL,
                vol_child_dob=NULL
            where vol_email='$login_name_prev'";
    }
    $mysqli = new mysqli(host, user, password, database);
    $mysqli->query($sql) or die("Error: ".$sql."<br>".$mysqli->error);
    $mysqli->close();

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