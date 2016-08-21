<?php
include 'functions\functions.php';


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);



// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
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
/*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

// if everything is ok, try to upload file and create new item
}*/ else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

// Test input from forms and store them in variables
        $asset_name = test_input($_POST['assetName']);
        $asset_category = test_input($_POST['assetCategory']);
        $asset_description = test_input($_POST['assetDescription']);
        $total_stock = test_input($_POST['totalstock']);
        $total_owned = test_input($_POST['totalowned']);
        $condition = test_input($_POST['assetCondition']);

// MySQL query to insert values into the database
        $sql = "insert into `asset` (`assetName`,`assetCategory`,`assetDescription`,`total_stock`,`total_owned`,`condition`, `imagepath`)
        values
        ('$asset_name','$asset_category','$asset_description','$total_stock','$total_owned','$condition','$target_file')";


        if($result = mysqli_query($db,$sql)) {
            // When sucessful return to View all assets
            header('location: newItem.php?action=added');
        }else{

            echo "Error:" . $sql . "<br>" . mysqli_error($db);
            header('location: newItem.php?action=failed');
        }



    } else {
        echo "Sorry, something went wrong.";
    }
}





?>

