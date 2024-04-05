<?php

include 'connect.php';
// Include the session check at the beginning of restricted pages
session_start();

// Check if the user is not logged in or is not an admin or operator
if (!isset($_SESSION['Username']) || ($_SESSION['Level'] != 'Admin' && $_SESSION['Level'] != 'Operator')) {
    header('Location: mobileLogin.php'); // Redirect to the login page if not authenticated
    exit();
}


$id = 2;

$sql = "Select * from `tbl_user` where userID=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

/*TO FETCH THE DATA FROM DATABASE - */
$Name = $row['Name']; /*column name in the database */
$Username = $row['Username'];
$Profile_image = $row['Profile_image'];

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
    <title>Recent Activity</title>
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
                margin-left: 25px;
            }

            .header {
                margin-left: 100px;

            }

            .box5 {
                background-color: white;
            }

            .box3 {
                background-color: white;
            }

            .xbox3 {
                width: 320px;
                height: 215px;
                margin-top: 20px;
                text-align: center;
                border-radius: 15px;

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

            li {
                border: 1px solid black;
                border-left: none;
                border-right: none;
                border-top: none;
            }

            .xbox5 {
                width: 320px;
                height: 215px;
                margin-top: 20px;
                text-align: center;
                border-radius: 15px;
            }

            .M-container {

                display: flex;
                flex-direction: column;
                /* Boxes will be arranged horizontally */
                align-items: center;
                /* Center vertically on the cross axis */

            }

        }
    </style>
</head>

<body>

    <header>
        <div class="header">
            <!--For Logo-->
            <img src="IMAGES/logo.jpg" alt="Registration Image" width="100" height="40" class="logo">
            RECENT ACTIVITY
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
            <div class="row justify-content-center">
                <div class="col">
                    <h6 class="text-center" style="font-size:20px; margin-top: 25px; color:white;">Data Entry recent
                        activity</h6>
                </div>
            </div>

            <div class="xbox3 box3">
                <ul style="overflow-y: auto; max-height: 205px;">
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
                            echo '<img src="IMAGES/check.png" alt="Image" style="width: 40px; height: 40px; float: left; margin-left: 50px; margin-top: 12px;">';
                            // Centered display of paint color and date
                            echo '<div style="text-align: center;">';
                            if (!empty($selected['paint_color'])) {
                                echo "<span>{$selected['paint_color']}</span><br>";
                            }
                            echo "<button style='margin-top: 6px; margin-bottom:10px;'><a href='mobileUpdate.php?entryID={$selected['entryID']}'>{$selected['date']}</a></button>";
                            echo '</div>';
                            echo '</li>';
                        }
                    } else {
                        echo "<li>No recent activity</li>";
                    }
                    ?>
                </ul>
            </div>



            <div class="row justify-content-center">
                <div class="col">
                    <h6 class="text-center" style="font-size:20px; margin-top: 25px; color:white;">Acetate Report recent
                        activity</h6>
                </div>
            </div>
            <div class="xbox5 box5">
                <ul class="acetateRecentList" style="overflow-y: auto; max-height: 190px;">
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
                            echo '<img src="IMAGES/check.png" alt="Image" style="width: 40px; height: 40px; float: left; margin-left:50px; margin-top:12px;">';
                            // Centered display of Remaining and date
                            echo '<div style="text-align: center;">';
                            echo "<span style='margin-left:-30px;'>Remaining: {$selected['Remaining']}</span>";
                            if (!empty($selected['Remaining'])) {
                                echo "<h6 style='margin-top: 12px;padding-left:80px; margin-right:30px;'>{$selected['Date']}</h6>";
                            }
                            echo '</div>';
                            echo '</li>';
                        }
                    } else {
                        echo "<li>No recent activity</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </main>
    <footer style="display: flex; justify-content: center;">
        <a href="mobileDashboard.php">
            <button type="button" class="btn btn-danger btn-lg"
                style="font-size: 16px;  width: 150px; height: 42px; margin-top: 20px; margin-bottom: 20px;">Back</button>
        </a>
    </footer>
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