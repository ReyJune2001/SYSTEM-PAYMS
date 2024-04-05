<?php
// Include the session check at the beginning of restricted pages
session_start();

// Check if the user is not logged in or is not an admin or operator
if (!isset($_SESSION['Username']) || ($_SESSION['Level'] != 'Admin' && $_SESSION['Level'] != 'Operator')) {
    header('Location:mobileLogin.php'); // Redirect to the login page if not authenticated
    exit();
}

include 'connect.php';

$id = 2;

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
    <link rel="icon" href="IMAGES/faviconlogo.png" type="image/x-icon">
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
                left: 16px;
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

            #image1 {
                width: 45px;
                height: 45px;
                margin-left: 60px;
            }

            #image2 {
                width: 120px;
                height: 120px;
                border-radius: 50%;

            }


            .header {
                margin-left: 140px;

            }

            main {
                padding-left: 15px;
                padding-right: 15px;
                padding-bottom: 20px;
                height: 100%;
                margin-top: 20px;
            }

            .container {
                display: flex;

                /* Boxes will be arranged horizontally */

                /* Center vertically on the cross axis */
                height: 100%;
                /* Full viewport height */
                background-color: rgb(178, 178, 193);

            }

            .mainHeader {
                text-align: center;
                padding-top: 20px;
                padding-bottom: 10px;
                color: black;
                font-size: 18px;
                background-color: rgb(178, 178, 193);
            }

            .name {
                margin: 0;
                /* Remove default margin */
                font-size: 20px;
                text-align: right;
                margin-left: 8px;
            }

            .mainform {
                background-color: rgb(178, 178, 193);
                padding: 10px;
            }

            .Profile {
                display: flex;
                align-items: center;
                /* Align items vertically in the same line */

            }

            h2 {
                text-align: left;
                margin-bottom: 20px;
                font-size: 20px;
                color: black;
            }



            .editProfile_container {
                background-color: rgb(178, 178, 193);
                padding-top: 10px;
                padding-bottom: 10px margin-right: auto;
                text-align: center;


            }

            .form-group {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
                /* Adjust as needed */
                left: 5px;
                /* Set left property to 0 pixels */
            }

            input {
                width: 70%;
                height: 30px;
                border-radius: 20px;
            }

            /*FOR UPDATE SUCCESSFUL */
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
            PROFILE
            <img src="uploaded_image/<?php echo $Profile_image; ?>" class="img-admin" id="image1">

            <select class="dropdown" id="dropdown" required onchange="handleDropdownChange(this)">
                <option value="admin">
                    <?php echo $Username; ?>
                </option>
                <option value="recent_activity">Recent Activity</option>
                <option value="logout">Logout</option>
            </select>
        </div>
    </header>
    <main>
        <header class="mainHeader">
            <div class="container">
                <div class="Profile">
                    <img src="uploaded_image/<?php echo $Profile_image; ?>" class="Img-Admin2" id="image2">
                    <input type="text" class="name"
                        style="width:60%; height:40px; font-size:20px; border:none; text-align:center; background-color:rgb(178, 178, 193);"
                        value="<?php echo $Name; ?>" readonly>

                </div>
            </div>
        </header>
        <div class="mainform">
            <div class="editProfile_container">
                <form method="post" enctype="multipart/form-data">
                    <h2>Personal Details</h2>
                    <fieldset>

                        <div class="form-group">
                            <label for="update_name">Name:</label>
                            <input type="text" id="update_name" name="update_name"
                                style="text-align: center;margin-left:44px;" autocomplete="off"
                                value="<?php echo $Name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="update_contact">Contact No:</label>
                            <input type="text" id="update_contact" name="update_contact"
                                style="text-align: center;margin-left:6px;" autocomplete="off"
                                value="<?php echo $Contact; ?>">
                        </div>
                        <div class="form-group">
                            <label for="update_username">Username:</label>
                            <input type="text" id="update_username" name="update_username"
                                style="text-align: center; margin-left:14px;" autocomplete="off"
                                value="<?php echo $Username; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="update_password">Password:</label>
                            <input type="password" id="update_password" name="update_password"
                                style="text-align: center; margin-left:16px;" autocomplete="off"
                                value="<?php echo $Password; ?>">
                        </div>
                        <div class="form-group">
                            <label for="update_email">Email:</label>
                            <input type="text" id="update_email" name="update_email"
                                style="text-align: center;margin-left:47px;" autocomplete="off"
                                value="<?php echo $Email; ?>">
                        </div>
                        <div class="form-group">
                            <label for="update_address">Address:</label>
                            <input type="text" id="update_address" name="update_address"
                                style="text-align: center;margin-left:28px;" autocomplete="off"
                                value="<?php echo $Address; ?>">
                        </div>
                        <div class="form-group">
                            <label for="update_image">Upload image:&nbsp;</label>
                            <input type="file" id="update_image" style="width:50%; margin-left:20px;"
                                name="update_image" accept="image/jpg, image/jpeg, image/png">
                        </div>

                        <br>
                        <button type="submit" id="update" name="submit" class="btn btn-primary"
                            style="font-size:15px; margin-bottom:5px;">Save Changes</button><br>
                        <a href="mobileDashboard.php"><button type="button" class="btn btn-danger"
                                style="font-size:15px; margin-bottom:5px; width:120px;">Back</button></a>
                    </fieldset>
                </form>

            </div>
        </div>

    </main>
    <!-- UPDATE SUCCESS Modal -->
    <div class="modal fade custom-modal" id="updateSuccessModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 style="text-align:center;">Your profile has been updated successfully!</h5>
                </div>
                <div class="modal-footer">
                    <a href="mobileProfile.php" class="btn btn-primary">OK</a>
                </div>
            </div>
        </div>
    </div>

    <!-- FOR clickable image dropdown SCRIPT-->
    <script>
        function handleDropdownChange(select) {
            var selectedValue = select.value;

           if (selectedValue === "recent_activity") {
                // Redirect to the logout page
                window.location.href = "recentActivity.php"; // Change the URL accordingly
            }
            else if (selectedValue === "mobileLogout") {
                // Redirect to the logout page
                window.location.href = "mobileLogout.php"; // Change the URL accordingly
            }
        }
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