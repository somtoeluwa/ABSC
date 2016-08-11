<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/11/2016
 * Time: 5:08 AM
 */
session_start();
$role = $_SESSION['sess_userrole'];

if(!isset($_SESSION['sess_username']) && $role!="admin"){
    header('Location: index.php?err=2');
}

include 'functions\functions.php';

// Page title
$page_title ="Delete Asset";


$assetid=$_GET['assetID'];


$sql = "DELETE FROM asset WHERE assetID = '$assetid' ";
$result = $db->query($sql);
if ($result = $db->query($sql)) {
    header('Location:adminviewitems.php?action=deleted');
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
    header('location: adminviewitems.php?action=failed');
}
?>