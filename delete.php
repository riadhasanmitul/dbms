<?php
include "manage_cars.php"; 
if(isset($_GET['did'])){
    $did = $_GET['did'];
    $sql = "DELETE FROM cars WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $did);

    if($stmt->execute()){
        echo "Record Delete Successful";
        header('location: manage_cars.php');
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>