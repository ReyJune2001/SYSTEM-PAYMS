<?php
// Include the session check at the beginning of restricted pages
session_start();

// Check if the user is not logged in or is not an admin or operator
if (!isset($_SESSION['Username']) || ($_SESSION['Level'] != 'Admin' && $_SESSION['Level'] != 'Operator')) {
    header('Location: mobileLogin.php'); // Redirect to the login page if not authenticated
    exit();
}

include 'connect.php';

$id = 2;

$sql = "Select * from `tbl_user` where userID=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

/*TO FETCH THE DATA FROM DATABASE - */
$Name = $row['Name']; /*column name in the database */
$Username = $row['Username'];
$Profile_image = $row['Profile_image'];

?>

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

// Prepare SQL query to fetch the latest date
$sql = "SELECT MAX(Date) AS LatestDate FROM tbl_acetatereport";

// Execute SQL query
$result = mysqli_query($con, $sql);

// Check if query execution was successful
if (!$result) {
    // Handle query execution error
    echo json_encode(['error' => 'Failed to fetch data from the database']);
    exit;
}

// Fetch the latest date
$row = mysqli_fetch_assoc($result);
$latestDate = $row['LatestDate'];

// Close database connection
mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="IMAGES/faviconlogo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

    <!-- Bootstrap JavaScript link (popper.js is required) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-LFMJ0oUpaM3ZgZtnlqqA3F7l3Bo0IVwjt/4iz9o3fmmI9AXkFtfIIQcuxp1xZOz0"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JavaScript bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>


    <!-- Load Google Charts API -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <title>Dashboard</title>
    <style>
        * {
            font-family: 'Noto+Serif+Makasar';
        }

        /* Responsive styles */
        @media screen and (max-width: 425px) {

            body {

                background-color: rgb(83, 83, 247);
                /* Ensure the background image fits within the screen dimensions on smaller devices */
                height: 100%;
                /* Ensure the background image covers the entire screen on smaller devices */
            }

            header {
                text-align: center;
                padding: 3px;
                color: black;
                font-size: 18px;
                background-color: rgb(178, 178, 193);

            }

            .img-admin {
                height: 55px;
                width: 55px;
                border-radius: 50%;
                border: 3px solid transparent;
                /* Set a default border style */
            }

            .logo {

                position: absolute;
                top: 10px;
                /* Adjust the top position as needed */
                left: 12px;
                /* Adjust the left position as needed */
                width: 60px;
                height: 30px;
            }

            select#dropdown.dropdown {
                border: none;
                background-color: rgb(178, 178, 193);
                width: 15px;
                height: 25px;
                margin-top: 10px;
                font-size: 10px;
            }

            #image {
                width: 45px;
                height: 45px;
                margin-left: 48px;
            }

            .header {
                margin-left: 120px;

            }

            .M-container {

                display: flex;
                flex-direction: row;
                /* Boxes will be arranged horizontally */
                align-items: center;
                /* Center vertically on the cross axis */

            }

            .xbox1 {
                width: 340px;
                height: 350px;
                margin-top: 20px;
                margin-left: 10px;
                text-align: center;
                border-radius: 15px;
                margin-right: 5px;
            }


            .xbox4 {
                width: 340px;
                height: 140px;
                text-align: center;
                border-radius: 20px;
                margin-left: 10px;

                margin-bottom: 20px;
            }

            .box1 {
                background-color: white;
            }


            .box4 {

                background-image: url('IMAGES/dataentry.png');
                /* Replace 'path/to/your/image.jpg' with the actual path to your image */
                background-size: cover;
                /* Ensures the background image covers the entire box */
                background-repeat: no-repeat;
                /* Prevents the background image from repeating */
                background-position: center;
                /* Centers the background image */
                background-size: 140px;
                background-color: white;
            }



            .button-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
                /* Ensure container spans the full height of <main> */
            }

            .morning {
                font-family: "Pattaya", sans-serif;
                font-size: 10px;
                margin-top: 60px;
            }

            /* FOR CLOCK */
            .clock {
                display: flex;
                align-items: center;
                justify-content: center;

            }

            .clock span {
                font-weight: bold;
                font-size: 10px;
                width: 10px;
                display: inline-block;
                text-align: center;
                position: relative;
            }

            #ampm {
                margin-left: 5px;
            }

            .margin {
                margin-left: 5px;
                margin-right: 5px;
            }

            #pie_chart {
                width: 100%;
                /* Adjust width as needed */
                height: 100%;
                /* Adjust height as needed */
                /* Add any additional styling here */
            }


        }
    </style>
</head>

