<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/8/2016
 * Time: 8:31 PM
 */
require 'functions/db-connect.php';

session_start();

$email = "";
$password = "";

if(isset($_POST['email'])){
    $email = $_POST['email'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];

}

echo $email ." : ".$password;

$q = 'SELECT * FROM users WHERE email=:email AND password=:password';

$query = $dbh->prepare($q);

$query->execute(array(':email' => $email, ':password' => $password));


if($query->rowCount() == 0){
    header('Location: index.php?err=1');
}else{

    $row = $query->fetch(PDO::FETCH_ASSOC);

    session_regenerate_id();
    $_SESSION['sess_user_id'] = $row['id'];
    $_SESSION['sess_email'] = $row['email'];
    $_SESSION['sess_firstname'] = $row['firstname'];
    $_SESSION['sess_surname'] = $row['surname'];
    $_SESSION['sess_userrole'] = $row['role'];

    echo $_SESSION['sess_userrole'];
    session_write_close();

    if( $_SESSION['sess_userrole'] == "admin"){
        header('Location: adminviewitems.php');
    }else{
        header('Location: home.php');
    }


}


?>