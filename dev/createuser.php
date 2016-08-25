<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */
session_start();
$role = $_SESSION['sess_userrole'];
if(!isset($_SESSION['sess_username']) && $role!="admin"){
    header('Location: index.php?err=2');
}

include 'functions\functions.php';


// Page title
$page_title ="Create User";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($page_title) ? $page_title : "Arduino component booking System"; ?> - Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-purple.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body class="w3-content">
<!-- Header start -->
<header class="w3-light-grey">
    <!-- top panel-->
    <div class="w3-container">
        <img id="logo" src="assets/images/Robert_Gordon_University_logo.svg.png" alt="Home logo" style="width:30%">
        <marquee><h2 id="login_title" class="w3-xlarge"><?php echo isset($page_title) ? $page_title : "Store Home"; ?> </h2></marquee>
    </div>
    <!-- Responsive Top navigation bar -->
    <nav>
        <ul class="w3-navbar w3-theme w3-large w3-border">

            <li><a href="home.php"><i title="home" class="fa fa-home w3-large"></i></a></li>
            <li><a href="#"><i class="fa fa-search w3-large" aria-hidden="true"></i></a></li>
            <li class="w3-dropdown-hover w3-right" id="profile">
                <a class="w3-hover-purple" href="#"><i class="fa fa-user w3-large" aria-hidden="true"></i><i class="fa fa-caret-down"></i></a>
                <div class="w3-dropdown-content w3-white w3-card-2">
                    <a href="account.php?userid=<?php echo $_SESSION['userid'];?>"><?php echo $_SESSION['sess_firstname'];?>'s Account</a>
                    <?php
                    if ($role == "admin" ) {
                        ?>
                        <a href="adminviewitems.php">Dashboard</a>
                        <?php
                    }
                    ?>
                    <a href="logout.php">Sign out</a>
                </div>
            </li>
            <li class="w3-right">
                <a href="cart.php">
                    <?php
                    // count products in cart
                    $cart_count= count($_SESSION['cart_items']);
                    ?><i class="fa fa-shopping-cart w3-large"></i>
                    <span class="w3-badge" id="comparison-count"><?php echo $cart_count; ?></span>
                    item(s)
                </a>
            </li>
        </ul>
    </nav>
</header>


<!-- Main Start Item details -->

<main class="w3-padding-row">
    <div  id="AssetOptions" class="w3-sidenav w3-white w3-card-2"style="width:160px">

        <div class="w3-accordion">
            <a onclick="myAccFunc('assets')" href="#"><h5>Assets <i class="fa fa-caret-down"></i></h5></a>
            <div id="assets" class="w3-accordion-content w3-white w3-card-4">
                <a href="adminviewitems.php" class="w3-padding-16">View All Items</a>
                <a href="newItem.php" class="w3-padding-16" >New Item</a>
            </div>
        </div>
        <div class="w3-accordion">
            <a onclick="myAccFunc('trans')" href="#"><h5>Transactions <i class="fa fa-caret-down"></i></h5></a>
            <div id="trans" class="w3-accordion-content w3-white w3-card-4">
                <a href="vieworders.php" class="w3-padding-16" >View all orders</a>
                <a href="adminapprove.php" class="w3-padding-16" >Approve order</a>
                <a href="admincheckin.php" class="w3-padding-16" >Check In Order</a>
            </div>
        </div>

        <div class="w3-accordion">
            <a onclick="myAccFunc('user')" href="#"><h5>Users<i class="fa fa-caret-down"></i></h5></a>
            <div id="user" class="w3-accordion-content w3-white w3-card-4">
                <a href="createuser.php" class="w3-padding-16" >Create User</a>
                <a href="viewusers.php" class="w3-padding-16" >View all Users</a>

            </div>
        </div>
    </div>

    <div class="w3-container" id="assetOptionscontent" style=" margin-left:160px;">
        <?php

        if($_SERVER['REQUEST_METHOD']==='GET') {
            ?>

            <h5>New User</h5>
            <?php
            $action = isset($_GET['action']) ? $_GET['action'] : "";
            if ($action == 'added') {

                echo "<div class='w3-container w3-section w3-green'>";
                echo "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
                echo "<p>User created!</p>";
                echo "</div>";
            } ?>

            <!-- Form Start-->

            <form class="w3-container" action="createuser.php" method="post">

                <label class="w3-label w3-validate" for="firstname">First Name</label>
                <input class="w3-input w3-theme-border w3-border w3-round-large" type="text" id="firstname"
                       name="firstname" value="" required>
                <br><br>
                <label class="w3-label w3-validate" for="surname">Last Name</label>
                <input class="w3-input w3-theme-border w3-border w3-round-large" type="text" id="surname" name="surname"
                       value="" required>
                <br> <br>
                <label class="w3-label w3-validate" for="email">Email address</label>
                <input class="w3-input w3-theme-border w3-border w3-round-large" type="email" id="email" name="email"
                       value=""  required>
                <br> <br>
                <label class="w3-label w3-validate" for="password">Password</label>
                <input class="w3-input w3-theme-border w3-border w3-round-large" type="password" id="password"
                       name="password" value="" required>
                <br> <br>
                <label class="w3-label w3-validate" for="confirmpassword">Confirm Password</label>
                <input class="w3-input w3-theme-border w3-border w3-round-large" type="password" id="confirmpassword"
                       name="confirmpassword" value="" required>
                <br> <br>
                <label class="w3-label w3-validate" for="role">Role</label>
                <select class="w3-select w3-theme-border" id="role" name="role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="admin">Administrator</option>
                    <option value="user">User</option>
                </select>
                <br><br>
                <p>
                    <button type="submit" class="w3-btn w3-theme confirmation" value="create" name="submit">Create User
                    </button>
                </p>
            </form>
            <?php
        }
        else if ($_SERVER['REQUEST_METHOD']==='POST'){


            $firstname = test_input($_POST['firstname']);
            $surname = test_input($_POST['surname']);
            $email = test_input($_POST['email']);
            $password = test_input($_POST['password']);
            $role = test_input($_POST['role']);



            $sql = "insert into users (email,password,firstname,surname,role)
            values('$email','$password','$firstname','$surname','$role')";

            if($result = mysqli_query($db,$sql)) {

                // When sucessful return to View all assets
                header('location: createuser.php?action=added');
            }else{

                echo "Error:" . $sql . "<br>" . mysqli_error($db);
                header('location: createuser.php?action=failed');

            }

        }
        else{
            /*bla bla bla*/
            header('location: index.php');
        }

        ?>

    </div>
</main>



<script type="text/javascript">
    window.onload = function () {
        document.getElementById("password").onchange = validatePassword;
        document.getElementById("confirmpassword").onchange = validatePassword;
        /* document.getElementById('email').setCustomValidity("Please use an @rgu.ac.uk email address.");*/

    }

    function validatePassword() {
        var pass2 = document.getElementById("confirmpassword").value;
        var pass1 = document.getElementById("password").value;
        if (pass1 != pass2)
            document.getElementById("confirmpassword").setCustomValidity("Passwords Don't Match");
        else
            document.getElementById("confirmpassword").setCustomValidity('');
    }

</script>
<script>
    function myAccFunc(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
            x.previousElementSibling.className += " w3-purple";
        } else {
            x.className = x.className.replace(" w3-show", "");
            x.previousElementSibling.className =
                x.previousElementSibling.className.replace(" w3-purple", "");
        }
    }
</script>

<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Create this user? ')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>

</body>
</html>