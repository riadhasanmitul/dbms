<?php
session_start();
//check logged in or not
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$conn = new mysqli("localhost", "username", "password", "car_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['add_car'])) {
    $Brand = $_POST['Brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_plate = $_POST['license_plate'];
    $owner = $_POST['owner'];
    
    $stmt = $conn->prepare("INSERT INTO cars (Brand, model, year, license_plate, owner) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $Brand, $model, $year, $license_plate, $owner);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Cars</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-top: 20px;
            text-align:center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        h3 {
            margin-top: 20px;
            text-align:center;
        }

        p {
            margin: 10px 0;
        }

        p a {
            text-decoration: none;
            color: #007bff;
        }

        p a:hover {
            text-decoration: underline;
        }

        .car-list {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
        .logo{
            text-decoration:none;
            font-size:30px;
            margin:10px;
            background-color: tomato;
            padding:6px;
            border-radius:3px;
            color:black;
        }
    </style>
</head>
<body>
    <a class="logo" href="dashboard.php">Dashboard</a>
    <h2>Manage Cars</h2>
    <form method="post" action="">
        Brand: <input type="text" name="Brand" required><br>
        Model: <input type="text" name="model" required><br>
        Year: <input type="text" name="year" required><br>
        License Plate: <input type="text" name="license_plate" required><br>
        Owner: <input type="text" name="owner" required><br>
        <input type="submit" name="add_car" value="Add Car">
    </form>
    <h3>Your Cars</h3>
    <table border="1">
        <tr>
            <th>Brand</th>
            <th>Model</th>
            <th>Year</th>
            <th>License Plate</th>
            <th>Owner</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
        <?php
        $cars_query = "SELECT * FROM cars";
        $cars_result = $conn->query($cars_query);
        if ($cars_result->num_rows > 0) {
            while ($row = $cars_result->fetch_assoc()) {
            echo "<tr>";
            $id=$row['id'];
            echo "<td>{$row['Brand']}</td>";
            echo "<td>{$row['model']}</td>";
            echo "<td>{$row['year']}</td>";
            echo "<td>{$row['license_plate']}</td>";
            echo "<td>{$row['owner']}</td>";
            echo "<td> <a href='delete.php?did={$id}'>Delete</a> </td>";
            echo "<td><a href='edit.php?eid={$id}'>Edit</a></td>";
            echo "</tr>";
        }
          } else {
            echo "0 results";
          }
        ?>
    </table>
</body>
</html>
