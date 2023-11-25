<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
    //Only foucus on USER, CUSTOMER, and EMPLOYEE tables.
    $role = $_GET["role"];
    $action = $_GET["action"];

    $ID = $_GET["user_id"];

    if(empty($ID)) {
      exit("Please enter an id.");
    }

    if($action == "create" || $action == "modify") {
      $fname = $_GET["fname"];
      $lname = $_GET["lname"];
      $phone = $_GET["phone"];
      $email = $_GET["email"];
      $DOB = $_GET["date_of_birth"];
      $address = $_GET["address"];
        
      if ($role == "front_desk" || $role == "administrator") {
        $loyPoints = $_GET["loyalty_points"];
      } else if ($role == "manager" || $role == "administrator") {
        $MID = $_GET["manager_id"];
        $salary = $_GET["salary"];
      }
    }

    $conn = new mysqli("localhost","root","","hotel_database");

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 

    if($action == "deactivate") {
      $sql = "DELETE FROM USER WHERE user_id = '$ID'";
      if ($temp = $conn->query($sql)) {
        echo "Record deleted successfully";
      } else {
        echo "Error deleting record: " . $conn->error;
      }
    } else if ($action == "create" ) {

      $sql = "SELECT user_id FROM USER WHERE user_id = '$ID'";
      if($temp = $conn->query($sql)) {
        $count = $temp->fetch_row();
        if ($count >= 1 ) {
          exit("Person already in database.");
        }
        $temp -> free_result();
      }
      

      $sql = "INSERT INTO USER
              VALUES ('$ID', '$fname', '$lname', '$phone', '$email',NULL,'$DOB', '$address')";
      $conn->query($sql);
      //check if $MID is null to determine the table to insert into.

      if(empty($MID)) {
        //customer
        $sql = "INSERT INTO CUSTOMER
                VALUES ('$ID', '$loyPoints')";
        $conn->query($sql);
      } else {
        //employee
        $sql = "INSERT INTO EMPLOYEE
                VALUES ('$ID', '$MID', '$salary')";
        $conn->query($sql);
      }
      
      //Check if insert is succesfull.

    } else if ($action == "modify") {
      if(!empty($fname)) {
        $sql = "UPDATE USER
                SET first_name = '$fname'
                WHERE user_id = '$ID'";
        $conn->query($sql);
      }

      if(!empty($lname)) {
        $sql = "UPDATE USER
                SET last_name = '$lname'
                WHERE user_id = '$ID'";
        $conn->query($sql);
      }

      if(!empty($phone)) {
        $sql = "UPDATE USER
                SET phone = '$phone'
                WHERE user_id = '$ID'";
        $conn->query($sql);
      }

      if(!empty($email)) {
        $sql = "UPDATE USER
                SET email = '$email'
                WHERE user_id = '$ID'";
        $conn->query($sql);
      }

      if(!empty($DOB)) {
        $sql = "UPDATE USER
                SET date_of_birth = '$DOB'
                WHERE user_id = '$ID'";
        $conn->query($sql);
      }

      if(!empty($address)) {
        $sql = "UPDATE USER
                SET address = '$address'
                WHERE user_id = '$ID'";
        $conn->query($sql);
      }

      if(($role = "front_desk" || $role = "administrator") && !empty($loyPoints)) {
        $sql = "UPDATE CUSTOMER
                SET loyal_point = '$loyPoints'
                WHERE customer_id = '$ID'";
        $conn->query($sql);
      }

      if(($role = "manager" || $role = "administrator") && !empty($MID)) {
        $sql = "UPDATE EMPLOYEE
                SET manager_id = '$MID'
                WHERE employee_id = '$ID'";
        $conn->query($sql);
      }

      if(($role = "manager" || $role = "administrator") && !empty($salary)) {
        $sql = "UPDATE EMPLOYEE
                SET salary = '$salary'
                WHERE employee_id = '$ID'";
        $conn->query($sql);
      }
    }
  
  ?>
</body>
</html>