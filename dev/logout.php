<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/25/2016
 * Time: 1:26 AM
 */

	//THIS PAGE LOGS OUT AN ADMIN
	session_start();
	if(session_destroy()) // Destroying All Sessions
    {
        header("Location: index.php"); // Redirecting To Login Page
    }
?>