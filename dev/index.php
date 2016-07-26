<?php
//GET when accessed through URL
if($_SERVER['REQUEST_METHOD']==='GET'){
    //check if session is set
    session_start();
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
    //read input details from adminviewitems.php
    $email=$_POST['u'];
    $password=$_POST['p'];
    $username = "";
    if(user_registered($email,$password)){	//See function below
        session_start();	//start the session
        $_SESSION["ad_email"]=$email;
        $_SESSION['ad_firstname'] = $username;//assign the admin email address to the session

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
<!--else{
        echo "Impossible is nothing";
    }
function show_index_page() {
//display the HTML form to register
//or sign a user in
$htmlpage = <<<HTMLPAGE-->

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title> Admin </title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<header>
    <img id="logo" src="images/logo.png" alt="Home logo">
    <h3 id="title">Arduino component booking system</h3>
</header>

<body>
<h2 style="color: ghostwhite" align="center"> Please Login </h2>
<div class="login-page">
    <div class="form">
        <form name="userlogin" method="post" action="index.php" >
            <input type="text" name="u" placeholder="Username" required/>
            <br><br>
            <input type="password" name="p" placeholder="Password" required/>
            <br>
            <br>
            <div class="submit">
                <button type="submit" name="submit" value="login" ><Strong> Login </Strong> </button>
                <br>
                <br>
            </div>
        </form>
    </div>
</div>