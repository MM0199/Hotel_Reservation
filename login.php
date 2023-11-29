<?php
$email = $_GET["email"];
$pwd = $_GET["password"];

$conn = new mysqli("localhost", "root", "", "hotel_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_id, first_name, last_name, email, pass
        FROM USER
        WHERE email = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->bind_result($user_id, $first_name, $last_name, $db_email, $db_pass);

    if ($stmt->fetch()) {
        // Verify the hashed password
        if (password_verify($pwd, $db_pass)) {
            // Close the result set of the first query before executing the second query
            $stmt->close();

            // Set the login status
            $emp = "SELECT *
                FROM EMPLOYEE
                WHERE employee_id = ?";
            $stmt_emp = $conn->prepare($emp);
            $stmt_emp->bind_param("i", $user_id);
            $stmt_emp->execute();
            $stmt_emp->bind_result($eid, $mid, $salary);
            $stmt_emp->fetch();

            // Determine if the user is an employee
            if($eid !== null){
                echo "<script>
                        localStorage.setItem('isEmployee', true);
                    </script>";
            } else {
                echo "<script>
                        localStorage.setItem('isEmployee', false);
                    </script>";
            }


            echo    "<script>
                        localStorage.setItem('isLoginStatus', true);
                        localStorage.setItem('guestId', $user_id);
                        window.location.href = 'home.html';
                    </script>";

            $stmt_emp->close();
        } else {
            echo    "<script>
                        alert('Invalid credentials');
                        window.location.href = 'login.html';
                    </script>";

            // Close the result set of the first query
            $stmt->close();
        }
    } else {
        echo "<script>
                alert('Invalid credentials');
                window.location.href = 'login.html';
            </script>";

        // Close the result set of the first query
        $stmt->close();
    }
} else {
    die("Error in the prepared statement: " . $conn->error);
}

$conn->close();
?>