<body>

    <header>
        <div class="header">
            <!--For Logo-->
            <img src="IMAGES/logo.jpg" alt="Registration Image" width="100" height="40" class="logo">
            DASHBOARD
            <img src="uploaded_image/<?php echo $Profile_image; ?>" class="img-admin" id="image">
            <select class="dropdown" id="dropdown" required onchange="handleDropdownChange(this)">
                <option value="admin">
                    <?php echo $Username; ?>
                </option>
                <option value="edit_profile">Edit Profile</option>
                <option value="recent_activity">Recent Activity</option>
                <option value="mobileLogout">Logout</option>
            </select>
        </div>

    </header>
    <main>
        <div class="M-container">
            <div class="xbox1 box1">
                <!-- Display the latest date in a hidden input field -->
                <label id="latest_date_label" for="latest_date">Latest Date:</label>

                <input type="hidden" id="latest_date" value="<?php echo $latestDate; ?>">
                <input type="date" id="latest_date_input" onchange="fetchChartData()"
                    style="margin-top:10px; margin-left:102px;  text-align:center; width:40%;" class="form-control">
                <div id="pie_chart" style="width: 340px; height: 250px; margin-top:30px;"></div>
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col text-center"> <!-- Added text-center class -->
                <a href="mobileAcetateEntry.php" style="text-decoration: none; color: inherit; width:80%;">
                    <button type="button" class="btn btn-success"
                        style="font-size:15px; margin-bottom: 20px;margin-top: 20px; width:80%;">
                        Acetate Report Entry
                    </button>
                </a>
            </div>
        </div>

        <div class="M-container">
            <div class="xbox4 box4">
                <?php
                include 'connect.php';

                // Check if the date has changed since the last entry
                $lastEntryDate = date("Y-m-d", strtotime("today"));
                $lastResetDate = date("Y-m-d", strtotime("today -1 day"));

                // Reset total entries count if last entry date is different from today's date
                if (!isset($_SESSION['lastResetDate']) || $_SESSION['lastResetDate'] != $lastResetDate) {
                    $_SESSION['lastResetDate'] = $lastResetDate;
                    $sqlReset = "UPDATE tbl_entry SET totalEntries = 0";
                    mysqli_query($con, $sqlReset);
                }

                // Retrieve total entries count for operators
                $sql = "SELECT COUNT(*) AS totalEntries
        FROM tbl_entry AS entry
        INNER JOIN tbl_user AS user ON entry.userID = user.userID
        WHERE user.Username = 'Operator' AND DATE(entry.date) = '$lastEntryDate'";
                $result = mysqli_query($con, $sql);

                // Check for SQL error
                if (!$result) {
                    echo "Error: " . mysqli_error($con);
                }

                // Check if there are any results
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $totalEntries = $row['totalEntries'];
                } else {
                    $totalEntries = 0;
                }
                ?>
                <h6 style="font-size:16px; margin-top:22px;">Total Entries</h6>
                <input type="number"
                    style="width:100px;height:50px;text-align:center; background-color:; font-weight:bold; margin-right:60px; margin-bottom:20px;border:none;font-size:35px;"
                    value="<?php echo $totalEntries; ?>" readonly>
                <a href="mobileDataEntry.php" style="text-decoration: none; color: inherit; width: 80%;">
                    <button type="button" class="btn btn-primary"
                        style=" width: 62px; height:62px; border-radius:50px; margin-top:24px; margin-right:92px;">
                        <i class="fas fa-plus" style="font-size: 40px;margin-left:-1px;"></i>
                        <!-- Correct Font Awesome class -->
                    </button>
                </a>

            </div>

    </main>


    <script>
        // Retrieve the latest date from the hidden input field and display it in the label
        var latestDate = document.getElementById('latest_date').value;
        document.getElementById('latest_date_label').innerText = 'Latest Date: ' + latestDate;

        // Function to fetch initial data when the page loads
        $(document).ready(function () {
            fetchLatestData();
        });

        function fetchLatestData() {
            // Fetch data for the latest date
            fetchChartData();
        }

        function fetchChartData() {
            var selectedDate = document.getElementById('latest_date_input').value || document.getElementById('latest_date').value;
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(function () {
                drawChart(selectedDate);
            });
        }

        function drawChart(selectedDate) {
            // Fetch data from PHP using AJAX
            $.ajax({
                url: 'fetch_data.php',
                dataType: 'json',
                data: { date: selectedDate },
                success: function (data) {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }
                    // Create a DataTable object
                    var dataTable = new google.visualization.DataTable();

                    // Define columns
                    dataTable.addColumn('string', 'Category');
                    dataTable.addColumn('number', 'Value');

                    // Add data rows
                    dataTable.addRows([
                        ['Beginning', parseFloat(data.Beginning)],
                        ['Withdrawal', parseFloat(data.Withdrawal)],
                        ['Product (P) Usage', parseFloat(data.ProductPUsage)],
                        ['Cleaning', parseFloat(data.Cleaning)],
                        ['Remaining', parseFloat(data.Remaining)]
                    ]);

                    // Set chart options
                    var options = {
                        title: 'Data Distribution for ' + selectedDate,
                        is3D: true,
                        titleTextStyle: { fontSize: 12, textAlign: 'center', titlePosition: 'center', marginBottom: 20 }, // Adjust title font size, alignment, and margin bottom
                        slices: {},
                        pieSliceText: 'percentage', // Display percentage in pie slices
                        legend: { position: 'right' }, // Show legend on the right side
                        legendTextStyle: { color: 'black', fontSize: 16 }, // Adjust legend text color and size
                        pieSliceTextStyle: { color: 'black', fontSize: 14 }, // Adjust pie slice text size
                        chartArea: { width: '90%', height: '75%' }, // Adjust pie chart dimensions
                        backgroundColor: '', // Set background color
                        pieSliceText: 'value-and-percentage', // Display value and percentage
                        pieSliceTextStyle: { fontSize: 14 } // Adjust pie slice text size
                    };

                    // Instantiate and draw the pie chart
                    var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
                    chart.draw(dataTable, options);
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    </script>


    <!-- FOR clickable image dropdown SCRIPT-->
    <script>
        function handleDropdownChange(select) {
            var selectedValue = select.value;

            if (selectedValue === "edit_profile") {
                // Redirect to the edit profile page
                window.location.href = "mobileProfile.php"; // Change the URL accordingly
            } else if (selectedValue === "recent_activity") {
                // Redirect to the logout page
                window.location.href = "recentActivity.php"; // Change the URL accordingly
            }
            else if (selectedValue === "mobileLogout") {
                // Redirect to the logout page
                window.location.href = "mobileLogout.php"; // Change the URL accordingly
            }
        }
    </script>

</body>

</html>