<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
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
        <!-- Side bar -->
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
        <script src="../JavaScript/script.js"></script>
    </body>
    
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Hotel Room Availability</title>

</head>
<body>

    <?php include 'retrieveReservation.php'; ?>

    <script>
        $(function() {
            // Initialize Datepicker for date input fields
            $(".date-picker").datepicker({
                dateFormat: "yy-mm-dd"
            });

            // Handle "Add Guest" button click
            $(".add-guest-button").click(function() {
                var row = $(this).closest("tr");

                // Replace "Add Guest" button with guest input field
                row.find(".add-guest-button").replaceWith("<input type='text' class='guest-name'>");
                
                // Initialize Datepicker for the new date input fields
                row.find(".checkin, .checkout").datepicker({
                    dateFormat: "yy-mm-dd"
                });
            });
        });
    </script>
     <footer>
        &copy; 2023 SuiteBookers
    </footer>
</body>
</html>






