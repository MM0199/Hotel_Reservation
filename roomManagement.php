<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
        .available {
            color: green;
        }
        .unavailable {
            color: red;
        }
    </style>
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
		<a href="roomManagement.php">Room Management</a>
        <a id="logoutLink" href="javascript:void(0)" style="display: none;" onclick="logout()">Logout</a>
      </div>

    <div class="room-container" id="roomContainer">
    </div>

    <body>
        <h1>Hotel Rooms</h1>
        <?php include 'retrieveRoomInfo.php'; ?>

    <script src="script.js"></script>
</body>
</html>


    <script>
        // Function to open the pop-up window for adding rooms
// Function to add a room to the table
function addRoomToTable(room) {
  const tableBody = document.getElementById('room-table-body');
  const row = tableBody.insertRow();

  // Create cells for each room attribute
  const cell1 = row.insertCell(0);
  const cell2 = row.insertCell(1);
  const cell3 = row.insertCell(2);
  const cell4 = row.insertCell(3);
  const cell5 = row.insertCell(4);

  // Populate the cells with room data
  cell1.innerHTML = room.roomNumber;
  cell2.innerHTML = room.bedCount;
  cell3.innerHTML = room.bathCount;
  cell4.innerHTML = room.ratePerNight;
  cell5.innerHTML = room.availability;
}

// Function to open the pop-up window for adding rooms
function openRoomFormPopup() {
  const newWindow = window.open("", "RoomFormPopup", "width=400,height=400");

  // Build the form in the pop-up window
  const formHtml = `
    <form id="room-form">
      <label for="room-number">Room Number:</label>
      <input type="text" id="room-number" name="room-number">
      <label for="bed-count">Bed Count:</label>
      <input type="text" id="bed-count" name="bed-count">
      <label for="bath-count">Bath Count:</label>
      <input type="text" id="bath-count" name="bath-count">
      <label for="rate-per-night">Rate per Night:</label>
      <input type="text" id="rate-per-night" name="rate-per-night">
      <label for="availability">Availability:</label>
      <select id="availability" name="availability">
          <option value="available">Available</option>
          <option value="unavailable">Unavailable</option>
      </select>
      <button type="button" id="add-room">Add Room</button>
    </form>
  `;

  newWindow.document.write(formHtml);

  // Add a listener for adding rooms in the pop-up window
  newWindow.document.getElementById('add-room').addEventListener('click', function () {
    const room = {
      roomNumber: newWindow.document.getElementById('room-number').value,
      bedCount: newWindow.document.getElementById('bed-count').value,
      bathCount: newWindow.document.getElementById('bath-count').value,
      ratePerNight: newWindow.document.getElementById('rate-per-night').value,
      availability: newWindow.document.getElementById('availability').value,
    };

    // Call the function to add the room to the table in the main window
    window.opener.addRoomToTable(room);

    // Close the pop-up window
    newWindow.close();
  });

  newWindow.focus();
}

// Attach the openRoomFormPopup function to the button click event
document.getElementById('openRoomForm').addEventListener('click', openRoomFormPopup);
    </script>
</body>
</html>