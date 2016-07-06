<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */

include 'dbConnect.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arduino Booking System</title>

</head>
<body>

<h2>Arduino Booking System</h2>

<? if($db){
    echo "Successful connection";
} else{
    echo "Failed to connect to the database";
}
?>

</body>
</html>






