<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/1/2016
 * Time: 7:51 PM
 */

session_start();

        if($_SERVER['REQUEST_METHOD']==='POST') {

        $id = $_POST['assetID'];
        $name = $_POST['assetName'];
        $quantity = $_POST['quantity'];


        if (!isset($_SESSION['cart_items'])) {
            $_SESSION['cart_items'] = array();

        }

// check if the item is in the array, if it is, do not add

        if (array_key_exists($id, $_SESSION['cart_items'])) {
            // redirect to homepage and get feedback
            header('Location: home.php?action=exists&assetID' . $id . '&assetName=' . $name);
        }

        // else, asset is added to the array
        else {
            $_SESSION['cart_items'][$id] = array( 'assetID' =>$id, 'assetName' => $name, 'quantity' => $quantity);
            // redirect to product list and tell the user it was added to cart
            header('Location: home.php?action=added&assetID' . $id . '&assetName=' . $name);
        }

    }
    else{
        /*impossible is nothing*/
    }
?>