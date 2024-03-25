<?php
// Include the session check at the beginning of restricted pages
session_start();

// Check if the user is not logged in or is not an admin or operator
if (!isset ($_SESSION['Username']) || ($_SESSION['Level'] != 'Admin' && $_SESSION['Level'] != 'Operator')) {
    header('Location: login.php'); // Redirect to the login page if not authenticated
    exit();
}

include 'connect.php';

$id = 1;

$sql = "Select * from `tbl_user` where userID=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

/*TO FETCH THE DATA FROM DATABASE - */
$Name = $row['Name']; /*column name in the database */
$Username = $row['Username'];
$Profile_image = $row['Profile_image'];

//FOR FETCHING DATA FROM DATABASE

// Fetch and check the data from the database using a JOIN query
$sql = "SELECT
paint.paint_color,
supplier.supplier_name, supplier.newSupplier_name,
customer.customer_name,
entry.*
FROM tbl_entry AS entry
LEFT JOIN tbl_paint AS paint ON entry.paintID = paint.paintID
LEFT JOIN tbl_supplier AS supplier ON paint.supplierID = supplier.supplierID
LEFT JOIN tbl_customer AS customer ON entry.customerID = customer.customerID
ORDER BY
entry.EntryID DESC,
paint.paintID DESC,
supplier.supplierID DESC,
customer.customerID DESC";

$result = mysqli_query($con, $sql);

