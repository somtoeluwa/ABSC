<?php
session_start();
include 'functions\functions.php';


$decision = "approved";

$orderID = $_POST['orderID'];

for ($i = 0; $i < count($_POST['orderselected']); $i++) {

    $cid = $_POST['orderselected'][$i];

    $sql = "SELECT checkout.*,asset.total_stock
            FROM `checkout`,`asset`
            WHERE `c_id` = $cid
            AND checkout.assetID = asset.assetID;";
    $result = $db->query($sql);

    if ($result) {
        while ($row = $result->fetch_array()) {
            $assetPicked = $row['assetID'];
            $quantity = $row['quantity'];
            $stock = $row['total_stock'];
            $newStock = $stock - $quantity;

            $sql2 = "UPDATE `asset`
                      SET `total_stock` = '$newStock'
                      WHERE `assetID` = $assetPicked;";
                    $result2 = $db->query($sql2);

            if ($result2){
                    $sql3= "Update `checkout`
                    SET `status` = '$decision'
                    WHERE  `c_id` ={$cid};";
                    $result3= $db->query($sql3);

                    echo "Successful";
                    header("Location: vieworders.php?action=approved");
            }
            else {
                    echo "Error" . $sql . '<br>' . mysqli_error($db);
                    header('Location: vieworders.php?action=failed');
            }
        }
    }else {
        echo "Error" . $sql . '<br>' . mysqli_error($db);
        header('Location: vieworders.php?action=failed');
    }
}
