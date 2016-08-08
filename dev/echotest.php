<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/8/2016
 * Time: 11:52 PM
 */
session_start();
$role = $_SESSION['sess_userrole'];

if(!isset($_SESSION['sess_email']) && ($role!="user"|| $role!="admin")){
    header('Location: index.php?err=2');
}

echo $_SESSION['userid'] ;
echo $_SESSION['sess_email'] ;
echo $_SESSION['sess_firstname'];
echo $_SESSION['sess_surname'];
echo $_SESSION['sess_userrole'];

?>