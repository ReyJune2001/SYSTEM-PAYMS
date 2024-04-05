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



// Fetch and check the data from the database
$sql = "SELECT
acetateReport.*, user.Username
FROM tbl_acetatereport AS acetateReport
LEFT JOIN tbl_user AS user ON acetateReport.userID = user.userID";

$result = mysqli_query($con, $sql);

//FOR INSERT DATA INTO DATABSE

// Initialize variables
$Date = $Beginning = $Withdrawal = $ProductPUsage = $Cleaning = $Remaining = '';

// Process form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $Date = $_POST['Date'];
    $Beginning = $_POST['Beginning'];
    $Withdrawal = $_POST['Withdrawal'];
    $ProductPUsage = $_POST['PUsage'];
    $Cleaning = $_POST['Cleaning'];
    $Remaining = $_POST['Remain'];


    /*Para nga ma-insert ang mga data sa mga tables, kinahanglan
       na mag insert ka nga magkasunod-sunod og foreign key, dependi kong unsay
       una nga table with foreign key */

    // Insert data into tbl_acetatereport table
    $sql = "INSERT INTO `tbl_acetatereport` (userID,Date, Beginning, Withdrawal, ProductPUsage, Cleaning, Remaining) 
            VALUES ('$id','$Date', '$Beginning', '$Withdrawal', '$ProductPUsage', '$Cleaning', '$Remaining')";

    $result = mysqli_query($con, $sql); // Execute SQL query

    // Check if query was successful
    if ($result) {
        $acetateReportID = mysqli_insert_id($con); // Get the acetateReportID of the newly inserted record
        $updateSuccess = true;
    } else {
        die(mysqli_error($con)); // Print error message if query fails
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="IMAGES/faviconlogo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--FOR FONT STYLE-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kalnia:wght@700&family=Noto+Serif+Makasar&family=Pattaya&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kalnia:wght@700&family=Noto+Serif+Makasar&family=Pattaya&family=Tiro+Kannada:ital@0;1&display=swap"
        rel="stylesheet">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <!-- For trend chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <title>Acetate Report Entry</title>
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
                width: 100%;
                height: 550px;
                margin-top: 20px;
                margin-left: 10px;
                text-align: center;
                border-radius: 20px;
                margin-right: 11px;
            }

            .box1 {
                background-color: white;
            }

            .initial {
                display: flex;
                flex: 1;
                padding-top: 2%;
                padding-bottom: 2%;
                height: 100%;
                background-color: #87ceeb;
                margin-bottom: 20px;
                /*#98fb98 */
            }

            .styleform {
                width: 40%;
                height: 35px;
                margin-bottom: 20px;
                border-radius: 5%;
                margin-right: 15px;
                margin-left: 15px;
            }

            .endingstyle {
                width: 45%;
                height: 35px;
                margin-bottom: 20px;
                border-radius: 5%;
                margin-right: 7px;
                margin-left: 6px;
            }

            .initial .form-column {
                width: 100%;
                /* Adjust the width as needed */
                margin: 0 auto;
                /* Center the column horizontally */
                /* Add any other custom styles here */
            }

            .newpaintmix {
                display: flex;
                flex-direction: row;
                /* Boxes will be arranged horizontally */
                justify-content: space-around;
                /* Space evenly distributed along the main axis */
                align-items: center;

            }

            .productionOutput {
                display: flex;
                flex-direction: row;
                /* Boxes will be arranged horizontally */
                justify-content: space-around;
                /* Space evenly distributed along the main axis */
                align-items: center;

            }

            .yield {
                display: flex;
                flex-direction: row;
                /* Boxes will be arranged horizontally */
                justify-content: space-around;
                /* Space evenly distributed along the main axis */
                align-items: center;

            }

            .ending {
                display: flex;
                flex-direction: row;
                /* Boxes will be arranged horizontally */
                justify-content: space-around;
                /* Space evenly distributed along the main axis */
                align-items: center;

            }

            .vertical-line {
                width: 4px;
                /* Adjust the width of the line as needed */
                height: 9vh;
                /* Sets the height to be the full height of the viewport */
                background-color: gray;
                /* Change the color of the line */
                position: absolute;

                left: 50%;
                /* Position the line in the center horizontally */
                transform: translateX(-50%);
                /* Adjusts the position to the center */

            }

            .boxstyle {
                display: flex;
                flex-direction: row;
                /* Boxes will be arranged horizontally */
                justify-content: space-around;
                /* Space evenly distributed along the main axis */
                align-items: center;
                /* Center vertically on the cross axis */



            }

            .mainbox {

                width: 50%;
                height: 64px;
                margin-top: 20px;
                padding-left: -10px;
                text-align: center;
            }

            .boxYield {
                background-color: white;
            }

            .input-yield {
                display: flex;
                flex-direction: row;
                width: 20%;
            }

            .input {
                width: 82px;
                height: 40px;
                text-align: center;
                border: none;
                font-size: 20px;
            }

            input {
                border-color: white;
            }

            /*SUCCESSFUL MODAL */
            /* Customize modal styles */
            .custom-modal .modal-content {
                background-color: #2eae3d;
                /* Background color */
                color: #fff;
                /* Text  color */
            }

            .custom-modal .modal-header {
                border-bottom: 1px solid #2eae3d;
                /* Border color for the header */
            }

            /*HEADER MODAL OF UPDATE */
            .center-modal-title {
                font-size: 30px;
                margin-left: 175px;
            }

            .custom-modal .modal-footer {
                border-top: 1px solid #2eae3d;
                /* Border color for the footer */
            }

        }
    </style>
