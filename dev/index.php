<?php

//GET when accessed through URL
if($_SERVER['REQUEST_METHOD']==='GET'){
    session_start(); //check if session is set
    if(isset($_SESSION["ad_email"]))
    {
        //send user to adminhome.php
        header("Location: home.php");
    }
    /*else{
        show_index_page();
    }*/
}
else if($_SERVER['REQUEST_METHOD']==='POST'){	//Post is used when the form is submitted
    //read input details from index.php
    $email=$_POST['u'];
    $password=$_POST['p'];
    $username = "";
    if(user_registered($email,$password)){	//See function below
        session_start();	//start the session
        $_SESSION["ad_email"]=$email;//assign the admin email address to the session

        header("Location: home.php");	//send admin to adminhome.php
    }
    else{
        //show_index_page();	//This isn't necessary anymore
        echo "<script>alert('Invalid administrator details');</script>";
    }
}
//FUNCTIONS:
function user_registered($email,$password) {
    //test to discover if the user is already in the DB
    //to do that, we can find out if the email address already exists in any row
    include("functions/functions.php");
    if($db->connect_errno){		//check if there was a connection error and respond accordingly
        die('Connection failed:'.connect_error);
    }
    else{
        //select all values from database using the entered values as filter
        $query="SELECT ad_email, ad_password, ad_firstname
					FROM administrators
					WHERE ad_email = ? AND ad_password = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss",$_POST['u'],$_POST['p']);
        $stmt->execute() or die("Error: ".$query."<br>".$db->error);
        if(mysqli_stmt_fetch($stmt)){	//if the sql query returns a value
            return TRUE; 	//indicate that a value was returned, and user exists in database

        }
        else{
            return false; //indicate a value wasn't returned, and user doesn't exist in database
        }
        $db->close(); // Closing Connection
    }
}
?>


<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title> Admin </title>
    <link rel="stylesheet" href="css/loginpage.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="css/w3.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body class="w3-container">
<header class="w3-container">
    <h1 class="login_title"></h1>
</header>
<main>
    <!-- Login form -->
    <div id=loginform class="w3-modal-content w3-card-8 " style="max-width:450px; margin-top:100px; ">
        <div class="w3-center">
            <br>
            <img src="assets/images/Robert_Gordon_University_logo.svg.png" alt="Avatar" style="width:60%" class=" w3-margin-top">
        </div>

        <form name="userlogin" method="post" action="index.php" class="w3-container">
            <div class="w3-section">
                <label><b>E-mail</b></label>
                <input type="email" name="u" placeholder="Enter Email..."  class=" w3-input w3-border w3-round-large" required/>

                <label><b>Password</b></label>
                <input type="password" name="p" placeholder="Enter Password..."  class=" w3-input w3-border w3-round-large" required/>

                <button type="submit" name="submit" class="w3-btn-block w3-section w3-purple w3-round-xxlarge" value="login"> Log in </button>
                <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me
            </div>
        </form>

        <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
            <span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>
        </div>

    </div>
</main>

<footer class= "w3-container w3-padding-4 w3-margin"  style="text-align: center; font-size:smaller; ">
    <h11> Arduino Component Booking System. Copyright 2016</h11>
</footer>

</body>
</html>