<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */

include 'assets/functions/functions.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arduino Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body>

<header>
    <img id="logo" src="assets/images/logo.png" alt="Home logo">
    <h3 id="title">Arduino component booking system</h3>

    <nav >
        <ul class="topnav">
            <li>
                <a href="index.html"><i title="Home" class="fa fa-home" style="font-size:36px;color: #ac76af;"></i></a>
            </li>
            <li>
                <form action="#">
                    Search:
                    <input type="search" name="componentsearch">
                    <select title="Select Search Field">
                        <option value="">All categories</option>
                        <option value="Actuators">Actuators</option>
                        <option value="Connectors">Connectors</option>
                        <option value="LCD_Matrix">LCD & Matrix</option>
                        <option value="Passive_Active">Passive & Active</option>
                        <option value="Sensors">Sensors</option>
                    </select>
                    <input type="submit" name="search">
                </form>
            </li>
            <li class="dropdown right" id="profile">
                <a class="dropbtn" href="#">My account</a>
                <div class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="#">Dashboard</a>
                    <a href="#">Sign out</a>
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
                <a href="index.html">Home</a>&nbsp;&gt;&nbsp; All Components
            </div>
        </div>
        <div class="col-4 col-m-4">
        </div>
    </div>
</div>

<!--Main Start -->
    <main>
        <div class="row">
            <div id="sidenavbar" class="col-2 col-m-2 menu">
                <section>
                    <p class="title">
                        <a href="#">Components</a>
                    </p>

                    <div class="content">
                        <?php
                        $sql_catNav = "SELECT * FROM category";
                        $result =  $db->query($sql_catNav);
                        if(mysqli_num_rows($result)>0){
                        $counter = 0;
                        while ($row = $result->fetch_array())
                        {
                        $counter++;
                        ?>
                        <ul class="side-nav">
                            <li><a href="category.php?categoryID=<?php echo $row['categoryID'];?>"><?php echo $row['categoryName'];?></a></li>
                        </ul>
                            <?php
                        }
                        }
                        $result->close();
                        $db->close();
                        ?>
                    </div>
                </section>
            </div>



            <div id="content" class="col-10 col-m-10">
                <?php
                $sql_asset = "SELECT * FROM asset";
                $result2 =  $db->query($sql_asset);
                while ($row = $result2->fetch_array()){

                ?>
                <article class="col-4 col-m-4 itemBox">
                    <div class="row">
                        <div class="col-12 col-m-12 itemPic">
                            <a href="item.php?assetID=<?php echo $row['assetID'];?>">
                                <img src="assets/images/yellow%20led.jpg" alt="Yellow LED" width="229" height="182"/>
                            </a>
                        </div>

                </article>
                <?php
                        }
                        $result2->close();
                        $db->close();
                ?>




            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p> Designed by Somto Eluwa</p>
    </footer>
    <!-- -->



</body>
<!--<nav>-->
<!--    --><?php
//    $sql_query = "SELECT * FROM category";
//    $result =  $db->query($sql_query);
//    if(mysqli_num_rows($result)>0){
//    $counter = 0;
//    while ($row = $result->fetch_array())
//    {
//    $counter++;
//    ?>
<!--<ul>-->
<!--    <li><a href="category.php?categoryID=--><?php //echo $row['categoryID'];?><!--">--><?php //echo $row['categoryName'];?><!--</a></li>-->
<!--</ul>-->
<!--        --><?php
//    }
//    }
//    $result->close();
//    $db->close();
//    ?>
<!---->
<!--</nav>-->
</html>






