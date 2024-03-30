<?php

include('connect.php');

// SQL query to fetch the data
$sql = "SELECT SUM(quantity) AS totalPaintDrum, DATE_FORMAT(date, '%Y-%m') AS month_year FROM tbl_entry GROUP BY month_year";
$result = mysqli_query($con, $sql);

$data = array();

// Fetch data from the result set
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($con);

// Return data as JSON
echo json_encode($data);
?>
