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

// Retrieve the values sent via POST
$Date = isset($_POST['Date']) ? $_POST['Date'] : date('Y-m-d');
$Beginning = isset($_POST['Beginning']) ? $_POST['Beginning'] : null;
$Withdrawal = isset($_POST['Withdrawal']) ? $_POST['Withdrawal'] : 0;
$ProductPUsage = isset($_POST['PUsage']) ? $_POST['PUsage'] : 0;
$Cleaning = isset($_POST['Cleaning']) ? $_POST['Cleaning'] : 0;

// Check if Withdrawal field is empty, if so, set it to zero
if ($Withdrawal === '') {
    $Withdrawal = 0;
}

// Calculate Remaining
$Remaining = ($Beginning !== null ? $Beginning : 0) + $Withdrawal - $ProductPUsage - $Cleaning;

// Ensure Remaining is not negative
$Remaining = max(0, $Remaining);

// Prepare and execute SQL query to update remaining value in the database
$updateQuery = "UPDATE tbl_acetatereport SET Remaining = $Remaining WHERE Date = '$Date'";
$result = mysqli_query($con, $updateQuery);

if (!$result) {
    // Handle database update error
    echo json_encode(['error' => 'Failed to update remaining value']);
    exit;
}

// Return the calculated Remaining as JSON
echo json_encode(['Remaining' => $Remaining]);
?>
