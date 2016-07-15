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
</header>

<main>
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
                        <?php
                        $sql_query = "SELECT * FROM category";
                        $result =  $db->query($sql_query);
                        if(mysqli_num_rows($result)>0){
                        $counter = 0;
                        while ($row = $result->fetch_array())
                        {
                        $counter++;
                        ?>
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


<nav>
    <?php
    $sql_query = "SELECT * FROM category";
    $result =  $db->query($sql_query);
    if(mysqli_num_rows($result)>0){
    $counter = 0;
    while ($row = $result->fetch_array())
    {
    $counter++;
    ?>
<ul>
    <li><a href="category.php?categoryID=<?php echo $row['categoryID'];?>"><?php echo $row['categoryName'];?></a></li>
</ul>
        <?php
    }
    }
    $result->close();
    $db->close();
    ?>

</nav>
</main>

</body>
</html>






