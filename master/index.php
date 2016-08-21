<?php
session_start();

?>
<!DOCTYPE html>
<html  lang="en">
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
    <?php

    $errors = array(
        1=>"Invalid user name or password, Try again",
        2=>"Please login to access this area"
    );

    $error_id = isset($_GET['err']) ? (int)$_GET['err'] : 0;

    if ($error_id == 1) {
        echo "<div class='w3-container w3-section w3-red'>";
        echo "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
        echo "<p>".$errors[$error_id]."</p>";
        echo "</div>";

    }elseif ($error_id == 2) {
        echo "<div class='w3-container w3-section w3-red'>";
        echo "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
        echo "<p>".$errors[$error_id]."</p>";
        echo "</div>";

    }
    ?>

    <div id=loginform class="w3-modal-content w3-card-8 " style="max-width:450px; margin-top:100px; ">
        <div class="w3-center">
            <br>
            <img src="assets/images/Robert_Gordon_University_logo.svg.png" alt="Avatar" style="width:60%" class=" w3-margin-top">
        </div>
        <form name="userlogin" method="post" action="authenticate.php" class="w3-container">
            <div class="w3-section">
                <label><b>E-mail</b></label>
                <input type="email" name="email" placeholder="Enter Email..."  class=" w3-input w3-border w3-round-large" required/>

                <label><b>Password</b></label>
                <input type="password" name="password" placeholder="Enter Password..."  class=" w3-input w3-border w3-round-large" required/>

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