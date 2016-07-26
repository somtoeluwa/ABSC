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

include '\Project\ABSC\dev\functions\functions.php';
$category = $_GET['categoryID'];

//THIS PAGE IS DESTINATION FOR ADMIN WHEN LOGGED IN AND TRYING TO ACCESS INDEX.PHP, AND WHEN CLICKING LINKS LEADING HERE
//If no session exists, admin is sent to adminviewitems.php

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arduino Booking System - Asset Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/dev/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body  onload="openTab(event, 'Assets')">
<!-- Header start -->
<header>
    <img id="logo" src="/dev/images/logo.png" alt="Home logo">
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
            <li><a href="/dev/transactions/index.php" class="tablinks" onclick="openTab(event, 'Transactions')">Transactions</a></li>
            <li><a href="#" class="tablinks" onclick="openTab(event, 'Users')">Users</a></li>
        </ul>

        <div id="Assets" class="tabcontent">
            <div class="row">
                <div  id="AssetOptions" class="col-2" style="border: 1px dashed black">
                    <ul class="side-nav">
                        <li><a href="/dev/assetmanagement/index.php" id="viewAllitems">View All</a></li>
                        <li><a href="newAsset.php" id="newItem">New Item</a></li>
                        <li><a href="#" id="newItemCategory">New item category</a></li>
                        <li><a href="#">Add item quantity</a></li>
                        <li><a href="#">view item categories</a></li>
                    </ul>
                </div>

                <div class="col-10" id="assetOptionscontent" style="border: 1px dashed black">
                    <div style="overflow-x:auto;">
                        <table class="itemTable" style="margin-left: auto; margin-right: auto;">
                            <tr>
                                <th>Asset ID</th>
                                <th>Asset Name</th>
                                <th>Asset Type</th>
                                <th>Asset Description</th>
                                <th>Quantity</th>
                                <th>Category Name</th>
                                <th>Checked out</th>
                                <th>Serial Number</th>
                                <th>Condition</th>

                                <?php
                            $sql_query = "SELECT * FROM asset,category where asset.categoryID = category.categoryID";
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
                                <td><?php echo $row['assetType'];?></td>
                                <td><?php echo $row['assetDescription'];?></td>
                                <td><?php echo $row['quantity'];?></td>
                                <td><?php echo $row['categoryName'];?></td>
                                <td><?php echo $row['checked_out'];?></td>
                                <td><?php echo $row['serial_number'];?></td>
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
        </div>

        <div id="Transactions" class="tabcontent">
            <div class="row">
                <div  id="TransactionOptions" class="col-2" style="border: 1px dashed black">
                    <ul class="side-nav">
                        <li><a href="#" id="checkIn">Check In</a></li>
                        <li><a href="#" id="checkOut">Check Out</a></li>
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

</div>
</main>

<footer>

</footer>

</body>
</html>
