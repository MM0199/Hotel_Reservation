<?php
$conn = new mysqli("localhost", "root", "", "hotel_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the ROOM and ROOM_RATE tables using JOIN
$sql = "SELECT r.room_number, r.room_type, r.available, rr.rate 
        FROM ROOM r
        JOIN ROOM_RATE rr ON r.room_type = rr.room_type
        WHERE r.available = 1 ORDER BY r.room_number"; // Adding a condition to fetch only available rooms

$result = $conn->query($sql);

$conn->close();
?>


<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Room</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <!-- App bar -->
        <div class="topnav">
            <span class="menu" onclick="openNav()">&#9776;</span>
            <label class="hotel-name"><a href="home.html">The Hotel</a></label>
            <div class="get-room">
                <a href="roomList.php">GET A ROOM</a>
            </div>
            <!-- Profile Icon and Link to Login Page -->
            <div class="profile-pic">
                <a id="profileLink" href=""><img src="profile-pic.png" id="profile-pic" alt="Profile" /></a>
            </div>
        </div>
        <!-- Side bar -->
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="home.html">Home</a>
            <a href="roomList.php">Get a room</a>
            <a id="loginLink" href="login.html">Login</a>
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Contact</a>
            <a id="logoutLink" href="javascript:void(0)" style="display: none;" onclick="logout()">Logout</a>
        </div>


    <?php
        $counter = 0;
        if ($result->num_rows > 0) {
            echo "<div class='room-container'>"; // Open the room container div

            while ($row = $result->fetch_assoc()) {
                $room_type = $row["room_type"];
                $room_number = $row["room_number"];
                $room_rate = $row["rate"];


                if ($counter % 5 == 0) {
                    // Start a new room row every 5 rooms
                    echo "<div class='room-row'>";
                }

                // Display room information
                echo "<div class='room-card' id='$room_number' onclick='getInfor(this)'>";
                echo "<img class='room-image' src='pictures/" . urlencode($row["room_type"]) . ".jpg' alt='Room Image'>";
                echo "<div class='room-details'>";
                echo "<p><strong>Room Number:</strong> " . $room_number . "</p>";
                echo "<p id='$room_number" . "_type'><strong>Room Type:</strong> " . $room_type . "</p>";
                echo "<p id='$room_number" . "_rate'><strong>Room Price:</strong> $" . $room_rate . "</p>";
                echo "</div>";
                echo "</div>";

                $counter++;

                if ($counter % 5 == 0) {
                    // Close the room row every 5 rooms
                    echo "</div>";
                }
            }

            // Close any remaining room row
            if ($counter % 5 != 0) {
                echo "</div>";
            }

            echo "</div>";
        } else {
            echo "<p>No available rooms.</p>";
        }
    ?>
    
    <script src="script.js"></script>
</body>
</html>