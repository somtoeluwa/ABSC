<?php
session_start();
include 'functions\functions.php';


$decision = "approved";

$orderID = $_POST['orderID'];


for ($i = 0; $i < count($_POST['orderselected']); $i++) {
    $quantity = $_POST['quantity'][$i];
    $cid = $_POST['orderselected'][$i];
    $assetPicked = $_POST['assetID'][$i];
    $stock = $_POST['total_stock'][$i];
    $newStock = $stock + $quantity;

    $sql =  "UPDATE `asset`
              SET `total_stock` = '$newStock'
              WHERE `assetID` = '$assetPicked';";
    $result = $db->query($sql);
    if ($result){

        $sql2= "DELETE FROM `checkout`

                WHERE  `c_id` ={$cid};";
        $result2= $db->query($sql2);

        echo "Successful";
        header("Location: vieworders.php?action=approved");
    } else {
        echo "Error" . $sql . '<br>' . mysqli_error($db);
        header('Location: vieworders.php?action=failed');
    }





}