<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/8/2016
 * Time: 10:37 PM
 */
session_start();
$role = $_SESSION['sess_userrole'];

if(!isset($_SESSION['sess_username']) && $role!="admin"){
    header('Location: index.php?err=2');
}

include 'functions\functions.php';

// Page title
$page_title ="Delete user";


$userid=$_GET['userid'];

if (($userid == $_SESSION['sess_user_id']) || ($userid == 1) ){

    echo" You cannot delete yourself";
    header('location: viewusers.php?action=failed');
}else {

    $sql = "DELETE FROM users WHERE userid = '$userid' ";
    $result = $db->query($sql);
    if ($result = $db->query($sql)) {
        header('Location:viewusers.php?action=deleted');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($dbs);
        header('location: viewusers.php?action=failed');
    }
}

?>