<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/1/2016
 * Time: 7:51 PM
 */

session_start();


if($_SERVER['REQUEST_METHOD']==='GET') {

// get the component  id
    $id = isset($_GET['assetID']) ? $_GET['assetID'] : "";
    $name = isset($_GET['assetName']) ? $_GET['assetName'] : "";
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";


    /*
     * check if the 'cart' session array was created
     * if it is NOT, create the 'cart' session array
     */
    if (!isset($_SESSION['cart_items'])) {
        $_SESSION['cart_items'] = array();

    }

// check if the item is in the array, if it is, do not add
    if (array_key_exists($id, $_SESSION['cart_items'])) {
        // redirect to product list and tell the user it was added to cart
        header('Location: home.php?action=exists&id' . $id . '&name=' . $name);
    } // else, add the item to the array
    else {
        $_SESSION['cart_items'][$id] = array('name'=>$name, 'quantity' =>$quantity) ;


        // redirect to product list and tell the user it was added to cart
        header('Location: home.php?action=added&id' . $id . '&name=' . $name);
    }

/*    print_r($_SESSION['cart_items']);*/

}

    else if($_SERVER['REQUEST_METHOD']==='POST') {

        $id = $_POST['assetID'];
        $name = $_POST['assetName'];
        $quantity = $_POST['quantity'];


        if (!isset($_SESSION['cart_items'])) {
            $_SESSION['cart_items'] = array();

        }

// check if the item is in the array, if it is, do not add
        if (array_key_exists($id, $_SESSION['cart_items'])) {
            // redirect to product list and tell the user it was added to cart
            header('Location: home.php?action=exists&id' . $id . '&name=' . $name);
        } // else, add the item to the array
        else {
            $_SESSION['cart_items'][$id] = array('name' => $name, 'quantity' => $quantity);


            // redirect to product list and tell the user it was added to cart
            header('Location: home.php?action=added&id' . $id . '&name=' . $name);

            /*print_r($_SESSION['cart_items']);*/


        }
    }
    else{
        /*     $id = "";
                  if(isset($_GET['assetID'])){
                      $id = $_GET['assetID'];

                  } else if(isset($_POST['assetID'])){
                      $id = $_POST['assetID'];
                  }

          // Get Asset name
                  $name = "";
                  if(isset($_GET['assetName'])){
                      $name = $_GET['assetName'];

                  } else if(isset($_POST['assetName'])){
                      $name = $_POST['assetName'];
                  }*/


    }
?>