</head>

<body>

    <header>
        <div class="header">
            <!--For Logo-->
            <img src="IMAGES/logo.jpg" alt="Registration Image" width="100" height="40" class="logo">
            DATA ENTRY
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
                <form method="post">
                    <fieldset>
                        <div class="initial">
                            <div class="form-column">

                                <h5 style="margin-top:20px;">ACETATE MONITORING REPORTS</h5>

                                <br>
                                <div class="form-column" style="text-align:center;">
                                    <label style="margin-left:-36px; margin-right:-10px;">Date:</label>
                                    <input type="date" style="text-align: center;margin-right:20px;" class="styleform"
                                        name="Date" id="reportDate" autocomplete="off" value="<?php echo $Date; ?>"
                                        required> <br>

                                    <label style="margin-left:-77px; margin-right:-10px;">Beginning:</label>
                                    <input type="number" style="text-align: center;" class="styleform"
                                        placeholder="Beginning" id="Beginning" name="Beginning" min="0" step="any"
                                        autocomplete="off" value="<?php echo $Beginning; ?>" required> <br>

                                    <label style="margin-left:-82px; margin-right:-10px;">Withdrawal:</label>
                                    <input type="number" style="text-align: center;" class="styleform"
                                        placeholder="Withdrawal" id="Withdrawal" name="Withdrawal" min="0" step="any"
                                        autocomplete="off" value="<?php echo $Withdrawal; ?>"><br>

                                    <label style="margin-left:-65px; margin-right:-10px;">P - usage:</label>
                                    <input type="number" style="text-align: center;" class="styleform"
                                        placeholder="Production (P) usage" id="PUsage" name="PUsage" min="0" step="any"
                                        autocomplete="off" value="<?php echo $ProductPUsage; ?>" required> <br>

                                    <label style="margin-left:-64px; margin-right:-10px;">Cleaning:</label>
                                    <input type="number" style="text-align: center;" class="styleform"
                                        placeholder="Cleaning" id="Cleaning" name="Cleaning" min="0" step="any"
                                        autocomplete="off" value="<?php echo $Cleaning; ?>" required> <br>
                                    <label style="margin-left:-2px; margin-right:-10px;">Remaining:</label>
                                    <input type="number" style="text-align: center;margin-right:90px;" class="styleform"
                                        id="Remain" name="Remain" min="0" step="any" autocomplete="off"
                                        value="<?php echo $Remaining; ?>">
                                </div>
                                <br><br>
                                <button type="submit" id="update" class="btn btn-primary btn-lg" name="submit"
                                    style="font-size:16px; border-radius:50px; width:50%; height:42px; margin-bottom:10px;">Add</button>
                                <a href="mobileDashboard.php"><button type="button" class="btn btn-danger btn-lg"
                                        style="font-size:16px; border-radius:50px; width:50%; height:42px; margin-bottom:20px;">Back</button></a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </main>

    <!-- ADDED SUCCESS Modal -->
    <div class="modal fade custom-modal" id="updateSuccessModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 style="text-align:center;">Your Entry data has been added successfully!</h5>
                </div>
                <div class="modal-footer">
                    <a href="mobileAcetateEntry.php" class="btn btn-primary">OK</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Check if the update was successful and trigger the modal -->
    <?php if (isset($updateSuccess) && $updateSuccess): ?>
        <script>
            $(document).ready(function () {
                $('#updateSuccessModal').modal('show');
            });
        </script>
    <?php endif; ?>


    <!--FOR ACETATE MONITORING REPOORT CALCULATION-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // On change of the report date, fetch and populate Beginning if available
            document.getElementById('reportDate').addEventListener('change', function () {
                var date = this.value;
                fetchRemainingFromDate(date);
            });

            ['Withdrawal', 'PUsage', 'Cleaning'].forEach(function (fieldName) {
                document.querySelector(`input[name="${fieldName}"]`).addEventListener('input', updateRemaining);
            });
        });

        function fetchRemainingFromDate(date) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_remaining.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.Success) {
                        document.getElementById('Beginning').value = response.Remaining;
                        updateRemaining();
                    }
                }
            };
            xhr.send("Date=" + date);
        }

        function updateRemaining() {
            var formData = new FormData(document.querySelector('form'));
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "acetateReport_calculated.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.querySelector('input[name="Remain"]').value = response.Remaining;
                }
            };
            xhr.send(formData);
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


    <!-- JavaScript to toggle and collapse "Ending Inventory" -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('toggleEndingInventory').addEventListener('click', function () {
                var collapseEndingInventory = new bootstrap.Collapse(document.getElementById('collapseEndingInventory'));
                collapseEndingInventory.toggle();
            });
        });
    </script>
</body>

</html>