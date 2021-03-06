<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */
session_start();
if(!isset($_SESSION['ad_email'])){
    header("Location: index.php");
}

include 'functions\functions.php';
$category = $_GET['categoryID'];

//THIS PAGE IS DESTINATION FOR ADMIN WHEN LOGGED IN AND TRYING TO ACCESS INDEX.PHP, AND WHEN CLICKING LINKS LEADING HERE
//If no session exists, admin is sent to adminviewitems.php

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arduino Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body>
<!-- Header start -->
<header>
    <img id="logo" src="images/logo.png" alt="Home logo">
    <h3 id="title">Arduino component booking system</h3>

    <nav >
        <ul class="topnav">
            <li>
                <a href="home.php"><i title="Home" class="fa fa-home" style="font-size:36px;color: #ac76af;"></i></a>
            </li>
            <li>
                <form action="#" class="navSearch">
                    <i class="fa fa-search" aria-hidden="true" style="color:#ac76af"></i>
                    <input type="search" name="componentsearch"  placeholder="Search here ...">

                    <select title="searchCategories"">
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
                    <a href="adminviewitems.php">Dashboard</a>
                    <a href="logout.php">Sign out</a>
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
                <a href="home.php">Home</a>&nbsp;&gt;&nbsp; All Components
            </div>
        </div>
        <div class="col-4 col-m-4">
        </div>
    </div>
</div>

<!-- Main Start Item details -->
<main>
    <div class="row">
        <div  id="AssetOptions" class="col-2" style="border: 1px dashed black">
            <ul class="menu">
                <li>Assets</li>
                <ul>
                    <li><a href="adminviewitems.php" id="viewAllitems">View All</a></li>
                    <li><a href="newItem.php" id="newItem">New Item</a></li>
                    <li><a href="newCategory.php" id="newItemCategory">New item category</a></li>
                    <li><a href="viewCategories.php">view item categories</a></li>
                    <li><a href="addQuantity.php">Add item quantity</a></li>
                </ul>
                <li>Transactions</li>
                <ul>
                    <li><a href="#" id="checkIn">Check In</a></li>
                    <li><a href="#" id="checkOut">Check Out</a></li>
                </ul>
                <li>Users</li>
                <ul>
                    <li><a href="#" id="checkIn">Regiter User</a></li>
                    <li><a href="#" id="checkOut">View all Users</a></li>
                </ul>
            </ul>
        </div>

        <div class="col-10" id="assetOptionscontent" style="border: 1px dashed black">
            <h3>New Asset</h3>
                <form class="newAsset">
                    <!--<label for="assetID">Asset ID</label>
                    <input type="number" id="assetID" value="" required >
                    <br><br>-->
                    <label for="assetName">Asset Name</label>
                    <input type="text" id="assetName" value="" required >
                    <br><br>
                    <label for="assetType">Asset Type</label>
                    <input type="text" id="assetType" value="" required >
                    <br><br>
                    <label for="assetDescription">Asset Description</label>
                    <textarea required id="assetDescription" cols="30" rows="3" value=""></textarea>
                    <br> <br>
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" value="" maxlength="10" required >
                    <br><br>
                    <label for="assetCategory">Item Category</label>
                    <select id="assetCategory">
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
                    </select>
                    <br> <br>
                    <label for="serialnumber">Serial Number</label>
                    <input type="text" id="serialnumber"  value="">
                    <br> <br>
                    <label for="condtion">Condition</label>
                        <select  id="assetcondition">
                            <option value="good">Good working condition</option>
                            <option value="bad">Not working</option>
                        </select>
                    <br> <br>
                    <input type="submit" value="submit">
                </form>

                <form action="upload.php" method="post" enctype="multipart/form-data">
                    Select image to upload:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload Image" name="submitImage">
                </form>

        </div>
    </div>


</main>

<footer>

</footer>

</body>
</html>