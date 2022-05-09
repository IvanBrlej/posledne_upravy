<?php
session_start();
require 'includes/connection.php';

$method = $_SERVER['REQUEST_METHOD'];
if($method == "GET"){
    $sql = "SELECT * FROM items";
    $result = mysqli_query($con, $sql);
    $rows = array();

    if(mysqli_num_rows($result) > 0) {
        while ($r = mysqli_fetch_assoc($result)) {
            array_push($rows, $r);
        }
        print json_encode($rows);
    }else{
        echo "No data";
    }
}else if($method == "POST"){
    $desc = $_POST['itemDescription'];
    $dueDate = $_POST['itemDueDate'];
    $priority = $_POST['itemPriority'];

    $sql_insert = "INSERT INTO items (itemId, itemDescription, itemDueDate, itemPriority)
                    VALUES (NULL, '$desc','$dueDate', '$priority')";
    if(mysqli_query($con, $sql_insert)){
        echo "Item successfully added to the database";
    }else{
        echo "ERROR: $sql_insert did not run".mysqli_error($con);
    }
}
mysqli_close($con);
?>