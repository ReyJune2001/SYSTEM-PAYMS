<?php
// Database connection parameters
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'dbpayms';

// Establish database connection
$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

// Check if the connection was successful
if (!$con) {
    // Handle database connection error
    echo json_encode(['error' => 'Failed to connect to the database']);
    exit;
}

// Retrieve the date sent via POST
$Date = isset($_POST['Date']) ? $_POST['Date'] : date('Y-m-d');

// Fetch Remaining value for the given date
$selectQuery = "SELECT Remaining FROM tbl_acetatereport WHERE Date = '$Date'";
$result = mysqli_query($con, $selectQuery);

if (!$result) {
    // Handle database query error
    echo json_encode(['error' => 'Failed to fetch Remaining value']);
    exit;
}

$Remaining = 0;
if (mysqli_num_rows($result) > 0) {
    // Fetch the Remaining value if available
    $row = mysqli_fetch_assoc($result);
    $Remaining = $row['Remaining'];
} else {
    // If no record found for the given date, fetch the previous day's Remaining value
    $prevDate = date('Y-m-d', strtotime($Date . ' -1 day'));
    $selectPrevQuery = "SELECT Remaining FROM tbl_acetatereport WHERE Date = '$prevDate'";
    $resultPrev = mysqli_query($con, $selectPrevQuery);
    if ($resultPrev && mysqli_num_rows($resultPrev) > 0) {
        $rowPrev = mysqli_fetch_assoc($resultPrev);
        $Remaining = $rowPrev['Remaining'];
    }
}

// Return the fetched Remaining value as JSON
echo json_encode(['Success' => true, 'Remaining' => $Remaining]);
?>
