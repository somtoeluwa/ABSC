<?php
/**
 * Created by PhpStorm.
 * User: 1412632
 * Date: 26/07/2016
 * Time: 18:13
 */


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$asset_Name = test_input($_POST['assetName']);
$asset_Type = test_input($_POST['assetType']);
$asset_Description = test_input($_POST['assetDescription']);
$quantity = test_input($_POST['quantity']);
$cat_ID = test_input($_POST['assetCategory']);
$serialnumber = test_input($_POST['serialnumber']);
$condition = test_input($_POST['assetcondition']);

/*echo "{$asset_Name}";
echo "{$asset_Type}";
echo "{$asset_Description}";
echo "{$quantity}";
echo "{$cat_ID}";
echo "{$serialnumber}";
echo "{$condition}";*/



$asset_Name = $_POST['assetName'];
$asset_Type =$_POST['assetType'];
$asset_Description =$_POST['assetDescription'];
$quantity = $_POST['quantity'];
$cat_ID = $_POST['assetCategory'];
$serialnumber =$_POST['serialnumber'];
$condition = $_POST['assetcondition'];


$sql = "insert into asset (assetName,assetType,assetDescription,quantity,categoryID,serialNumber,condition)
                values('$asset_Name','$asset_Type','$asset_Description', $quantity ,$cat_ID ,'$serialnumber', '$condition')";

if($result = mysqli_query($db,$sql)){
    // When sucessful return to blog.php(Show all blog entries)
    header('location: adminviewitems.php');

}else {
    echo "Error:" . $sql . "<br>" . mysqli_error($db);
}