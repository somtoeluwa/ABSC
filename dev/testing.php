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

echo "{$asset_Name}";
echo "{$asset_Type}";
echo "{$asset_Description}";
echo "{$quantity}";
echo "{$cat_ID}";
echo "{$serialnumber}";
echo "{$condition}";