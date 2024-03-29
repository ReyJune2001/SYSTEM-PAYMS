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

// Get the selected date from AJAX request
$selectedDate = mysqli_real_escape_string($con, $_GET['date']);

// Prepare SQL query to fetch data for the selected date
$sql = "SELECT * FROM tbl_acetatereport WHERE Date = '$selectedDate'";

// Execute SQL query
$result = mysqli_query($con, $sql);

// Check if query execution was successful
if (!$result) {
    // Handle query execution error
    echo json_encode(['error' => 'Failed to fetch data from the database']);
    exit;
}

// Fetch the row
$row = mysqli_fetch_assoc($result);

// Close database connection
mysqli_close($con);

// Return the data as JSON
echo json_encode($row);
?>
