<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 8/2/2016
 * Time: 11:55 PM
 */


// Start session
session_start();
$role = $_SESSION['sess_userrole'];
$email= $_SESSION['sess_email'];
$userid = $_SESSION['userid'];
$firstname = $_SESSION['sess_firstname'];
if(!isset($_SESSION['sess_email']) && ($role!="user"|| $role!="admin")){
    header('Location: index.php?err=2');
}


include 'functions/functions.php';

// Page title
$page_title ="Checkout";

?>
<!--HTML DOC START-->

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

<!--Main Start -->
<main class="row">


    <ul id="sidenavbar" class=" w3-ul w3-card-2 w3-theme-l4  w3-hoverable col-2" >
        <!-- Navbar header-->
        <li><a href="home.php" class="w3-border-bottom"><h5>Components</h5></a></li>

        <!-- Navbar content from database (move PHP to functions at later time)-->

        <li><a href="home.php?assetCategory=Actuators">Actuators</a></li>
        <li><a href="home.php?assetCategory=Connectors">Connectors</a></li>
        <li><a href="home.php?assetCategory=LCD_Matrix">LCD & Matrix</a></li>
        <li><a href="home.php?assetCategory=Passive_Active">Passive & Active</a></li>
        <li><a href="home.php?assetCategory=Sensors">Sensors</a></li>
    </ul>

    <div id="content" class="col-10 w3-padding-row">



        <?php
        if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {


            $created = date('Y-m-d H:i:s');;
            $t = time();
            $a = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4);
            $orderID = $a . $t;

            // set default due date for one week from checkout
            $nextWeek = $t + (7 * 24 * 60 * 60);
            $duedate = date('Y-m-d 00:00:00',$nextWeek);

            for ($i = 0; $i < count($_POST['cart_quantity']); $i++) {

                $id = $_POST['assetID'][$i];
                $name = $_POST['assetName'][$i];
                $quantity = $_POST['cart_quantity'][$i];

                if (!isset($_SESSION['cart_items'])) {
                    $_SESSION['cart_items'] = array();
                }

                // incase quantity has been updated . Insert new values into array
                $_SESSION['cart_items'][$id] = array('assetID' => $id, 'assetName' => $name, 'quantity' => $quantity);

            }

            echo "<h4>Receipt</h4>";
            echo "<p>Thank you for using the Arduino booking System.</p>";
            echo "<p>Your order has been placed. Your order number is : {$orderID }</p>";
            echo "<p>Present this number to the Module co-ordinator to recieve your items.</p>";
            echo "<h4>Order Summary</h4>";

            echo "<table class='w3-table w3-bordered  w3-border w3-hoverable '>";

            // our table heading
            echo "<tr class=' w3-light-grey'>";
            echo "<th>AssetID</th>";
            echo "<th>Asset Name</th>";
            echo "<th>Quantity</th>";
            echo "<th>Due Date</th>";
            echo "</tr>";

            $counter = 0;
            foreach ($_SESSION['cart_items'] as $key => $value) {
                $newitemparam1 = $value['assetID'];
                $newitemparam2 = $value['assetName'];
                $newitemparam3 = $value['quantity'];

                $counter++;


                echo "<tr>";
                echo "<th>$newitemparam1</th>";
                echo "<th>$newitemparam2</th>";
                echo "<th>$newitemparam3</th>";
                echo "<th>$duedate</th>";
                echo "</tr>";


                $sql = "INSERT INTO `checkout`(`assetID`,`quantity`,`c_created`,`orderID`,`c_duedate`,`userid`)
                      VALUES ('$newitemparam1','$newitemparam3','$created','$orderID','$duedate','$userid')";

                if ($result = mysqli_query($db, $sql)) {


                    // When sucessfull send email and unset session

                    if ($counter==1){

                        require_once 'swiftmailer/lib/swift_required.php';
                        // Create the Transport
                        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
                            ->setUsername('no.reply.ac.booking.system@gmail.com')
                            ->setPassword('AcBsMth3s1s!')
                        ;
                        // Create the Mailer using your created Transport
                        $mailer = Swift_Mailer::newInstance($transport);
                        // Create the message
                        $message = Swift_Message::newInstance();
                        // Give the message a subject
                        $message->setSubject('Your order has been placed');
                        // Set the From address with an associative array
                        $message->setFrom(array('no.reply.ac.booking.system@gmail.com' => 'DoNotReply Arduino component Booking System'));
                        // Set the To addresses with an associative array
                        $message->setTo(array($email => $firstname));
                        // Give it a body
                        $message->setBody('<p>Hello, '.$firstname.'</p>
                                    <p>Thank you for using the Arduino booking System.</p>
                                    <p>Your order has been placed. Your order number is:<b>'. $orderID.'</b> </p>
                                    <p>Present this number to the Module co-ordinator to recieve your items.</p>
                                    <br><br>
                                    <span>Kind Regards,</span>
                                    <br><br>
                                    <span>Admin</span>
                                    <br><br>
                                    ','text/html');
                        // Send the message
                        $numSent = $mailer->send($message); }


                    unset($_SESSION['cart_items']);
                } else {

                    echo "Error:" . $sql . "<br>" . mysqli_error($db);
                }

            }
            echo "</table>";

        }

        ?>
        <p><a href="home.php" ><button class="w3-btn ">Make another booking</button></a></p>

    </div>

</main>

<footer class="w3-container w3-light-grey">
    <p> Designed by Somto Eluwa</p>
</footer>
</body>
</html>