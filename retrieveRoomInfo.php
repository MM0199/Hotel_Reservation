<?php
$conn = new mysqli("localhost", "root", "", "hotel_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the ROOM and ROOM_RATE tables using JOIN
$sql = "SELECT r.room_number, r.room_type, r.available, rr.rate 
        FROM ROOM r
        JOIN ROOM_RATE rr ON r.room_type = rr.room_type";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Data</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Available</th>
            <th>Rate</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["room_number"] . "</td>";
                echo "<td>" . $row["room_type"] . "</td>";
                echo "<td>" . ($row["available"] ? "Available" : "Not Available") . "</td>";
                echo "<td>$" . $row["rate"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data available.</td></tr>";
        }
        ?>
    </table>
</body>
</html>