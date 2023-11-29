<?php
// Check if the 'data' parameter is set in the POST request
if (isset($_POST['data'])) {
    // Retrieve data from the POST request
    $receivedData = $_POST['data'];

    // Decode the JSON string to an associative array
    $reservationData = json_decode($receivedData, true);
	$guestId = $reservationData['guestId'];
	$firstName = $reservationData['firstName'];
	$lastName = $reservationData['lastName'];
	$roomNum = $reservationData['roomNum'];
	$checkInDate = $reservationData['checkIn'];
	$checkOutDate = $reservationData['checkOut'];
	$amount = $reservationData['amount'];
    // Now $reservationData contains the reservation details as an associative array
    // You can access individual values like $reservationData['adults'], $reservationData['roomNumber'], etc.

    // Perform any necessary processing or validation here
    // For example, you might want to store the data in a database
    // Respond to the client (optional)
    echo 'Data received successfully.';
	$conn = new mysqli("localhost", "root", "", "hotel_database");
	// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
	
	if (guestId == null) {
		$stmtG = $conn->prepare("INSERT INTO USER (firstName, lastName)	VALUES(?, ?)");
		$stmtG->bind_param("ss", $firstName, $lastName);
		
		if($stmtG->execute()) {
			$sql = "SELECT user_id
					FROM USER
					WHERE first_name = $firstName and last_name = $lastName";
					$conn->query($sql);
					$guestId->bind_result($user_id);
		}
		//$guestId->bind_result($user_id);
		
		$sqc = "INSERT INTO CUSTOMER (customer_id)	VALUE($guestId)";
		$conn->query($sqc);
	}
	$isExist = false;
	while($isExist != true){
	$randomNumber = rand(0, 999999);
	
	$sqr = "SELECT reserve_id
		    FROM RESERVATION_C
			WHERE reserve_id = $randomNumber";
	
	$result = $conn->query($sqr);
            if ($result->num_rows === 0){
               $isExist = false;
            } else {
                $isExist = true;
            }
	}
	$sqe = "INSERT INTO RESERVATION_C (reserve_id, status)	VALUE($randomNumber, 'Confirmed')";
	$conn->query($sqe);
	
	$sqa = "INSERT INTO RESERVATION_A (customer_id, room_number, reserve_id)	VALUE($guestId, $roomNum, $randomNumber)";
	$conn->query($sqa);
	
	$sqb = "INSERT INTO RESERVATION_B (reserve_id, room_number, check_in_date, check_out_date)	VALUE($randomNumber, $roomNum, $checkInDate, $checkOutDate)";
	$conn->query($sqb);
	
	$t = date("Y-m-d H:i:s");
	$sqp = "INSERT INTO PAYMENT (reserve_id, customer_id, amount, payment_date, method)	VALUE($randomNumber, $guestId, $amount, $t, 'Credit Card')";
	
	$conn->close();
	echo
		"<script>
			alert('Payment Successful!');
			window.location.href = 'completeReservation.html';
		</script>";
} else {
    // Handle the case where 'data' parameter is not set
    echo 'Error: Data parameter not set in the request.';
}
?>
