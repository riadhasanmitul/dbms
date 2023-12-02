<?php
include "manage_cars.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "username", "password", "car_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$car = [];

if (isset($_GET['eid'])) {
    $eid = $_GET['eid'];
    $stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
        if (isset($_POST['edit_car'])) {
            $Brand = $_POST['Brand'];
            $model = $_POST['model'];
            $year = $_POST['year'];
            $license_plate = $_POST['license_plate'];
            $owner = $_POST['owner'];

            $update_stmt = $conn->prepare("UPDATE cars SET Brand=?, model=?, year=?, license_plate=?, owner=? WHERE id=?");
            $update_stmt->bind_param("sssssi", $Brand, $model, $year, $license_plate, $owner, $id);

            if ($update_stmt->execute()) {
                echo "Record Update Successful";
                header('location: manage_cars.php');
            } else {
                echo 'Error: ' . $update_stmt->error;
            }

            $update_stmt->close();
        }
    } else {
        echo "Car not found";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Car</title>
</head>
<body>
    <h2>Edit Car</h2>
    <form method="post" action="">
        Brand: <input type="text" name="Brand" value="<?= isset($car['Brand']) ? $car['Brand'] : '' ?>" required><br>
        Model: <input type="text" name="model" value="<?= isset($car['model']) ? $car['model'] : '' ?>" required><br>
        Year: <input type="text" name="year" value="<?= isset($car['year']) ? $car['year'] : '' ?>" required><br>
        License Plate: <input type="text" name="license_plate" value="<?= isset($car['license_plate']) ? $car['license_plate'] : '' ?>" required><br>
        Owner: <input type="text" name="owner" value="<?= isset($car['owner']) ? $car['owner'] : '' ?>" required><br>
        <input type="submit" name="edit_car" value="Update Car">
    </form>
</body>
</html>