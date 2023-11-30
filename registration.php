<?php
        $firstName = $_POST["firstname"];
        $lastName = $_POST["lastname"];
        $password = $_POST["password"];
        $repeatPassword = $_POST["repeatpassword"];
        $email = $_POST["email"];
        $phoneNumber = $_POST["phonenumber"];
        $birthDate = $_POST["birthdate"];
        $address = $_POST["address"];
        $address2 = $_POST["addressline2"];
        $state = $_POST["state"];
        $city = $_POST["city"];
        $zipcode = $_POST["zipcode"];

        // Combine the address values, checking if $address2 is empty
        $combinedAddress = $address . ' ' . $city . ' ' . $state . ' ' . $zipcode;

        if (!empty($address2)) {
            $combinedAddress = $address . ' ' . $address2 . ' ' . $city . ' ' . $state . ' ' . $zipcode;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $errors = array(
            "all_field" => "ALL fields are required!",
            "email_not_valid" => "Email is not valid!",
            "password_length" => "Password must be 8 characters long!",
            "password_not_match" => "Repeat password does not match!",
            "username_taken" => "Username is already taken!",
            "email_taken" => "Email address is already registered!",
            "phone_invalid" => "Invalid phone number.",
            "name_contain_number" => "Name cannot contains number.",
            );
        $error = "";
        if(empty($firstName) OR empty($lastName) OR empty($password) OR empty($repeatPassword) OR empty($email) OR empty($phoneNumber) OR empty($birthDate) 
        OR empty($address) OR empty($state) OR empty($city) OR empty($zipcode)){
            $error .= $errors["all_field"] . "<br>";
        }
        if(preg_match('/\d/', $firstName) OR preg_match('/\d/', $lastName)){
            $error .= $errors["name_contain_number"] . "<br>";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error .= $errors["email_not_valid"] . "<br>";
        }
        if(strlen($password) < 8){
            $error .= $errors["password_length"] . "<br>";
        }
        if($password != $repeatPassword){
            $error .= $errors["password_not_match"] . "<br>";
        }
        if(strlen($phoneNumber) != 10){
            $error .= $errors["phone_invalid"] . "<br>";
        }

        $conn = new mysqli("localhost", "root", "", "hotel_database");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sqlEmail = "SELECT * FROM user WHERE email = '$email'";
        $resultEmail = mysqli_query($conn, $sqlEmail);
        if(mysqli_num_rows($resultEmail) > 0){
            $error .= $errors["email_taken"] . "<br>";
        }

        if(!empty($error)){
            echo    "<script>
                    var errorMessage = '$error';
                    alert(errorMessage.replace(/<br>/g, '\\n'));
                    window.location.href = 'registration.html';
                    </script>";
        } else {                 
            $sql = "INSERT INTO USER (first_name, last_name, phone, email, pass, date_of_birth, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $sqlCus = "INSERT INTO CUSTOMER (customer_id, loyal_point) VALUES(?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if($prepareStmt){
                mysqli_stmt_bind_param($stmt, "sssssss", $firstName, $lastName, $phoneNumber, $email, $passwordHash, $birthDate, $combinedAddress);
                mysqli_stmt_execute($stmt);
            } else {
                die("Something went wrong");
            } 
            $prepareStmtCus = mysqli_stmt_prepare($stmt, $sqlCus);
            // Get the ID of the inserted user
		    $uid = mysqli_insert_id($conn);
            if($prepareStmt){
				$test = 0;
                mysqli_stmt_bind_param($stmt, "ss", $uid, $test);
                mysqli_stmt_execute($stmt);
                mysqli_close($conn);
                echo    "<script>
                        alert('You can now login using your new account.');
                        window.location.href = 'login.html';
                        </script>";
            } else {
                die("Something went wrong");
            } 
        }

?>