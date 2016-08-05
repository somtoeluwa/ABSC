<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/2/2016
 * Time: 11:55 PM
 */

session_start();
include 'functions/functions.php';

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    echo "<h2>Receipt</h2>";
    echo "<p>Thank you for using the Arduino booking System.</p>";
    echo "<p>Your order has been placed. Your order number is : 12345AB </p>";
    echo "<p>Present this number to the Module co-ordinator to recieve your items.</p>";
    echo "<h3>Order Summary</h3>";




    foreach($_SESSION['cart_items'] as $id=>$value){
        $id = $_POST['assetID'];
        $name = $_POST['assetName'];
        $quantity = $_POST['cart_quantity'];



        $_SESSION['cart_items'][$id] = array('name' => $name, 'quantity' => $quantity);


            echo "Key=" . $id . ", name=" . $name ."Quantity =" . $quantity;
            echo "<br>";

        $sql = "INSERT INTO `checkout`(`c_assetID`,`c_assetName`,`quantity`)
              VALUES ('$id','$name','$quantity')";

        if($result = mysqli_query($db,$sql)) {
            // When sucessful return to View all assets

            unset($_SESSION['cart_items']);
        }else{

            echo "Error:" . $sql . "<br>" . mysqli_error($db);
    }





    }



}
    /*echo " <tr>";
    echo "<td> {$_POST['assetID'] }</td>";
    echo "<td>{$_POST['assetCategory']}</td>";
    echo "<td>{$_POST['quantity'] }</td>";
    echo "";*/
