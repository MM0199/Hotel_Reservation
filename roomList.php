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
        WHERE r.available = 1"; // Adding a condition to fetch only available rooms

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
              <a href="javascript:void(0)" onclick="getRoom()">GET A ROOM</a>
            </div>
            <!-- Profile Icon and Link to Login Page -->
            <div class="profile-icon">
              <a href="login.html"><img class="profile-pic" src="profile-pic.png" alt="Profile" /></a>
            </div>
          </div>

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="home.html">Home</a>
            <a href="roomList.php">Room</a>
            <a href="javascript:void(0)" onclick="getRoom()">Get a room</a>
            <a id="loginLink" href="login.html">Login</a>
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Contact</a>
            <a id="logoutLink" href="javascript:void(0)" style="display: none;" onclick="logout()">Logout</a>
        </div>

        <div class="room-container" id="roomContainer">
        </div>

        <script src="script.js"></script>


    </body>


    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Rooms</title>
    <style>
        .room-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            padding: 10px;
            margin: 10px;
            display: inline-block;
            vertical-align: top;
        }
        .room-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .room-details {
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="room-container">
    <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<a href='reservationDetail.html" . urlencode($row["room_type"]) . "' class='room-card-link'>";
                echo "<div class='room-card'>";
                echo "<img class='room-image' src='pictures/" . urlencode($row["room_type"]) . ".jpg' alt='Room Image'>";
                echo "<div class='room-details'>";
                echo "<p><strong>Room Number:</strong> " . $row["room_number"] . "</p>";
                echo "<p><strong>Room Type:</strong> " . $row["room_type"] . "</p>";
                echo "<p><strong>Room Price:</strong> $" . $row["rate"] . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</a>";
            }
        } else {
            echo "<p>No available rooms.</p>";
        }
        ?>
    </div>
</body>
</html>