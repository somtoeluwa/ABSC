<?php
session_start();
$role = $_SESSION['sess_userrole'];
if(!isset($_SESSION['sess_username']) && $role!="admin"){
    header('Location: index.php?err=2');
}
include 'functions\functions.php';

// Page title
$page_title ="Order Details";
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
                    <a href="account.php?userid=<?php echo $_SESSION['userid'];?>"><?php echo $_SESSION['sess_firstname'];?>'s Profile</a>
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
            <li class="w3-right" <?php echo $page_title=="Cart" ? "class='active'" : ""; ?> >
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
    <div  id="AssetOptions" class="w3-sidenav w3-white w3-card-2" style="width:160px">

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
            $search = $_POST['search'];
            $sql = "SELECT checkout.*,users.email,asset.assetName,asset.total_stock,asset.total_owned
                              FROM `checkout`,`users`,`asset`
                              WHERE  `orderID` = '" . $search . "' AND `status` = 'pending'
                              AND checkout.userid = users.userid
                              AND checkout.assetID = asset.assetID";
            $result = $db->query($sql);
            if (mysqli_num_rows($result) > 0) {
                $counter = 0;
                ?>
                <h5>Order Table</h5>
                <div class="w3-responsive">
                <form name="approveorder" id="approveorder" action="approve.php" method="post">
                    <table class="w3-table w3-bordered w3-reverse-striped w3-border w3-hoverable" id="table">
                        <tr class="w3-light-grey">
                            <th></th>
                            <th>SN</th>
                            <th>Asset ID</th>
                            <th>Asset Name</th>
                            <th>Quantity Requested</th>
                            <th>Total in Stock</th>
                            <th>Total Owned</th>
                            <th>OrderID</th>
                            <th>Date ordered</th>
                            <th>Return date</th>
                            <th>User ID</th>
                            <th>User email</th>
                            <th>Status</th>
                        </tr>

                        <?
                        while ($row = $result->fetch_array()) {
                            $counter++;
                            ?>
                            <tr>
                                <td><input type="checkbox"   name="orderselected[]" id="orderselected" value="<?php echo $row['c_id'];?>"/>
                                    <input type="hidden" name="total_stock[]" value="<?php echo $row['total_stock']; ?>"/>
                                    <input type="hidden" name="quantity[]" value="<?php echo $row['quantity']; ?>"/>
                                    <input type="hidden" name="orderID" value="<?php echo $row['orderID']; ?>"/>
                                    <input type="hidden" name="assetID[]" value="<?php echo $row['assetID'];?>"/></td>

                                <td><?php echo $counter;?></td>
                                <td><?php echo $row['assetID'];?></td>
                                <td><?php echo $row['assetName'];?></td>
                                <td><?php echo $row['quantity'];?></td>
                                <td><?php echo $row['total_stock'];?></td>
                                <td><?php echo $row['total_owned'];?></td>
                                <td><?php echo $row['orderID'];?></td>
                                <td><?php echo $row['c_created'];?></td>
                                <td><?php echo $row['c_duedate'];?></td>
                                <td><?php echo $row['userid'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['status'];?></td>

                            </tr>
                            <?
                        }
                        ?>
                    </table>

                    <button type="submit" class="w3-btn w3-right w3-margin confirmation">Approve</button>
                </form>
            </div>
                <?
            }
            else{
                ?>
                    <div id="response" class="w3-container w3-card-2 " align="center">
                        <div id="empty_category" align="left">
                            <p>No order matches the order ID.</p>
                            <a href="adminapprove.php"><button class="w3-center"> Go Back</button></a>
                        </div>
                    </div>
                    <?php
            }
                ?>
        </div>
    </main>
<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Approve this order?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>


</body>
</html>

