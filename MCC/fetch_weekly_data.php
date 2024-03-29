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

// Retrieve the selected month from the request
if(isset($_GET['month'])) {
    $selectedMonth = $_GET['month'];
} else {
    // Default to the current month if month is not provided
    $selectedMonth = date('Y-m');
}

// Construct your SQL query to fetch data for the selected month
$sql = "SELECT 
            CONCAT('Week ', WEEK(date, 1)) AS week_label,
            SUM(paintYield) AS totalPaintYield,
            SUM(acetateYield) AS totalAcetateYield
        FROM 
            tbl_entry 
        WHERE 
            DATE_FORMAT(date, '%Y-%m') = '$selectedMonth' 
        GROUP BY 
            week_label";

$result = mysqli_query($con, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data['weeks'][] = $row['week_label'];
    $data['paintYields'][] = $row['totalPaintYield'];
    $data['acetateYields'][] = $row['totalAcetateYield'];
}

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($data);
?>
