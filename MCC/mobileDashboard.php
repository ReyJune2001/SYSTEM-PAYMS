<?php
// Include the session check at the beginning of restricted pages
session_start();

// Check if the user is not logged in or is not an admin or operator
if (!isset ($_SESSION['Username']) || ($_SESSION['Level'] != 'Admin' && $_SESSION['Level'] != 'Operator')) {
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
                width: 50%;
                height: 300px;
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

            .xbox4 {
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
                margin-top: 70px;
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
            </div>
            <div class="xbox2 box2">
                <h1 class="morning" style="margin-bottom:10px;">Good Morning, <span
                        style="font-size:25px;font-weight: bold;">
                        <?php echo $Name; ?>
                    </span></h1>
                <!-- Date -->

                <h2 style="font-size:10px;">
                    <?php echo date("l, F j, Y"); ?>
                </h2>
                <!--FOR CLOCK-->

                <div class="clock">
                    <span id="hrs"></span>
                    <span>:</span>
                    <span id="minutes"></span>
                    <span>:</span>
                    <span id="sec"></span>
                    <span id="ampm"></span>

                </div>

            </div>
        </div>
        <div class="M-container">
            <div class="xbox3 box3">
            </div>
            <div class="xbox4 box4">
            </div>
        </div>
        <div class="button-container">
            <a href="mobileDataEntry.php" style="text-decoration: none; color: inherit; width:80%;">
                <button type="button" class="btn btn-success" style="font-size:25px; margin-top: 15px; width:100%;">
                    Data Entry
                </button>
            </a>
        </div>
    </main>
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