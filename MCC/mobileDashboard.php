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
                width: 379px;
                height: 280px;
                margin-top: 20px;
                margin-left: 10px;
                text-align: center;
                border-radius: 20px;
                margin-right: 5px;
            }

            .xbox2 {
                width: 48%;
                height: 300px;
                text-align: center;
                border-radius: 20px;
                margin-right: 11px;
                margin-top: 20px;


            }

            .xbox3 {
                width: 50%;
                height: 200px;
                margin-top: 20px;
                text-align: center;
                border-radius: 20px;
                margin-left: 10px;
            }

            /* CSS to remove bullets from ul and remove underline from anchor elements */
            .xbox3 ul {
                list-style-type: none;
                /* Remove bullets */
                padding: 0;
                /* Remove default padding */
            }

            .xbox3 ul li a {
                text-decoration: none;

                /* Remove underline */
            }

            .xbox5 ul {
                list-style-type: none;
                /* Remove bullets */
                padding: 0;
                /* Remove default padding */
            }

            .xbox5 ul li a {
                text-decoration: none;
                /* Remove underline */
            }

            .recent-activity-list {
                border: none;
                /* Border color */
                padding: 10px;
                /* Add some padding */

            }

            .acetaterecent-activity-list {
                border: 1px solid #ccc;
                border: none;

            }

            li {
                border: 1px solid black;
                border: none;
            }


            .xbox4 {
                width: 48%;
                height: 100px;
                margin-top: 20px;
                text-align: center;
                border-radius: 20px;
                margin-left: 100px;
                margin-right: 11px;
                margin-bottom: 20px;
            }

            .xbox5 {
                width: 48%;
                height: 200px;
                margin-top: 20px;
                text-align: center;
                border-radius: 20px;
                margin-left: 5px;
                margin-right: 11px;
            }

            .box1 {
                background-color: white;
            }


            .box2 {
                background-image: url('IMAGES/naturemorning.jpg');
                /* Replace 'path/to/your/image.jpg' with the actual path to your image */
                background-size: cover;
                /* Ensures the background image covers the entire box */
                background-repeat: no-repeat;
                /* Prevents the background image from repeating */
                background-position: center;
                /* Centers the background image */

                background-color: white;
            }

            .box3 {
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
                background-size: 100px;
                background-color: white;
            }

            .box5 {
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
                <option value="edit_profile">&nbsp;Edit Profile&nbsp;</option>
                <option value="mobileLogout">Logout</option>
            </select>
        </div>

    </header>
    <main>
        <div class="M-container">
            <div class="xbox1 box1">
                <!-- Display the latest date in a hidden input field -->
<input type="hidden" id="latest_date" value="<?php echo $latestDate; ?>">
                <input type="date" id="latest_date_input" onchange="fetchChartData()"
                    style="margin-top:20px; margin-left:112px;  text-align:center; width:40%;" class="form-control">
                <label id="latest_date_label" for="latest_date">Latest Date:</label>
                <div id="pie_chart" style="width: 375px; height: 150px; margin-left:px; margin-top:8px;"></div>
                <a href="mobileAcetateEntry.php" style="text-decoration: none; color: inherit; width:80%;">
                    <button type="button" class="btn btn-success"
                        style="font-size:15px; margin-bottom: 40px; width:80%;">
                        Acetate Report Entry
                    </button>
                </a>

            </div>
            <!--
            <div class="xbox2 box2">
                <h1 class="morning" style="margin-bottom:10px;">Good Morning, <br><span
                        style="font-size:25px;font-weight: bold; text">
                        php echo $Username; ?>
                    </span></h1> 
                Date 

                <h2 style="font-size:10px;">
                    ?php echo date("l, F j, Y"); ?>
                </h2>
                FOR CLOCK--

                <div class="clock">
                    <span id="hrs"></span>
                    <span class="margin">:</span>
                    <span id="minutes"></span>
                    <span class="margin">:</span>
                    <span id="sec"></span>
                    <span id="ampm"></span>

                </div>

            </div>-->
        </div>
        <div class="M-container">
            <div class="xbox3 box3">
                <h5 style="margin-top:5px;">Paint recent activity</h5>
                <ul class="recent-activity-list" style="overflow-y: auto; max-height: 130px; ">
                    <?php
                    include 'connect.php';
                    $sql = "SELECT entry.entryID, entry.date, paint.paint_color 
                            FROM tbl_entry AS entry 
                            LEFT JOIN tbl_paint AS paint ON entry.paintID = paint.paintID
                            WHERE entry.userID IN (SELECT userID FROM tbl_user WHERE Username = 'Operator')
                            ORDER BY entry.date DESC";
                    $result = mysqli_query($con, $sql);

                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($selected = mysqli_fetch_assoc($result)) {
                            // Display an image before each entry
                            echo '<li>';
                            echo '<img src="IMAGES/check.png" alt="Image" style="width: 30px; height: 30px; float: left; margin-left:20px; margin-top:8px;">';
                            // Display each date and paint color as a link to mobileUpdate.php with date as query parameter
                            echo "<button><a href='mobileUpdate.php?entryID={$selected['entryID']}'>{$selected['date']}</a></button>";
                            if (!empty($selected['paint_color'])) {
                                echo "<br> {$selected['paint_color']}";
                            }
                            echo '</li>';
                        }
                    } else {
                        echo "<li>No recent activity</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="xbox5 box5">
                <h5>Acetate recent activity</h5>
                <ul class="acetaterecent-activity-list" style="overflow-y: auto; max-height: 130px; ">
                    <?php
                    include 'connect.php';
                    $sql = "SELECT acetateReport.acetateReportID, acetateReport.Date, acetateReport.Remaining 
                            FROM tbl_acetatereport AS acetateReport 
                            WHERE acetateReport.userID IN (SELECT userID FROM tbl_user WHERE Username = 'Operator')
                            ORDER BY acetateReport.Date DESC";
                    $result = mysqli_query($con, $sql);

                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($selected = mysqli_fetch_assoc($result)) {
                            // Display an image before each entry
                            echo '<li>';
                            echo '<img src="IMAGES/check.png" alt="Image" style="width: 30px; height: 30px; float: left; margin-left:20px; margin-top:8px;">';
                            // Display each date and paint color as a link to mobileUpdate.php with date as query parameter
                            echo "<button><a href='mobileAcetateUpdate.php?acetateReportID={$selected['acetateReportID']}'>{$selected['Date']}</a></button>";
                            if (!empty($selected['Remaining'])) {
                                echo "Remaining: {$selected['Remaining']}";
                            }
                            echo '</li>';
                        }
                    } else {
                        echo "<li>No recent activity</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="M-container">
            <div class="xbox4 box4">
                <?php
                include 'connect.php';
                $sql = "SELECT COUNT(*) AS totalEntries
                FROM tbl_entry AS entry
                INNER JOIN tbl_user AS user ON entry.userID = user.userID
                WHERE user.Username = 'Operator'";
                $result = mysqli_query($con, $sql);

                // Check if there are any results
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $totalEntries = $row['totalEntries'];
                } else {
                    $totalEntries = 0;
                }
                ?>
                <h6>Total Entries</h6>
                <input type="number"
                    style="width:150px;height:20px;margin-top:px;text-align:center; font-weight:bold; background-color:;border:none;font-size:25px;"
                    value="<?php echo $totalEntries; ?>" readonly>

                <a href="mobileDataEntry.php" style="text-decoration: none; color: inherit; width: 80%;">
                    <button type="button" class="btn btn-success"
                        style=" width: 45px; height:45px; border-radius:50px; margin-left:52px;">
                        <i class="fas fa-plus" style="font-size: 30px;margin-left:-3px;"></i>
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
    $(document).ready(function() {
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
            } else if (selectedValue === "mobileLogout") {
                // Redirect to the logout page
                window.location.href = "mobileLogout.php"; // Change the URL accordingly
            }
        }
    </script>

    <!--FOR CLOCK SCRIPT-->
    <script>
        let hrs = document.getElementById("hrs");
        let minutes = document.getElementById("minutes");
        let sec = document.getElementById("sec");
        let ampm = document.getElementById("ampm");

        setInterval(() => {
            let currentTime = new Date();
            let hours = currentTime.getHours();
            let period = "AM";

            if (hours >= 12) {
                period = "PM";
                if (hours > 12) {
                    hours -= 12;
                }
            }

            hrs.innerHTML = (hours < 10 ? "0" : '') + hours;
            minutes.innerHTML = (currentTime.getMinutes() < 10 ? "0" : '') + currentTime.getMinutes();
            sec.innerHTML = (currentTime.getSeconds() < 10 ? "0" : '') + currentTime.getSeconds();
            ampm.innerHTML = period;
        }, 1000)
    </script>
</body>

</html>