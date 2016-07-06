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
</head>


<body>

<header>
    <h2>Arduino Booking System</h2>
    <p><? if($db){
        echo "Successful connection";
    } else{
        echo "Failed to connect to the database";
    }
    ?>
    </p>
</header>

<main>


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






