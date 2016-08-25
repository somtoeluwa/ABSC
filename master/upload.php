<?php
include 'functions\functions.php';



$upload_folder = "uploads/";
$uploaded_file = $upload_folder . basename($_FILES["fileToUpload"]["name"]);
$uploadcheck = 1;
$imageFileType = pathinfo($uploaded_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadcheck = 1;
    } else {
        $uploadcheck = 0;
        header('location: newItem.php?action=notImage');
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $uploadcheck = 0;
    header('location: newItem.php?action=large');
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    $uploadcheck = 0;
}
// Check if $uploadcheck is set to 0 by an error
if ($uploadcheck == 0) {
    header('location: newItem.php?action=failed');


    // if everything is ok, try to upload file and create new item
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploaded_file)) {

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
                    ('$asset_name','$asset_category','$asset_description','$total_stock','$total_owned','$condition','$uploaded_file')";


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

