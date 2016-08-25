<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/1/2016
 * Time: 8:34 PM
 */


session_start();
include 'functions/functions.php';

        // get the product id
        $id = isset($_GET['assetID']) ? $_GET['assetID'] : "";
        $name = isset($_GET['assetName']) ? $_GET['assetName'] : "";
        // remove the item from the array
        unset($_SESSION['cart_items'][$id]);
        // redirect to product list and tell the user it was added to cart
        header('Location: cart.php?action=removed&assetID=' . $id . '&assetName=' . $name);

?>


//additional params
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";
$action = isset($_GET['action']) ? $_GET['action'] : "";
$product_id = isset($_GET['assetID']) ? $_GET['assetID'] : "1";
$name = isset($_GET['assetName']) ? $_GET['assetName'] : "";
$category= isset($_GET['assetCategory']) ? $_GET['assetCategory'] : "";

