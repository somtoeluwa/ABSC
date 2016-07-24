<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */

include 'assets/functions/functions.php' ;
$category = $_GET['categoryID'];

?>

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
                <form action="#" class="navSearch">
                    <i class="fa fa-search" aria-hidden="true" style="color:#ac76af"></i>
                    <input type="search" name="componentsearch"  placeholder="Search here ...">

                    <?php
                    $sql=("SELECT categoryID,categoryName FROM category");
                    if(mysqli_num_rows($result)>0){{
                    $select= '<select name="searchCategories">';
                        while($row = $result->fetch_array()){
                        $select.='<option value="'.$row['categoryID'].'">'.$row['categoryName'].'</option>';
                        }
                        }
                        $select.='</select>';
                    echo $select;

                    ?>

                    <!--<select title="searchCategories"">
                        <option value="">All categories</option>
                        <option value="Actuators">Actuators</option>
                        <option value="Connectors">Connectors</option>
                        <option value="LCD_Matrix">LCD & Matrix</option>
                        <option value="Passive_Active">Passive & Active</option>
                        <option value="Sensors">Sensors</option>
                    </select>-->
                    <input type="submit" name="search" id="search">
                </form>
            </li>
            <li class="dropdown right" id="profile">
                <a class="dropbtn" href="#"><i class="fa fa-user" aria-hidden="true" style="font-size:36px;color:#ac76af"></i></a>
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
                <a href="test.php">Home</a>&nbsp;&gt;&nbsp; All Components
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
                            //$category = $_GET['categoryID'];
                        $sql_catNav = "SELECT * FROM category";
                        $result =  $db->query($sql_catNav);

                        if(mysqli_num_rows($result)>0){
                        $counter = 0;
                        while ($row = $result->fetch_array())
                        {
                        $counter++;
                        ?>
                        <ul class="side-nav">
                            <li><a href="test.php?categoryID=<?php echo $row['categoryID'];?>"><?php echo "{$row['categoryName']}";?></a></li>
                        </ul>
                            <?php
                        }
                        }
                        $result->close();

                        ?>
                    </div>
                </section>
            </div>



            <div id="content" class="col-10 col-m-10">
                <?php
                if ($_GET['categoryID']){
                    $sql_asset = "SELECT * FROM asset WHERE categoryID = '$category' ";
                }
                else{
                    $sql_asset = "SELECT * FROM asset";
                }

                $result2 =  $db->query($sql_asset);
                while ($row = $result2->fetch_array()){

                ?>

                    <article class="col-4 col-m-4 itemBox">
                        <div class="row">
                            <div class="col-12 col-m-12 itemPic">
                                <a href="item.php?assetID=<?php echo $row['assetID'];?>">
                                    <img src="<?php echo $row['image'];?>" alt="Yellow LED" width="229" height="182"/>
                                </a>
                            </div>
                            <div class="col-12 col-m-12">
                                <h4 class="productTitle"><a href="item.php?assetID=<?php echo $row['assetID'];?>"><?php echo $row['assetName'];?></a></h4>
                                <div class="listingDescription"><?php echo "{$row['assetDescription']}";?></div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-m-6">
                                    <div class="priceinlist"><?php echo $row['quantity'];?> In Stock </div>
                                </div>
                                <div class="col-6 col-m-6">
                                    <form class="funkycart" name="cart_quantity" action="#" method="#" enctype="multipart/form-data">
                                        <input type="hidden" name="assetID" value="<?php echo $row['assetID'];?>">
                                        <input type="hidden" name="cart_quantity" value="1">
                                        <input type="submit" value="Add to cart" class="button tiny-button expand addcart-button">
                                    </form>
                                </div>
                            </div>
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
</html>
