<?php
	$guestId = $_POST['guestId'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$roomNum = $_POST['roomNum'];
	$checkInDate = $_POST['checkIn'];
	$checkOutDate = $_POST['checkOut'];
	$amount = $_POST['amount'];
	$cardNumber = $_POST['cardNumber'];
	$cardName = $_POST['cardholderName'];
	$expMonth = $_POST['expirationDateMonth'];
	$expYear = $_POST['expirationDateYear'];
	$cvv = $_POST['cvv'];

	$errors = array(
		"all_field" => "ALL fields are required!"
		);
	$error = "";

	if(empty($cardNumber) OR empty($cardName) OR empty($expMonth) 
			OR empty($expYear) OR empty($cvv)){
				$error .= $errors["all_field"] . "<br>";
			}

			
	$conn = new mysqli("localhost", "root", "", "hotel_database");
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
		echo "no connection\n";
	}

	if ($guestId == 'null') {
		$sqlG = "INSERT INTO USER (first_name, last_name)	VALUES(?, ?)";
		$stmtG = mysqli_stmt_init($conn);
		$prepareStmtG = mysqli_stmt_prepare($stmtG, $sqlG);

		if ($prepareStmtG) {
			mysqli_stmt_bind_param($stmtG, "ss", $firstName, $lastName);
			if (mysqli_stmt_execute($stmtG)) {
				// Get the ID of the inserted user
				$uid = mysqli_insert_id($conn);

				$sqc = "INSERT INTO CUSTOMER (customer_id, loyal_point) VALUES($uid, 0)";
				$conn->query($sqc);
					
			} else {
				echo "Error executing user insertion statement: " . mysqli_stmt_error($stmtG) . "\n";
			}
		} else {
			die("User insertion statement preparation failed: " . mysqli_error($conn) . "\n");
		}
	} 

	$isExist = true;
	while($isExist){
		$randomNumber = rand(0, 999999);

		$sqr = "SELECT reserve_id
				FROM RESERVATION_C
				WHERE reserve_id = $randomNumber";

		$result = $conn->query($sqr);

		if ($result->num_rows === 0){
			$isExist = !$isExist;
		}
	}
	$sqe = "INSERT INTO RESERVATION_C (reserve_id, status)	VALUES($randomNumber, 'Confirmed')";
	$conn->query($sqe);

	$sqa = "INSERT INTO RESERVATION_A (customer_id, room_number, reserve_id) VALUES($uid, $roomNum, $randomNumber)";
	$conn->query($sqa);

	$sqb = "INSERT INTO RESERVATION_B (reserve_id, room_number, check_in_date, check_out_date) VALUES($randomNumber, $roomNum, $checkInDate, $checkOutDate)";
	$conn->query($sqb);

	$conn->close();
	echo "	<script>
				alert('Your booking have been complete.\\nBooking Number: $randomNumber');
				window.location.href = 'home.html';
			</script>	";
?>
