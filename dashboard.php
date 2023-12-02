<?php
session_start();
$conn = new mysqli("localhost", "username", "password", "car_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//Check Logged in or not
if (!isset($_SESSION['username'])) {
header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }

        h2 {
            color: #333;
        }

        p {
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .dashboard-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
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
    </style>
</head>
<body>
    <header>
        <h1>Car Management System</h1>
    </header>

    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <p><a href='manage_cars.php'>Manage Cars</a></p>
        <p><a href='logout.php'>Logout</a></p>
        <h3>Your Cars</h3>
    <table border="1">
        <tr>
            <th>Brand</th>
            <th>Model</th>
            <th>Year</th>
            <th>License Plate</th>
            <th>Owner</th>
        </tr>
        <?php
        $cars_query = "SELECT * FROM cars";
        $cars_result = $conn->query($cars_query);

        while ($row = $cars_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['Brand']}</td>";
            echo "<td>{$row['model']}</td>";
            echo "<td>{$row['year']}</td>";
            echo "<td>{$row['license_plate']}</td>";
            echo "<td>{$row['owner']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
        
    </div>
</body>
</html>
