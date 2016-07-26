<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */
session_start();
if(!isset($_SESSION['ad_email'])){
    header("Location: home.php");
}

include 'functiontra.php';
$category = $_GET['categoryID'];

//THIS PAGE IS DESTINATION FOR ADMIN WHEN LOGGED IN AND TRYING TO ACCESS INDEX.PHP, AND WHEN CLICKING LINKS LEADING HERE
//If no session exists, admin is sent to adminviewitems.php

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arduino Booking System - Transactions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/dev/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body  onload="openTab(event, 'Transactions')">
<!-- Header start -->
<header>
    <img id="logo" src="/dev/assets/images/logo.png" alt="Home logo">
    <h3 id="title">Arduino component booking system</h3>

    <nav >
        <ul class="topnav">
            <li>
                <a href="/dev/home.php"><i title="Home" class="fa fa-home" style="font-size:36px;color: #ac76af;"></i></a>
            </li>
            <li>
                <form action="#" class="navSearch">
                    <i class="fa fa-search" aria-hidden="true" style="color:#ac76af"></i>
                    <input type="search" name="componentsearch"  placeholder="Search here ...">

                    <select title="searchCategories">
                    <?php
                    $sql_search = "SELECT categoryID,categoryName FROM category";
                    $result_search = $db->query($sql_search);
                    if(mysqli_num_rows($result_search)>0){
                    $counter=0;
                    while($row_search = $result_search->fetch_array()){
                    ?>
                    <option value="<?php echo $row_search['categoryID'];?>"><?php echo $row_search['categoryName'];?></option>
                    <?
                        }
                    }
                    $result_search->close()
                    ?>
                    <input type="submit" name="search" id="search">
                </form>
            </li>
            <li class="dropdown right" id="profile">
                <a class="dropbtn" href="#"><i class="fa fa-user" aria-hidden="true" style="font-size:36px;color:#ac76af"></i></a>
                <div class="dropdown-content">
                    <a href="#"><?php echo $_SESSION['ad_firstname']; ?>'s Profile</a>
                    <a href="/dev/assetmanagement/index.php">Dashboard</a>
                    <a href="//logout.php">Sign out</a>
                </div>
            </li>
            <li class="right">
                <a href="#"><i class="fa fa-shopping-cart" style="font-size:36px;color:#ac76af"></i></a>
            </li>

        </ul>
    </nav>
</header>


<!-- Sub header -->

<div id="pageSubHeader">
    <div class="row">
        <div class="col-8 col-m-8">
            <div id="BreadCrumb">
                <a href="//home.php">Home</a>&nbsp;&gt;&nbsp; All Components
            </div>
        </div>
        <div class="col-4 col-m-4">
        </div>
    </div>
</div>

<!-- Main Start Item details -->
<main>
    <div id="dashboard" >
        <ul class="tab">
            <li><a href="/dev/assetmanagement/index.php" class="tablinks" onclick="openTab(event, 'Assets')">Assets</a></li>
            <li><a href="index.php" class="tablinks" onclick="openTab(event, 'Transactions')">Transactions</a></li>
            <li><a href="#" class="tablinks" onclick="openTab(event, 'Users')">Users</a></li>
        </ul>

        <div id="Assets" class="tabcontent">
            <div class="row">
                <div  id="AssetOptions" class="col-2" style="border: 1px dashed black">
                    <ul class="side-nav">
                        <li><a href="/dev/assetmanagement/index.php" id="viewAllitems">View All</a></li>
                        <li><a href="/dev/assetmanagement/newAsset.php" id="newItem">New Item</a></li>
                        <li><a href="#" id="newItemCategory">New item category</a></li>
                        <li><a href="#">Add item quantity</a></li>
                        <li><a href="#">view item categories</a></li>
                    </ul>
                </div>
                <div class="col-10" id="assetOptionscontent" style="border: 1px dashed black">
                    <h3>Item Information</h3>
                    <form class="inputBug">
                        <label for="itemID">item Name</label>
                        <input type="text" id="itemID" value="" required >
                        <br><br>
                        <label for="itemName">item Name</label>
                        <input type="text" id="itemName" value="" required >
                        <br><br>
                        <label for="itemType">item Type</label>
                        <input type="text" id="itemType" value="" required >
                        <br><br>
                        <label for="itemCategory">item Category</label>
                        <select id="itemCategory">
                            <option value="Actuators">Actuators</option>
                            <option value="Connectors">Connectors</option>
                            <option value="LCD_Matrix">LCD & Matrix</option>
                            <option value="Passive_Active">Passive & Active</option>
                            <option value="Sensors">Sensors</option>
                        </select>
                        <br> <br>
                        <label for="itemDescription">Item Description</label>
                        <textarea required id="itemDescription" cols="30" rows="3" value=""></textarea>
                        <br> <br>
                        <input type="submit" value="submit">
                    </form>

                    <form action="//upload.php" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submitImage">
                    </form>

                </div>
            </div>
        </div>
        <div id="Transactions" class="tabcontent">
            <div class="row">
                <div  id="TransactionOptions" class="col-2" style="border: 1px dashed black">
                    <ul class="side-nav">
                        <li><a href="#" id="checkIn">Check In</a></li>
                        <li><a href="#" id="checkOut">Check Out</a></li>
                        <li><a href="#">New item category</a></li>
                        <li><a href="#">Add item quantity</a></li>
                        <li><a href="#">view item categories</a></li>
                    </ul>
                </div>

                <div class="col-10" id="TransactionOptionsContent" style="border: 1px dashed black">
                    <h3>Transaction Information</h3>


                </div>
            </div>


        </div>

        <div id="Users" class="tabcontent">
            <h3>Users Infomation</h3>

        </div>

    </div>


    <script>
        function openTab(evt, tabName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the link that opened the tab
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>


</main>

<footer>

</footer>

</body>
</html>