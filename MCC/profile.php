<?php
// Include the session check at the beginning of restricted pages
session_start();

// Check if the user is not logged in or is not an admin or operator
if (!isset($_SESSION['Username']) || ($_SESSION['Level'] != 'Admin' && $_SESSION['Level'] != 'Operator')) {
    header('Location: login.php'); // Redirect to the login page if not authenticated
    exit();
}

include 'connect.php';

$id = 1;

$sql = "Select * from `tbl_user` where userID=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

/* TO FETCH AND UPDATE THE DATA FROM DATABASE - */
$Name = $row['Name']; /*column name in the database */
$Contact = $row['Contact'];
$Username = $row['Username'];
$Password = $row['Password'];
$Email = $row['Email'];
$Address = $row['Address'];
$Profile_image = $row['Profile_image'];

/* TO ADD AND UPDATE THE DATA FROM DATABASE */
if (isset($_POST['submit'])) {
    $Name = $_POST['update_name'];
    $Contact = $_POST['update_contact'];
    $Username = $_POST['update_username'];
    $Password = $_POST['update_password'];
    $Email = $_POST['update_email'];
    $Address = $_POST['update_address'];

    // Handle image upload
    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploaded_image/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image is too large';
        } else {
            $image_update_query = mysqli_query($con, "UPDATE `tbl_user` SET Profile_image = '$update_image' WHERE userID = '$id'") or die('Query failed');
            if ($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
        }
    }

    $sql = "UPDATE `tbl_user` SET Name='$Name', Contact='$Contact', Username='$Username', Password='$Password', Email='$Email', Address='$Address' WHERE userID=$id";

    $result = mysqli_query($con, $sql);

    if ($result) {
        $updateSuccess = true;
    } else {
        die(mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <title>Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>

    <style>
        * {

            list-style: none;
            text-decoration: none;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Noto+Serif+Makasar';
        }

        body {
            background: white;
        }

        .wrapper .sidebar {
            background: rgb(5, 68, 104);
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100%;
            padding: 20px 0;
            transition: all 0.5s ease;
        }

        .wrapper .sidebar .profile {
            margin-bottom: 30px;
            text-align: center;
        }

        .wrapper .sidebar .profile img {
            display: block;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            margin: 0 auto;
        }

        .wrapper .sidebar .profile h3 {
            color: #ffffff;
            margin: 15px 0 5px;
        }

        .wrapper .sidebar .profile p {
            color: rgb(206, 240, 253);
            font-size: 14px;
        }

        .wrapper .sidebar ul li a {
            display: block;
            padding: 13px 30px;
            border-bottom: 1px solid #10558d;
            color: rgb(241, 237, 237);
            font-size: 16px;
            position: relative;
            margin-right: 33px;
            text-decoration: none;
        }

        .wrapper .sidebar ul li a .icon {
            color: #dee4ec;
            width: 30px;
            display: inline-block;
        }

        .wrapper .sidebar ul li a:hover,
        .wrapper .sidebar ul li a.active {
            color: #0c7db1;
            background: white;
            border-right: 2px solid rgb(5, 68, 104);
        }

        .wrapper .sidebar ul li a:hover .icon,
        .wrapper .sidebar ul li a.active .icon {
            color: #0c7db1;
        }

        .wrapper .sidebar ul li a:hover:before,
        .wrapper .sidebar ul li a.active:before {
            display: block;
        }

        .wrapper .section {
            width: calc(100% - 300px);
            margin-left: 300px;
            transition: all 0.5s ease;
        }

        .wrapper .section .top_navbar {
            background: white;
            height: 2px;
            display: flex;
            align-items: center;
            padding: 0 30px;
            margin-top: 20px;
        }

        .wrapper .section .top_navbar .hamburger a {
            font-size: 30px;
            color: black;
        }

        .wrapper .section .top_navbar .hamburger a:hover {
            color: rgb(7, 105, 185);
        }

        body.active .wrapper .sidebar {
            left: -300px;
        }

        body.active .wrapper .section {
            margin-left: 0;
            width: 100%;
        }

       /*admin PROFILE STYLES*/
       .admin_profile {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            margin-bottom: 20px;
            margin-right: 32px;

        }

        .img-admin {
            height: 55px;
            width: 55px;
            border-radius: 50%;
            border: 3px solid transparent;
            /* Set a default border style */
        }


        img {
            height: 50px;
            width: 50px;
            border-radius: 50%;

        }

        /*ADMIN HOME PROFILE STYLES*/
        .Admin-Profile {
            display: flex;
            justify-content: start;
            margin-top: 20px;
            margin-left: 50px;

        }

        .Img-Admin {
            height: 200px;
            width: 200px;
            border-radius: 50%;
            border: 5px solid;
            /* Set a default border style */
            border-color: rgb(0, 255, 38);
        }

        /*FOR ADMIN PROFILE MODAL */
        .container {
            min-height: 50vh;
            background-color: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container .profile {
            padding: 20px;
            box-shadow: var(--box-shadow);
            text-align: center;
            width: 400px;
            border-radius: 5px;

        }

        .container .profile img {
            height: 160px;
            width: 160px;
            border-radius: 50%;
            object-fit: cover;

        }

        .container2 {
            min-height: 40vh;

        }

        .container2 .profile2 {
            box-shadow: var(--box-shadow);

            border-radius: 5px;
        }

        .container2 .profile2 .img2 {
            Display: absolute;
            height: 180px;
            width: 180px;
            margin-left: 140px;
            margin-top: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

       

        /*MAIN CONTENT */

        .main1 {

            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(IMAGES/background2.jpg);
            background-size: cover;
            padding: 2%;
            flex: 1 1 150px;
            margin-top: 20px;
            margin-left: 30px;
            height: 100%;
            padding-left: 30px;
            padding-right: 30px;
           
        }

        header {
            background-color: transparent;
            padding: 2em 0 2em 0;
            padding-bottom: 0px;
        }

        .editProfile_container {
            background-color: #39a8f1;
            padding: 3em 0 3em 0;
            flex: 1 1 100px;
            margin-right: auto;
            text-align: center;


        }



        input {
            width: 20%;
            height: 35px;
            margin-bottom: 20px;
            border-color: #86;
            border-radius: 5px;
        }

        .selector {
            width: 30%;
            height: 35px;
            margin-bottom: 20px;
            border-color: #86;
            border-radius: 5px;
        }

        .newpaint {
            text-align: left;
            margin-left: 45px;
        }

        .operational_btn {
            margin-right: 30px;
        }

        /*FOR PARALLELOGRAM IN ADMIN PROFILE */
        .parallelogram-button {
            display: inline-block;
            padding: 8px 40px;

            text-decoration: none;
            transition: background-color 0.3s;
        }

        .parallelogram-button1 {
            background-color: #39a8f1;
            transform: skew(20deg);
            transform-origin: bottom right;
        }

        .parallelogram-button2 {
            margin-left: 20px;
            background-color: #20da70;
            transform: skew(20deg);
            transform-origin: bottom right;
        }

        .parallelogram-button1:hover {
            background-color: #39a8f1;
        }

        .parallelogram-button2:hover {
            background-color: #20da70;
        }

        .profile-history-btn {
            margin-left: 300px;
        }



        .main2 {
            display: flex;
            flex: 1;
            padding-top: 2%;
            padding-left: 2%;
            padding-right: 2%;
            height: 100%;

        }

        legend {
            text-align: left;
            margin-left: 60px;
            margin-bottom: 40px;
            font-size: 30px;
            color: black;
        }


        /*FOR UPDATE ADMIN PROFILE */
        .form-row label {}

        .form-column {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;

        }

        .form-column label {
            flex: 1;
            margin-right: 10px;
            text-align: right;
        }

        .form-column input {

            width: 15%;
        }


        /*FOR UPDATE SUCCESSFUL */
        /* Customize modal styles */
        .custom-modal .modal-content {
            background-color: green;
            /* Background color */
            color: #fff;
            /* Text  color */
        }

        .custom-modal .modal-header {
            border-bottom: 1px solid #2c3e50;
            /* Border color for the header */
        }

        /*HEADER MODAL OF UPDATE */
        .center-modal-title {
            font-size: 30px;
            margin-left: 175px;
        }

        .custom-modal .modal-footer {
            border-top: 1px solid #2c3e50;
            /* Border color for the footer */
        }


        /* Style for the select option in admin profile */
        .dropdown {
            border: none;
            font-size: 23px;
            width: 6%;
            text-align: center;

        }

        /* Style for the options within the dropdown */
        .dropdown option {
            padding: 10px;
            font-size: 20px;
            text-align: center;
        }

       /* FOR CLOCK */

        .clockcontainer {
            width: 295px;
            height: 180px;
            position: absolute;
            top: 12%;
            left: 80%;
            transform: translate(-50%, -50%);


        }

        .clock {

            color: black;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .clock span {
            font-size: 22px;
            width: 30px;
            display: inline-block;
            text-align: center;
            position: relative;
        }
        #ampm{
            margin-left: 10px;
        }

        /*FOR SYSTEM RESPONSIVE */
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="section">
        <div class="admin_profile">
                <!--FOR CLOCK-->
                <div class="clockcontainer">
                    <div class="clock">
                        <span id="hrs"></span>
                        <span>:</span>
                        <span id="min"></span>
                        <span>:</span>
                        <span id="sec"></span>
                        <span id="ampm"></span>

                    </div>
                </div>

                <img src="uploaded_image/<?php echo $Profile_image; ?>" class="img-admin" id="image">

                <select class="dropdown" required onchange="handleDropdownChange(this)">
                    <option value="admin">
                        <?php echo $Username; ?>
                    </option>
                    <option value="edit_profile">&nbsp;Edit Profile&nbsp;</option>
                    <option value="logout">Logout</option>
                </select>
            </div>

            <div class="top_navbar">
                <div class="hamburger">
                    <a href="#">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>

            <!-- MAIN CONTENT -->

            <div class="main1">
                <header>
                    <div class="Admin-Profile">
                        <img src="uploaded_image/<?php echo $Profile_image; ?>" class="Img-Admin" id="image">
                        <h4 style="margin-left:25px; font-size:40px; color:white; margin-top:80px; text-align:right;">
                            <?php echo $Name; ?>
                        </h4>
                    </div>
                </header>

                <div class="main2">

                    <div class="editProfile_container">
                        <form method="post" enctype="multipart/form-data">
                            <fieldset>
                                <legend>Personal Details</legend>

                                <div class="form-column">
                                    <label style="font-size:20px; color:black;">Name:</label>
                                    <input type="text" class="form-control" name="update_name"
                                        style="text-align: center;" autocomplete="off" value="<?php echo $Name; ?>">

                                    <label style=" font-size:20px; color:black;">Contact No:</label>
                                    <input type="text" class="form-control" name="update_contact"
                                        style="margin-right:20%; text-align: center;" autocomplete="off"
                                        value="<?php echo $Contact; ?>">
                                </div>

                                <div class="form-column">
                                    <label style=" font-size:20px; color:black;">Username:</label>
                                    <input type="text" class="form-control" name="update_username"
                                        style="text-align: center;" autocomplete="off" value="<?php echo $Username; ?>">

                                    <label style=" font-size:20px; color:black;">Password:</label>
                                    <input type="password" class="form-control form-outline" name="update_password"
                                        style="margin-right:20%; text-align: center;" autocomplete="off"
                                        value="<?php echo $Password; ?>">
                                </div>

                                <div class="form-column">
                                    <label style=" font-size:20px; color:black;">Email:</label>
                                    <input type="text" class="form-control" name="update_email"
                                        style="text-align: center;" autocomplete="off" value="<?php echo $Email; ?>">

                                    <label style=" font-size:20px; color:black;">Address:</label>
                                    <input type="text" class="form-control" name="update_address"
                                        style="margin-right:20%; text-align: center;" autocomplete="off"
                                        value="<?php echo $Address; ?>">
                                </div>

                                <div class="form-row">
                                    <label style=" font-size:20px; color:black;">Upload image:&nbsp</label>
                                    <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png"
                                        class="box" style="margin-right:38%;">
                                </div>

                                <br><br>
                                <button type="submit" id="update" name="submit" class="btn btn-primary"
                                    style="font-size:20px;">Save Changes</button>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Top menu -->
            <div class="sidebar">
                <!-- profile image & text -->
                <div class="profile">
                    <img src="IMAGES/logo.jpg" alt="profile_picture">
                    <h3>Mindanao Container Corporation</h3>
                </div>
                <!-- menu item -->
                <ul>
                    <li>
                        <!-- Hidden hyperlink -->
                        <a href="hidden_profile.php" style="display:none;">Hidden Link</a>
                    </li>
                    <li>
                        <a href="profile.php" style="display:none;">
                            <span class="icon"><i class="fa-solid fa-user"></i></span>
                            <span class="item">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="dataEntry.php">
                        <span class="icon"><i class="fa-solid fa-table-cells-large"></i></span>
                            <span class="item">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="volume.php">
                        <span class="icon"><i class="fa-solid fa-flask-vial"></i></span>
                            <span class="item">Volume</span>
                        </a>
                    </li>
                    <li>
                        <a href="monitoring.php">
                        <span class="icon"><i class="fa-solid fa-chart-column"></i></span>
                            <span class="item">Monitoring</span>
                        </a>
                    </li>

                </ul>

            </div>
        </div>

    </div>

    <!-- UPDATE SUCCESS Modal -->
    <div class="modal fade custom-modal" id="updateSuccessModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title center-modal-title" id="exampleModalLabel">Congrats!!!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 style="text-align:center;">Your profile has been updated successfully!</h5>
                </div>
                <div class="modal-footer">
                    <a href="profile.php" class="btn btn-primary">OK</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Clickable image modal -->
    <div class="modal fade" id="clickable_image" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="profile">
                            <div class="admin_modal">
                                <a href="#" id="image">
                                    <img src="uploaded_image/<?php echo $Profile_image; ?>">
                                </a>
                            </div>

                            <h1 style="margin-top:20px;">
                                <?php echo $Name; ?>
                            </h1>

                            <div id="update_profile">
                                <a href="profile.php"><button class="btn btn-primary btn-lg" name="update_profile"
                                        style="font-size:25px; margin-top:20px;">Update profile</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOR clickable image dropdown -->
    <script>
        function handleDropdownChange(select) {
            var selectedValue = select.value;

            if (selectedValue === "edit_profile") {
                // Redirect to the edit profile page
                window.location.href = "profile.php"; // Change the URL accordingly
            } else if (selectedValue === "logout") {
                // Redirect to the logout page
                window.location.href = "logout.php"; // Change the URL accordingly
            }
        }
    </script>

    <!--FOR CLOCK SCRIPT-->
    <script>
        let hrs = document.getElementById("hrs");
        let min = document.getElementById("min");
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
            min.innerHTML = (currentTime.getMinutes() < 10 ? "0" : '') + currentTime.getMinutes();
            sec.innerHTML = (currentTime.getSeconds() < 10 ? "0" : '') + currentTime.getSeconds();
            ampm.innerHTML = period;
        }, 1000)
    </script>

    <!-- FOR SIDEBAR -->
    <script>
        var hamburger = document.querySelector(".hamburger");
        hamburger.addEventListener("click", function () {
            document.querySelector("body").classList.toggle("active");
        })
    </script>

    <!-- Check if the update was successful and trigger the modal -->
    <?php if (isset($updateSuccess) && $updateSuccess): ?>
        <script>
            $(document).ready(function () {
                $('#updateSuccessModal').modal('show');
            });
        </script>
    <?php endif; ?>

</body>

</html>