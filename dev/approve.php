<?php
include 'functions\functions.php';

// Simple function to avoid SQL Injection.
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

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
        }

        else{

            echo "Error:" . $sql . "<br>" . mysqli_error($db);

        }








?>

