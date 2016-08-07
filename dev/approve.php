<?php
include 'functions\functions.php';


$decision = "approved";

$orderID = $_POST['orderID'];

foreach($_POST['orderselected'] as $cid) {

    $sql = "Update `checkout`
            set status = '$decision'
             WHERE  `c_id` ={$cid}";

    if ($query = $db->query($sql)) {
        echo "Successful";
        header("Location: adminvieworders.php?action=approved");
    } else {
        echo "Error" . $sql . '<br>' . mysqli_error($db);
        header('Location: adminvieworders.php?action=failed');;
    }
}