<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/25/2016
 * Time: 1:26 AM
 */

	session_start();
	session_destroy();
	header('Location: index.php');
?>