<?php
$email = $_GET["email"];
$pwd = $_GET["password"];

$conn = new mysqli("localhost", "root", "", "hotel_database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT user_id, first_name, last_name, email, pass
        FROM USER
        WHERE email = ?";

$emp = "SELECT *
        FROM EMPLOYEE
        WHERE employee_id = $user_id";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->bind_result($user_id, $first_name, $last_name, $db_email, $db_pass);

    if ($stmt->fetch()) {
        // Verify the hashed password
        if (password_verify($pwd, $db_pass)) {
            // set the login status
            $result = $conn->query($emp);
            if ($result->num_rows === 0){
               $isEmployee = false;
            } else {
                $isEmployee = true;
            }
            echo    "<script>
                        localStorage.setItem('isLoginStatus', true);
                        localStorage.setItem('guestId', $user_id);
                        localStorage.setItem('isEmployee', $isEmployee);
                        window.location.href = 'home.html';
                    </script>";
        } else {
            echo "Invalid credentials";
        }
    } else {
        echo "Invalid credentials";
    }

    $stmt->close();
} else {
    die("Error in the prepared statement: " . $conn->error);
}

$conn->close();
?>
