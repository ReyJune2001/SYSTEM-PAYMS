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
$newPaintL = isset($_POST['NewpaintL']) ? $_POST['NewpaintL'] : 0;
$newAcetateL = isset($_POST['NewacetateL']) ? $_POST['NewacetateL'] : 0;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
$diameter = isset($_POST['diameter']) ? $_POST['diameter'] : 0;
$height = isset($_POST['height']) ? $_POST['height'] : 0;
$paintRatio = isset($_POST['paintRatio']) ? $_POST['paintRatio'] : 0;
$acetateRatio = isset($_POST['acetateRatio']) ? $_POST['acetateRatio'] : 0;
$Endingdiameter = isset($_POST['Endingdiameter']) ? $_POST['Endingdiameter'] : 0;
$Endingheight = isset($_POST['Endingheight']) ? $_POST['Endingheight'] : 0;
$EndingpaintRatio = isset($_POST['EndingpaintRatio']) ? $_POST['EndingpaintRatio'] : 0;
$EndingacetateRatio = isset($_POST['EndingacetateRatio']) ? $_POST['EndingacetateRatio'] : 0;

// Fetch the initialALiter,endingALiter,initialPLiter,endingPLiter,values from the database
$sql = "SELECT initialALiter, endingALiter, initialPLiter, endingPLiter, Initialvolume, Endingvolume FROM tbl_entry";
$result = mysqli_query($con, $sql);

// Check if the query was successful
if (!$result) {
    // Handle database query error
    echo json_encode(['error' => 'Failed to fetch data from the database']);
    exit;
}

// Fetch the row with containing values
$row = mysqli_fetch_assoc($result);

// Extract values from the fetched row
$initialALiter = $row['initialALiter'];
$endingALiter = $row['endingALiter'];
$initialPLiter = $row['initialPLiter'];
$endingPLiter = $row['endingPLiter'];
$Initialvolume = $row['Initialvolume'];
$pi = 3.1416;
$conversionFactor = 0.0163871;
$Endingvolume = $row['Endingvolume'];


// Calculate initial volume
$Initialvolume = ($pi * $diameter * $diameter * $height * $conversionFactor) / 4;
// Round off the volume to the nearest hundredth
$roundedVolume = round($Initialvolume, 2);

// Calculate Ending volume
$Endingvolume = ($pi * $Endingdiameter * $Endingdiameter * $Endingheight * $conversionFactor) / 4;
// Round off the volume to the nearest hundredth
$roundedEndVolume = round($Endingvolume, 2);

// Calculate Initial Paint Liter
$initialPLiter = ($roundedVolume * $paintRatio);
$roundedPLiter = round($initialPLiter, 2);

// Calculate Ending Paint Liter
$endingPLiter = ($roundedEndVolume * $EndingpaintRatio);
$roundedEndPLiter = round($endingPLiter, 2);


 // Calculate Initial Acetate Liter
 $initialALiter = ($roundedVolume * $acetateRatio);
 $roundedALiter = round($initialALiter, 2);

// Calculate Ending Paint Liter
$endingALiter = ($roundedEndVolume * $EndingacetateRatio);
$roundedEndALiter = round($endingALiter, 2);


// Calculate total Acetate Liter
$totalALiter = $initialALiter + $newAcetateL - $endingALiter;
// Round off the total Acetate Liter to the nearest hundredth
$roundedTotalALiter = round($totalALiter, 2);

// Calculate total Paint Liter
$totalPLiter = $initialPLiter + $newPaintL - $endingPLiter;
// Round off the total Paint Liter to the nearest hundredth
$roundedTotalPLiter = round($totalPLiter, 2);


// Calculate the Acetate Yield when the value of diameter,Endingdiamter, height, Endingheight, paint ratio, EndingpaintRatio, acetate ratio and EndingacetateRatio is change
if ($diameter != 0 && $height != 0 && $paintRatio != 0 && $acetateRatio != 0 && $roundedVolume != 0) {
    $acetateYield = $roundedALiter + $newAcetateL - $roundedALiter / $quantity;
    // Round off the Acetate Yield to the nearest hundredth
    $roundedAcetateYield = round($acetateYield, 2);
} else {
    $roundedAcetateYield = 0; // Handle division by zero scenario
}

// Calculate the Paint Yield when the value of diameter,Endingdiamter, height, Endingheight, paint ratio, EndingpaintRatio, acetate ratio and EndingacetateRatio is change
if ($diameter != 0 && $height != 0 && $paintRatio != 0 && $acetateRatio != 0 && $roundedVolume != 0) {
    $paintYield = $roundedPLiter + $newPaintL - $roundedPLiter / $quantity;
    // Round off the Acetate Yield to the nearest hundredth
    $roundedPaintYield = round($paintYield, 2);
} else {
    $roundedPaintYield = 0; // Handle division by zero scenario
}


// Calculate the Acetate Yield
if ($quantity != 0 && $roundedTotalALiter != 0) {
    $acetateYield = $quantity / $roundedTotalALiter;
    // Round off the Acetate Yield to the nearest hundredth
    $roundedAcetateYield = round($acetateYield, 2);
} else {
    $roundedAcetateYield = 0; // Handle division by zero scenario
}

// Calculate the Paint Yield
if ($quantity != 0 && $roundedTotalPLiter != 0) {
    $paintYield = $quantity / $roundedTotalPLiter;
    // Round off the Paint Yield to the nearest hundredth
    $roundedPaintYield = round($paintYield, 2);
} else {
    $roundedPaintYield = 0; // Handle division by zero scenario
}

// Return the calculated Acetate and Paint Yields as JSON
echo json_encode(['acetateYield' => $roundedAcetateYield, 'paintYield' => $roundedPaintYield]);


?>
