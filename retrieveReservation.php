<?php
$conn = new mysqli("localhost", "root", "", "hotel_database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the reservation_b table and left join with reservation_a based on room_number
$sql_a = "SELECT rb.reserve_id, rb.room_number, rb.check_in_date, rb.check_out_date, ra.customer_id, u.first_name, u.last_name
        FROM reservation_b rb
        LEFT JOIN reservation_a ra ON ra.room_number = rb.room_number
        LEFT JOIN USER u ON ra.customer_id = u.user_id";
$result_a = $conn->query($sql_a);

// Fetch data from the reservation_b table and left join with reservation_c based on reserve_id
$sql_c = "SELECT rb.reserve_id, rb.room_number, rb.check_in_date, rb.check_out_date, rc.status
        FROM reservation_b rb
        LEFT JOIN reservation_c rc ON rc.reserve_id = rb.reserve_id";
$result_c = $conn->query($sql_c);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <style>
        /* Table styles */
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
        /* Header style for "current reservations" */
        .header {
            background-color: blue;
            color: white;
            padding: 10px;
        }
         /* Tooltip styles */
    .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
        cursor: help;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -60px;

        /* Fade in the tooltip */
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
    </style>
    
</head>
<body>
<h1 class="header">Current Reservations</h1>
    <table>
        <tr>
            <th>Reservation ID</th>
            <th>Room Number</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Customer Name</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result_a->num_rows > 0 && $result_c->num_rows > 0) {
            while ($row_a = $result_a->fetch_assoc()) {
                $found = false;
                $result_c->data_seek(0);
                while ($row_c = $result_c->fetch_assoc()) {
                    if ($row_a['reserve_id'] === $row_c['reserve_id']) {
                        echo "<tr>";
                        echo "<td>" . $row_a["reserve_id"] . "</td>";
                        echo "<td>" . $row_a["room_number"] . "</td>";
                        echo "<td>" . date('M j, Y H:i:s', strtotime($row_a["check_in_date"])) . "</td>";
                        echo "<td>" . date('M j, Y H:i:s', strtotime($row_a["check_out_date"])) . "</td>";
                        // Formatting customer name as a link to their account
                        echo "<td><a href='userAccount.html'>" . $row_a["first_name"] . " " . $row_a["last_name"] . " (" . $row_a["customer_id"] . ")" . "</a></td>";
                        echo "<td>" . $row_c["status"] . "</td>";
                        echo "</tr>";
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    echo "<tr><td>" . $row_a["reserve_id"] . "</td><td>" . $row_a["room_number"] . "</td><td>" . $row_a["check_in_date"] . "</td><td>" . $row_a["check_out_date"] . "</td><td>" . $row_a["first_name"] . " " . $row_a["last_name"] . " (" . $row_a["customer_id"] . ")" . "</td><td>No status found</td></tr>";
                }
            }
        } else {
            echo "<tr><td colspan='6'>No reservations found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>