if (!$result) {
    die (mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- Bootstrap Multiselect CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

    <!-- MULTI-SELECT CSS to hide columns -->
    <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.css">

    <title>Paint-Acetate Yield Monitoring</title>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Bootstrap Multiselect JS -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>

    <!-- MULTI-SELECT JS to hide columns -->
    <script src="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.js"></script>


    <script>
        // Check if the drawer is initially open
        document.addEventListener("DOMContentLoaded", function () {
            var drawer = document.getElementById('drawer');
            var drawerToggle = document.getElementById('drawerToggle');

            // Check if drawer is currently open
            if (drawer.classList.contains('open')) {
                // If open, close it
                drawer.classList.remove('open');
                drawerToggle.classList.remove('fa-angles-right');
                drawerToggle.classList.add('fa-angles-left');
            } else {
                // If closed, open it
                drawer.classList.add('open');
                drawerToggle.classList.remove('fa-angles-left');
                drawerToggle.classList.add('fa-angles-right');
            }
        });

        function toggleDrawer() {
            var drawer = document.getElementById('drawer');
            var drawerToggle = document.getElementById('drawerToggle');
            drawer.classList.toggle('open');
            drawerToggle.classList.toggle('fa-angles-left');
            drawerToggle.classList.toggle('fa-angles-right');
        }
    </script>
    <style>
        * {

            list-style: none;
            text-decoration: none;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Noto+Serif+Makasar';
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

        /* Set initial styles for the sidebar and section */
        body .wrapper .sidebar {
            left: 0;
            transition: left 0.5s ease;
            /* Add a transition for smooth animation */
        }

        body .wrapper .section {
            margin-left: 300px;
            transition: margin-left 0.5s ease, width 0.5s ease;
            /* Add transitions for smooth animation */
            width: calc(100% - 300px);
        }

        /* Apply styles when body has the 'active' class */
        body.active .wrapper .sidebar {
            left: -300px;
        }

        body.active .wrapper .section {
            margin-left: 0;
            width: 100%;
        }

        /*USER PROFILE STYLES*/
        .admin_profile {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            margin-right: 32px;

        }

        .img-admin {
            height: 55px;
            width: 55px;
            border-radius: 50%;
            border: 3px solid transparent;
            /* Set a default border style */
        }

        .img-admin:hover {
            border-color: blue;
            /* Change the border color to red on hover */

        }


        img {
            height: 50px;
            width: 50px;
            border-radius: 50%;

        }

        /*USER HOME PROFILE STYLES*/
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

        /*FOR UPDATE MODAL */

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

        /*FOR UPDATE PROFILE */
        .update-profile form .flex {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 15px;
        }

        .update-profile form .flex .inputBox {
            width: 50%;
            margin-top: 20px;
        }

        .update-profile form .flex .inputBox span {
            text-align: left;
            display: block;
            margin-top: 15px;
            font-size: 17px;
            color: var(--black);
        }

        .update-profile form .flex .inputBox .box {
            width: 100%;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 17px;
            color: var(--black);
            margin-top: 10px;
        }

        /*FOR VOLUME TABLE CONTENT */


        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;

            color: black;
        }

        .date-cell {
            white-space: nowrap;
        }

        .paint-color-cell {
            white-space: nowrap;
        }

        /*FOR TABLE CONTAINER */


        .container3,
        .container3-fluid,
        .container3-lg,
        .container3-md,
        .container3-sm,
        .container3-xl,
        .container3-xxl {
            --bs-gutter-x: 3.9rem;
            --bs-gutter-y: 0;
            width: 100%;
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5);
            margin-top: 15px;
            margin-right: auto;
            margin-left: auto;
            background-color: rgb(225, 225, 212);

        }

        .editProfile_container {
            background-color: #3498db;
            padding: 3em 0 3em 0;
            flex: 1 1 100px;
            margin-right: auto;
            text-align: center;

        }




        label {
            text-align: center;


        }

        input {
            width: 30%;
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
            background-color: #3498db;
            transform: skew(20deg);
            transform-origin: bottom right;
        }

        .parallelogram-button2 {
            margin-left: 20px;
            background-color: #2ecc71;
            transform: skew(20deg);
            transform-origin: bottom right;
        }

        .parallelogram-button1:hover {
            background-color: #2980b9;
        }

        .parallelogram-button2:hover {
            background-color: #27ae60;
        }

        .profile-history-btn {
            margin-left: 300px;
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


        /*MAIN CONTENT */

        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }

        .main1 {
            background-color: rgb(225, 225, 212);
            padding: 2%;
            flex: 1 1 150px;
            margin-top: 20px;
            margin-left: 30px;
        }

        .main2 {
            display: flex;
            flex: 1;
        }

        /* FOR SEARCH BAR */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 5px;
            background-color: white;
            margin-left: 3px;
        }

        /* FOR SEARCH BAR */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding-bottom: 19px;
            padding-top: 19px;
            width: 154px;

            background-color: white;
            margin-left: 10px;


        }

        /*FOR FILTER BAR */
        .filterfield {
            width: 150px;
            height: 40px;
            margin-left: 2%;
            background-color: white;
            border-color: #86b7fe;
            border-radius: 5px;

        }

        /*FOR EXPORT BUTTONS */
        div.dt-buttons>.dt-button,
        div.dt-buttons>div.dt-button-split .dt-button {
            position: relative;
            display: inline-block;
            box-sizing: border-box;
            margin-left: .167em;
            margin-right: .167em;
            margin-bottom: .333em;
            padding: .5em 1em;
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 2px;
            cursor: pointer;
            font-size: .88em;
            line-height: 1.6em;
            color: black;
            white-space: nowrap;
            overflow: hidden;
            background: white;
            transition: background-color 0.3s;
            /* Add transition for smooth hover effect */
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

        #ampm {
            margin-left: 10px;
        }

        /*FOR MULTIPLE SELECT*/
        span.placeholder {
            display: none;
        }

        /* Adjust the size of checkboxes */
        input[type="checkbox"] {
            width: 15px;
            /* Set the width */
            height: 15px;
            /* Set the height */

        }

        .ms-select-all label span,
        li label span {
            display: inline-block;
            width: 100px;
            /* Adjust width as needed */
            text-align: left;

        }

        button.ms-choice {
            height: 28px;
        }

        /* Adjust the show up in delete modal*/

        #deletemodal {
            top: 30%;
            /* Adjust this value as needed */
            transform: translateY(-50%, -50%);
            height: 50%;
        }

        /*for collapsible drawer */
        /* Custom styles for collapsible drawer */
        #drawer.drawer.p-2 {
            margin-top: 207px;

        }

        .drawer {
            position: absolute;
            right: 35px;
            /* Adjusted position to move drawer closer to the middle */
            transform: translateY(-1230px);
            width: 600px;
            height: 330px;
            padding: 20px;
            background-color: rgb(5, 68, 104);
            /* Change this to your desired background color */
            border-left: 1px solid #dee2e6;
            /* Add border for separation */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add shadow for visual effect */
            transition: right 0.3s ease;
        }

        .drawer.open {
            right: 356px;

        }

        .toggle-drawer {
            position: absolute;
            top: 50%;
            right: -52px;
            /* Adjusted position to align with the content */
            transform: translateY(-50%);
            cursor: pointer;
            background-color: rgb(5, 68, 104);
            padding-left: 4px;
            padding-right: 8px;
            padding-top: 10px;
            padding-bottom: 10px;
            color: white;
            font-size: 20px;
            /* Adjust this value to change the size of the caret icon */
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
                        <span id="minutes"></span>
                        <span>:</span>
                        <span id="sec"></span>
                        <span id="ampm"></span>

                    </div>
                </div>

                <img src="uploaded_image/<?php echo $Profile_image; ?>" class="img-admin" id="image">

                <select class="dropdown" required onchange="handleDropdownChange(this)">
                    <option>
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

            <!--MAIN CONTENT-->

            <div class="main1">

                <!--Filter bar-->
                <div class="col-md-8">
                    <div class="form-group">

                        <!--columns to Display-->

                        <label>Show / Hide columns:</label>

                        <select name="toggle_column" id="toggle_column" multiple>
                            <option value="0">User</option>
                            <option value="1">Date</option>
                            <option value="2">Paint Color</option>
                            <option value="3">Supplier</option>
                            <option value="4">Batch Number</option>
                            <option value="5">Initial Paint (L)</option>
                            <option value="6">Initial Acetate (L)</option>
                            <option value="7">New Supplier</option>
                            <option value="8">New Batch No.</option>
                            <option value="9">New Paint (L)</option>
                            <option value="10">New Acetate (L)</option>
                            <option value="11">Spray Viscosity</option>
                            <option value="12">Ending Paint (L)</option>
                            <option value="13">Ending Acetate (L)</option>
                            <option value="14">Total Paint (L)</option>
                            <option value="15">Total Acetate (L)</option>
                            <option value="16">Customer</option>
                            <option value="17">Quantity (Du)</option>
                            <option value="18">Paint Yield</option>
                            <option value="19">Acetate Yield</option>
                            <option value="20">Remarks</option>
                            <option value="21">Operation</option>
                        </select>

                        <label style="margin-left:20%;">From date:</label>
                        <input type="date" style="text-align: center;" class="filterfield" id="min" name="min"
                            autocomplete="off" required>

                        <label style="margin-left:3%;">To date:</label>
                        <input type="date" style="text-align: center;" class="filterfield" id="max" name="max"
                            autocomplete="off" required>

                    </div>
                </div>
                <div class="main2">
                    <table id="datatables" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th colspan="7" style="text-align:center; background-color:rgba(113,187,234,255);">
                                    Initial Inventory
                                </th>
                                <th colspan="5" style="text-align:center; background-color:rgba(188,145,237,255);">New
                                    Paint Mix</th>
                                <th colspan="2" style="text-align:center; background-color:rgba(255,217,110,255);">
                                    Ending Inventory
                                </th>
                                <th colspan="2" style="text-align:center; background-color:rgba(243,94,62,255);">Total
                                    Usage</th>
                                <th colspan="2" style="text-align:center; background-color:rgba(243,94,62,255);">
                                    Production Output
                                </th>
                                <th colspan="2" style="text-align:center; background-color:#007BFF;">Yield</th>


                                <th colspan="2" style="text-align:center;">Remarks & Operation</th>

                            </tr>

                            <tr>
                                <th style="text-align:center; background-color: rgba(113,187,234,255);">User</th>
                                <th style="text-align:center; background-color: rgba(113,187,234,255);">Date</th>
                                <th style="text-align:center; background-color: rgba(113,187,234,255);">Paint Color</th>
                                <th style="text-align:center; background-color: rgba(113,187,234,255);">Supplier</th>
                                <th style="text-align:center; background-color: rgba(113,187,234,255);">Batch Number
                                </th>
                                <th style="text-align:center; background-color: rgba(113,187,234,255);">Paint(L)</th>
                                <th style="text-align:center; background-color: rgba(113,187,234,255);">Acetate(L)</th>

                                <th style="text-align:center; background-color:rgba(188,145,237,255);">Supplier</th>
                                <th style="text-align:center; background-color:rgba(188,145,237,255);">Batch Number</th>
                                <th style="text-align:center; background-color:rgba(188,145,237,255);">Paint(L)</th>
                                <th style="text-align:center; background-color:rgba(188,145,237,255);">Acetate(L)</th>
                                <th style="text-align:center; background-color:rgba(188,145,237,255);">Spray Viscosity
                                </th>

                                <th style="text-align:center; background-color:rgba(255,217,110,255);">Paint(L)</th>
                                <th style="text-align:center; background-color:rgba(255,217,110,255);">Acetate(L)</th>

                                <th style="text-align:center; background-color:rgba(243,94,62,255);">Paint(L)</th>
                                <th style="text-align:center; background-color:rgba(243,94,62,255);">Acetate(L)</th>

                                <th style="text-align:center; background-color:rgba(243,94,62,255);">Customer</th>
                                <th style="text-align:center; background-color:rgba(243,94,62,255);">Quantity(Du)</th>

                                <th style="text-align:center; background-color:#007BFF;">Paint (Du'L)</th>
                                <th style="text-align:center; background-color:#007BFF;">Acetate (Du'L)</th>

                                <th style="text-align:center;">Remarks</th>
                                <th style="text-align:center;">Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through the results and display data in the table
                            

                            while ($row = mysqli_fetch_assoc($result)) {

                                // Extract values from the row
                            
                                $initialPLiter = $row['initialPLiter'];
                                $NewpaintL = $row['NewpaintL'];
                                $endingPLiter = $row['endingPLiter'];
                                $initialALiter = $row['initialALiter'];
                                $NewacetateL = $row['NewacetateL'];
                                $endingALiter = $row['endingALiter'];
                                $quantity = $row['quantity'];


                                // Calculate total Paint Liter
                                $totalPLiter = ($initialPLiter + $NewpaintL - $endingPLiter);
                                // Round off the total Paint Liter to the nearest hundredth
                                $roundedTotalPLiter = round($totalPLiter, 2);
                                // Insert the total Paint Liter value into the database
                                $insertQuery = "UPDATE tbl_entry SET totalPLiter = $roundedTotalPLiter WHERE EntryID = {$row['EntryID']}";
                                mysqli_query($con, $insertQuery);


                                // Calculate total Acetate Liter
                                $totalALiter = ($initialALiter + $NewacetateL - $endingALiter);
                                // Round off the total Acetate Liter to the nearest hundredth
                                $roundedTotalALiter = round($totalALiter, 2);
                                // Insert the total Acetate Liter value into the database
                                $insertQuery = "UPDATE tbl_entry SET totalALiter = $roundedTotalALiter WHERE EntryID = {$row['EntryID']}";
                                mysqli_query($con, $insertQuery);


                                // Calculate the Paint Yield
                                $PaintYield = ($quantity / $roundedTotalPLiter);
                                // Round off the Paint Yield to the nearest hundredth
                                $roundedPaintYield = round($PaintYield, 2);
                                // Insert the Paint Yield value into the database
                                $insertQuery = "UPDATE tbl_entry SET paintYield = $roundedPaintYield WHERE EntryID = {$row['EntryID']}";
                                mysqli_query($con, $insertQuery);

                                // Calculate the Acetate Yield
                                $AcetateYield = ($quantity / $roundedTotalALiter);
                                // Round off the Acetate Yield to the nearest hundredth
                                $roundedAcetateYield = round($AcetateYield, 2);
                                // Insert the Acetate Yield value into the database
                                $insertQuery = "UPDATE tbl_entry SET acetateYield = $roundedAcetateYield WHERE EntryID = {$row['EntryID']}";
                                mysqli_query($con, $insertQuery);


                                echo "<tr class='edit-row' data-entry-id='{$row['EntryID']}' data-date='{$row['date']}' data-paint-color='{$row['paint_color']}' data-supplier-name='{$row['supplier_name']}' data-batch-number='{$row['batchNumber']}' data-new-supplier-name='{$row['newSupplier_name']}' data-new-paint-l='{$row['NewpaintL']}' data-new-acetate-l='{$row['NewacetateL']}' data-spray-viscosity='{$row['sprayViscosity']}' data-customer-name='{$row['customer_name']}' data-quantity='{$row['quantity']}' data-paint-yield='{$row['paintYield']}' data-acetate-yield='{$row['acetateYield']}' data-remarks='{$row['remarks']}'>";
                                echo "<td>$Username</td>";
                                echo "<td class='date-cell'>{$row['date']}</td>";
                                echo "<td>{$row['paint_color']}</td>";
                                echo "<td>{$row['supplier_name']}</td>";
                                echo "<td>{$row['batchNumber']}</td>";
                                echo "<td>{$row['initialPLiter']}</td>";
                                echo "<td>{$row['initialALiter']}</td>";
                                echo "<td>{$row['newSupplier_name']}</td>";
                                echo "<td>202024234</td>";
                                echo "<td>{$row['NewpaintL']}</td>";
                                echo "<td>{$row['NewacetateL']}</td>";
                                echo "<td>{$row['sprayViscosity']}</td>";
                                echo "<td>{$row['endingPLiter']}</td>";
                                echo "<td>{$row['endingALiter']}</td>";
                                echo "<td style='color:blue;'>$roundedTotalPLiter</td>";
                                echo "<td style='color:blue;'>$roundedTotalALiter</td>";
                                echo "<td>{$row['customer_name']}</td>";
                                echo "<td>{$row['quantity']}</td>";
                                echo "<td style='color:blue;'>$roundedPaintYield</td>";
                                echo "<td style='color:blue;'>$roundedAcetateYield</td>";

                                echo "<td>{$row['remarks']}</td>";
                                echo "<td class='crud'><div style='display: flex; gap: 10px;'>
                                <a href='update.php?data-entry-id={$row['EntryID']}'><button class='btn btn-info text-light'>Edit</button></a>
                                <button class='btn btn-danger confirm_dltbtn' data-entry-id='{$row['EntryID']}'>Delete</button>
                </div></td>";
                                // Add more table data based on your columns
                                echo "</tr>";


                                //########################################################################################
                            
                                // Save data from the current row for later use in the modal
                                $id = $row['EntryID'];
                                $date = $row['date'];
                                $paint_color = $row['paint_color'];
                                $supplier_name = $row['supplier_name'];
                                $batchNumber = $row['batchNumber'];
                                $newSupplier_name = $row['newSupplier_name'];
                                $NewpaintL = $row['NewpaintL'];
                                $NewacetateL = $row['NewacetateL'];
                                $sprayViscosity = $row['sprayViscosity'];
                                $customer_name = $row['customer_name'];
                                $quantity = $row['quantity'];
                                $paintYield = $row['paintYield'];
                                $acetateYield = $row['acetateYield'];
                                $remarks = $row['remarks'];



                            }
                            ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Collapsible Drawer -->

                <div class="col-2 position-relative">
                    <div class="drawer p-2" id="drawer">
                        <i class="fa-solid fa-angles-left toggle-drawer" id="drawerToggle" onclick="toggleDrawer()"></i>
                        <h4
                            style="color:white; margin-top: 120px; margin-bottom: 100px; margin-left: 350px; margin-right: 30px;">
                            Drawer Content</h4>
                    </div>
                </div>
            </div>
        </div>

        <!--Top menu -->
        <div class="sidebar">
            <!--profile image & text-->
            <div class="profile">
                <img src="IMAGES/logo.jpg" alt="profile_picture">
                <h3>Mindanao Container Corporation</h3>
                <!--<p>purok-8,Villanueva,Mis or.</p> -->
            </div>
            <!--menu item-->
            <ul>

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
                    <a href="monitoring.php" class="active">
                        <span class="icon"><i class="fa-solid fa-chart-column"></i></span>
                        <span class="item">Monitoring</span>
                    </a>
                </li>

            </ul>

        </div>
    </div>

    </div>


    <!--###################################################################################################-->
    <!-- Delete Modal -->

    <div class="modal" id="deletemodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545; color: white;">
                    <h5 class="modal-title center-modal-title">DELETE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="monitoring-delete.php" method="post">

                    <input type="hidden" name="userID" id="confirm_delete_id">

                    <h4 style="text-align:center;">Are you sure you want to delete it?</h4>


                    <div class="modal-footer">

                        <button type="submit" name="deletedata" class="btn btn-primary">Yes</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            style="color: white">No</button>
                    </div>
                </form>
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
                                <a href="profile.php"><button class="btn btn-primary btn-lg"
                                        style="font-size:25px; margin-top:20px;">Update profile</button></a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <!--DATA TABLES-->
    <script>
    // Function to hide all columns
    function hideAllColumns() {
        for (var i = 0; i < 22; i++) {
            $('#datatables').DataTable().column(i).visible(false);
        }
    }

    // Function to show all columns
    function showAllColumns() {
        for (var i = 0; i < 22; i++) {
            $('#datatables').DataTable().column(i).visible(true);
        }
    }

    $(document).ready(function () {
        // Initialize DataTable
        let table = $('#datatables').DataTable({
            scrollX: true,
            scrollY: true,
            dom: 'Bfrtip',
            buttons: [
                'excel',
               
            ],
            // Set initial sorting order
            order: [[0, 'desc']],
            language: {
                searchPlaceholder: 'Search...' // Set placeholder text for search input
            }
        });

        // Initialize multiple-select plugin
        $('#toggle_column').multipleSelect({
            width: 200,
            onClick: function () {
                var selectedItems = $('#toggle_column').multipleSelect("getSelects");
                hideAllColumns();
                for (var i = 0; i < selectedItems.length; i++) {
                    var s = selectedItems[i];
                    $('#datatables').DataTable().column(s).visible(true);
                }
            },
            onCheckAll: function () {
                showAllColumns();
                $('#datatables').css('width', '100%');
            },
            onUncheckAll: function () {
                hideAllColumns();
            }
        });

        // Event delegation for delete button
        $(document).on('click', '.confirm_dltbtn', function () {
            var userID = $(this).data('entry-id');

            // Assuming you're using Bootstrap modal for delete confirmation
            $('#deletemodal #confirm_delete_id').val(userID);
            $('#deletemodal').modal('show');
        });

        // Custom filtering function which will search data in date column between two values
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            let min = $('#min').val();
            let max = $('#max').val();
            let dateStr = data[1]; // Assuming date is in the second column

            if ((min === "" && max === "") ||
                (min === "" && new Date(dateStr) <= new Date(max)) ||
                (new Date(min) <= new Date(dateStr) && max === "") ||
                (new Date(min) <= new Date(dateStr) && new Date(dateStr) <= new Date(max))) {
                return true;
            }
            return false;
        });

        // Event listener for date input changes
        $('#min, #max').change(function () {
            table.draw();
        });
    });
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



    <!--For delete modal-->
    <script>
        $(document).ready(function () {
            $('.edit-row .confirm_dltbtn').on('click', function () {
                var userID = $(this).closest('.edit-row').data('entry-id');
                $('#deletemodal #confirm_delete_id').val(userID);
                $('#deletemodal').modal('show');
            });
        });
    </script>

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

    <!--FOR SIDEBAR-->
    <script>
        var hamburger = document.querySelector(".hamburger");
        hamburger.addEventListener("click", function () {
            document.querySelector("body").classList.toggle("active");
        })
    </script>

</body>

</html>