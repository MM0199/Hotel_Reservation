<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Result</title>
  <link rel="stylesheet" href="styles.css"/>
  <style>
    p {
      position: absolute;
      background-color: white;
      top: 250px;
      padding: 10px 20px;
      font-size: 25px;
    }
    #return {
      position: absolute;
      background-color: white;
      top: 320px;
      padding: 10px;
      text-decoration-line: none;
      color: black;
      border-radius: 25px;
    }
  </style>
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
    <div class="profile-pic">
      <a id="profileLink" href=""><img src="profile-pic.png" id="profile-pic" alt="Profile" /></a>
    </div>
  </div>
  <!-- Side bar -->
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="home.html">Home</a>
    <a href="roomList.html">Get a room</a>
    <a id="loginLink" href="login.html">Login</a>
    <a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Contact</a>
    <a id = "empOnly" href="employeeManagement.html" style = "visibility: hidden;">For Employees</a>
    <a id="logoutLink" href="javascript:void(0)" style="display: none;" onclick="logout()">Logout</a>
  </div>

  <a href = "employeeManagement.html" id = "return">Return to previous page</a>

  <script src="script.js"></script>
  <script>
    let isEmployee;
    localStorage.setItem('isEmployee', true);
    let permission = localStorage.getItem('isEmployee');
    if(permission == "true") {
      document.getElementById("empOnly").style.visibility = "visible";
    }
  </script>

  <?php

    $role = $_GET["role"];
    $action = $_GET["action"];

    $ID = $_GET["user_id"];

    if(empty($ID)) {
      exit("<p>Error: Please enter an ID.</p>");
    } else if (!is_numeric($ID)) {
      exit("<p>Error: ID must have numbers only.</p>");
    }

    if($action == "create" || $action == "modify") {
      $fname = $_GET["fname"];
      $lname = $_GET["lname"];
      $phone = $_GET["phone"];
      $email = $_GET["email"];
      $DOB = $_GET["date_of_birth"];
      $address = $_GET["address"];
      $loyPoints = $_GET["loyalty_points"];
      $MID = $_GET["manager_id"];
      $salary = $_GET["salary"];
    }

    $conn = new mysqli("localhost","root","","hotel_database");

    if ($conn->connect_error) {
      exit("<p>Connection error</p>");
    }

    //$conn -> close should be good.

    if($action == "deactivate") {

      $sql = "SELECT user_id FROM USER WHERE user_id = '$ID'";
      if($temp = $conn->query($sql)) {
        $count = $temp->fetch_row();
        if ($count <= 0) {
          $conn -> close();
          exit("<p>Error: Person not in database.</p>");
        }
        $temp -> free_result();
      }


      $sql = "DELETE FROM USER WHERE user_id = '$ID'";
      if ($temp = $conn->query($sql)) {
        echo "<p>Account deletion successful.</p>";
      } else {
        echo "<p>Error deleting record</p>";
      }

    } else if ($action == "create" ) {

      $sql = "SELECT user_id FROM USER WHERE user_id = '$ID'";
      if($temp = $conn->query($sql)) {
        $count = $temp->fetch_row();
        if ($count >= 1 ) {
          $conn -> close();
          exit("<p>Error: Person already in database.</p>");
        }
        $temp -> free_result();
      }

      $sql = "INSERT INTO USER
              VALUES ('$ID', '$fname', '$lname', '$phone', '$email',NULL,'$DOB', '$address')";
      $conn->query($sql);
      //if($conn->query($sql)) {echo "USER insert successful ";}
      
      //check if $MID is null to determine the table to insert into.
      if(empty($MID)) {
        //customer
        $sql = "UPDATE CUSTOMER
                SET loyal_point = '$loyPoints'
                WHERE customer_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "CUSTOMER insert successful ";}
      } else {
        //employee
        $sql = "UPDATE EMPLOYEE
                SET manager_id = '$MID', salary = '$salary'
                WHERE employee_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "EMPLOYEE insert successful ";}
      }
      
      echo "<p>Account creation succesful.</p>";

    } else if ($action == "modify") {
      if(!empty($fname)) {
        $sql = "UPDATE USER
                SET first_name = '$fname'
                WHERE user_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "first name update successful ";}
      }

      if(!empty($lname)) {
        $sql = "UPDATE USER
                SET last_name = '$lname'
                WHERE user_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "last name update successful ";}
      }

      if(!empty($phone)) {
        $sql = "UPDATE USER
                SET phone = '$phone'
                WHERE user_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "phone update successful ";}
      }

      if(!empty($email)) {
        $sql = "UPDATE USER
                SET email = '$email'
                WHERE user_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "email update successful ";}
      }

      if(!empty($address)) {
        $sql = "UPDATE USER
                SET address = '$address'
                WHERE user_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "address update successful ";}
      }

      if(($role == "front_desk" || $role == "administrator") && !empty($loyPoints)) {
        $sql = "UPDATE CUSTOMER
                SET loyal_point = '$loyPoints'
                WHERE customer_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "loyalty points update successful ";}
      } else if($role == "manager" && !empty($loyPoints)) {
        $conn -> close();
        exit("<p>Error: Role must be Front Desk or Administrator</p>");
      }

      if(($role == "manager" || $role == "administrator") && !empty($MID)) {
        $sql = "UPDATE EMPLOYEE
                SET manager_id = '$MID'
                WHERE employee_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "manager id update successful ";}
      } else if($role == "front_desk" && !empty($MID)) {
        $conn -> close();
        exit("<p>Error: Role must be Manager or Administrator</p>");
      }

      if(($role == "manager" || $role == "administrator") && !empty($salary)) {
        $sql = "UPDATE EMPLOYEE
                SET salary = '$salary'
                WHERE employee_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "salary update successful ";}
      } else if($role == "front_desk" && !empty($salary)) {
        $conn -> close();
        exit("<p>Error: Role must be Manager or Administrator</p>");
      }

      if(($role == "manager" || $role == "administrator") && !empty($DOB)) {
        $sql = "UPDATE USER
                SET date_of_birth = '$DOB'
                WHERE user_id = '$ID'";
        $conn->query($sql);
        //if($conn->query($sql)) {echo "date of birth update successful ";}
      } else if($role == "front_desk" && !empty($DOB)) {
        $conn -> close();
        exit("<p>Error: Role must be Manager or Administrator</p>");
      }
      echo "<p>Data update successful.</p>";
    }

    $conn -> close();
    
  ?>

</body>
</html>