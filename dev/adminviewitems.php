<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */
session_start();
if(!isset($_SESSION['ad_email'])){
    header("Location: home.php");}

include 'functions\functions.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arduino Booking System - Admin</title>
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
        <h2 id="login_title" class="w3-xlarge">Arduino component booking system</h2>
    </div>
    <!-- Responsive Top navigation bar -->
    <nav>
        <ul class="w3-navbar w3-theme w3-large w3-border">

            <li><a href="home.php"><i title="home" class="fa fa-home w3-large"></i></a></li>
            <li><a href="#"><i class="fa fa-search w3-large" aria-hidden="true"></i></a></li>
            <li class="w3-dropdown-hover w3-right" id="profile">
                <a class="w3-hover-purple" href="#"><i class="fa fa-user w3-large" aria-hidden="true"></i><i class="fa fa-caret-down"></i></a>
                <div class="w3-dropdown-content w3-white w3-card-2">
                    <a href="#">My Profile</a>
                    <a href="adminviewitems.php">Dashboard</a>
                    <a href="logout.php">Sign out</a>
                </div>
            </li>
            <li class="w3-right">
                <a href="#"><i class="fa fa-shopping-cart w3-large"></i></a>
            </li>
        </ul>
    </nav>
</header>


<!-- Sub header -->
<!--
<div id="pageSubHeader">
    <div class="row">
        <div class="col-8 col-m-8">
            <div id="BreadCrumb">
                <a href="home.php">Home</a>&nbsp;&gt;&nbsp; All Components
            </div>
        </div>
        <div class="col-4 col-m-4">
        </div>
    </div>
</div>-->

<!-- Main Start Item details -->

<main class="w3-padding-row">
    <div  id="AssetOptions" class="w3-sidenav w3-white w3-card-2" style="width:160px;"style="border: 1px dashed black">

        <div class="w3-accordion">
            <a onclick="myAccFunc('demoAcc')" href="#"><h4>Assets <i class="fa fa-caret-down"></i></h4></a>
            <div id="demoAcc" class="w3-accordion-content w3-white w3-card-4">
                <a href="adminviewitems.php" class="w3-padding-16">View All Items</a>
                <a href="newItem.php" class="w3-padding-16" >New Item</a>
            </div>
        </div>
        <div class="w3-accordion">
            <a onclick="myAccFunc('trans')" href="#"><h4>Transactions <i class="fa fa-caret-down"></i></h4></a>
            <div id="trans" class="w3-accordion-content w3-white">
                <a href="admincheckout.php" class="w3-padding-16" >Check Out</a>
                <a href="admincheckin.php" class="w3-padding-16" >Check In</a>
            </div>
        </div>

        <div class="w3-accordion">
            <a onclick="myAccFunc('user')" href="#"><h4>Users<i class="fa fa-caret-down"></i></h4></a>
            <div id="user" class="w3-accordion-content w3-white">
                <a href="#" class="w3-padding-16" >Regiter User</a>
                <a href="#" class="w3-padding-16" >View all Users</a>
            </div>
        </div>

    </div>

    <div class="w3-container" id="assetOptionscontent" style=" margin-left:160px;">
        <h3>Assets Table</h3>
        <div class="w3-responsive">
            <table class="w3-table w3-bordered w3-reverse-striped w3-border w3-hoverable">
                <tr class="w3-light-grey">
                    <th >Asset ID</th>
                    <th>Asset Name</th>
                    <th>Asset Category</th>
                    <th>Asset Description</th>
                    <th>Total in Stock</th>
                    <th>Total Owned</th>
                    <th>Condition</th>
                </tr>

                <?php
                $sql_query = "SELECT * FROM asset";
                $result =  $db->query($sql_query);
                if(mysqli_num_rows($result)>0){
                    $counter = 0;
                    while ($row = $result->fetch_array())
                    {
                        $counter++;
                        ?>
                        <tr>
                            <td><a href="edit_asset.php?assetID=<?php echo $row['assetID'];?>"><?php echo $row['assetID'];?></a></td>
                            <td><?php echo $row['assetName'];?></td>
                            <td><?php echo $row['assetCategory'];?></td>
                            <td><?php echo $row['assetDescription'];?></td>
                            <td><?php echo $row['total_stock'];?></td>
                            <td><?php echo $row['total_owned'];?></td>
                            <td><?php echo $row['condition'];?></td>
                        </tr>
                        <?php
                    }
                }
                $result->close();
                $db->close();
                ?>
            </table>
        </div>
    </div>



</main>

<!-- Footer -->
<!--<footer class="w3-container w3-light-grey">
    <p> Designed by Somto Eluwa</p>
</footer>
-->





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
</body>
</html>