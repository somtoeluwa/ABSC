<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/7/2016
 * Time: 9:00 PM
 */

$database = 'abscdb';
$host = 'ap-cdbr-azure-east-c.cloudapp.net';
$user = 'b39034f942fc7b';
$pass = 'c9441472';

// try to conncet to database
$dbh = new PDO("mysql:dbname={$database};host={$host};port={3306}", $user, $pass);

if(!$dbh){

    echo "unable to connect to database";
}
?>