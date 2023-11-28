<?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "hotel_database");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // SQL query for Reservation Trends
    //$reservationQuery = ;

    $reservationResult = $conn->query($reservationQuery);

    $reservationData = [];
    while($row = $reservationResult->fetch_assoc()) {
        $reservationData[] = $row;
    }

    // SQL query for Occupancy Rates
    $occupancyQuery = "SELECT DATE_FORMAT(check_in_date, '%Y-%m-%d') AS date, COUNT(room_number) AS room_count 
                       FROM RESERVATION_B 
                       GROUP BY DATE(check_in_date)";

    $occupancyResult = $conn->query($occupancyQuery);

    // Prepare data for Occupancy Rates
    $occupancyData = [];
    while($row = $occupancyResult->fetch_assoc()) {
        $occupancyData[] = $row;
    }

    // SQL query for Revenue
    $revenueQuery = "SELECT DATE_FORMAT(payment_date, '%Y-%m-%d') AS date, SUM(amount) AS total_amount 
                     FROM PAYMENT 
                     GROUP BY DATE(payment_date)";

    $revenueResult = $conn->query($revenueQuery);

    // Prepare data for Revenue
    $revenueData = [];
    while($row = $revenueResult->fetch_assoc()) {
        $revenueData[] = $row;
    }

    // Close connection
    $conn->close();

    // Output data in JSON format
    header('Content-Type: application/json');
    echo json_encode(['occupancy' => $occupancyData, 'revenue' => $revenueData]);
?>
