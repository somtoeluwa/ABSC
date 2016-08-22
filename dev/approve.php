<?php
session_start();
include 'functions\functions.php';


$decision = "approved";

$orderID = $_POST['orderID'];


$cids = "";

    foreach($_POST['orderselected'] as $cid=>$value){
        $cids = $cids . $cid . ",";
        
        echo $cids;
    }

    // remove the last comma
    /*$ids = rtrim($ids, ',');*/


/*for ($i = 0; $i < count($_POST['orderselected']); $i++) {*/
    /*$quantity = $_POST['quantity'][$i];*/
/*    $cid = $_POST['orderselected'][$i];*/
    /*$assetPicked = $_POST['assetID'][$i];
    $stock = $_POST['total_stock'][$i];
    $newStock = $stock - $quantity;*/


    /*$sql = "SELECT checkout.*,asset.total_stock
            FROM `checkout`,`asset`
            WHERE `c_id` = $cid;";
    $result = $db->query($sql);
    if ($result) {
        while ($row = $result->fetch_array()) {

            $assetPicked = $row['assetID'];
            echo $assetPicked;
            echo "<br><br>";

            $quantity = $row['quantity'];
            echo $quantity;
            echo "<br><br>";

            $stock  = $row['total_stock'];
            echo $stock;
            echo "<br><br>";
        }
    }
    else {
            echo "Error" . $sql . '<br>' . mysqli_error($db);}*/

   /*  =  "UPDATE `asset`
              SET `total_stock` = '$newStock'
              WHERE `assetID` = $assetPicked;";
    $result = $db->query($sql);
    if ($result){

        $sql2= "Update `checkout`
                SET `status` = '$decision'
                WHERE  `c_id` ={$cid};";
        $result2= $db->query($sql2);

        echo "Successful";
        header("Location: vieworders.php?action=approved");
    } else {
        echo "Error" . $sql . '<br>' . mysqli_error($db);
        header('Location: vieworders.php?action=failed');
    }*/
/*}*/