<!--FOR ADMIN PROFILE-->
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

/*TO FETCH THE DATA FROM DATABASE - */
$Name = $row['Name']; /*column name in the database */
$Username = $row['Username'];
$Profile_image = $row['Profile_image'];



if (isset($_GET['data-entry-id'])) {
    $id = $_GET['data-entry-id'];
    // Fetch the data corresponding to the entry ID

    $sql = "SELECT
                paint.paint_color,
                supplier.supplier_name, supplier.newSupplier_name,
                customer.customer_name,
                entry.*, user.Username
            FROM tbl_entry AS entry
            LEFT JOIN tbl_paint AS paint ON entry.paintID = paint.paintID
            LEFT JOIN tbl_supplier AS supplier ON paint.supplierID = supplier.supplierID
            LEFT JOIN tbl_customer AS customer ON entry.customerID = customer.customerID
            LEFT JOIN tbl_user AS user ON entry.userID = user.userID
            WHERE entry.EntryID = $id";

    $result = mysqli_query($con, $sql);

    // Check if the query was successful
    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Populate variables with fetched data
        $date = $row['date'];
        $paint_color = $row['paint_color'];
        $supplier_name = $row['supplier_name'];
        $batchNumber = $row['batchNumber'];
        $diameter = $row['diameter'];
        $height = $row['height'];
        $paintRatio = $row['paintRatio'];
        $acetateRatio = $row['acetateRatio'];
        $Endingdiameter = $row['Endingdiameter'];
        $Endingheight = $row['Endingheight'];
        $EndingpaintRatio = $row['EndingpaintRatio'];
        $EndingacetateRatio = $row['EndingacetateRatio'];
        $newSupplier_name = $row['newSupplier_name'];
        $NewpaintL = $row['NewpaintL'];
        $NewacetateL = $row['NewacetateL'];
        $sprayViscosity = $row['sprayViscosity'];
        $customer_name = $row['customer_name'];
        $quantity = $row['quantity'];
        $paintYield = $row['paintYield'];
        $acetateYield = $row['acetateYield'];
        $remarks = $row['remarks'];
    } else {
        // Handle error if query fails
        echo "Error fetching data: " . mysqli_error($con);
    }
}


//FOR INSERT DATA INTO DATABSE

$date = $paint_color = $supplier_name = $batchNumber = $diameter = $height = $paintRatio = $acetateRatio = $newSupplier_name =
    $NewacetateL = $NewpaintL = $sprayViscosity = $customer_name = $quantity = $Endingdiameter = $Endingheight =
    $EndingpaintRatio = $EndingacetateRatio = $paintYield = $acetateYield = $remarks = $supplierID = '';

if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $paint_color = $_POST['paint_color'];
    $supplier_name = $_POST['supplier_name'];
    $batchNumber = $_POST['batchNumber'];
    $diameter = $_POST['diameter'];
    $height = $_POST['height'];
    $paintRatio = $_POST['paintRatio'];
    $acetateRatio = $_POST['acetateRatio'];
    $newSupplier_name = $_POST['newSupplier_name'];
    $NewacetateL = isset($_POST['NewacetateL']) ? $_POST['NewacetateL'] : '';
    $NewpaintL = isset($_POST['NewpaintL']) ? $_POST['NewpaintL'] : '';
    $sprayViscosity = $_POST['sprayViscosity'];
    $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
    $quantity = $_POST['quantity'];
    $Endingdiameter = $_POST['Endingdiameter'];
    $Endingheight = $_POST['Endingheight'];
    $EndingpaintRatio = $_POST['EndingpaintRatio'];
    $EndingacetateRatio = $_POST['EndingacetateRatio'];
    $paintYield = $_POST['paintYield'];
    $acetateYield = $_POST['acetateYield'];
    $remarks = $_POST['remarks'];

    /*Para nga ma-insert ang mga data sa mga tables, kinahanglan
    na mag insert ka nga magkasunod-sunod og foreign key, dependi kong unsay
    una nga table with foreign key */

    // Insert into tbl_customer
    $sql = "INSERT INTO `tbl_customer` (customer_name, userID) VALUES ('$customer_name', '$id')";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die(mysqli_error($con));
    }

    // Get the customerID of the newly inserted customer
    $customerID = mysqli_insert_id($con);

    // Insert into tbl_supplier
    $sql = "INSERT INTO `tbl_supplier` (supplier_name, newSupplier_name) VALUES ('$supplier_name', '$newSupplier_name')";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die(mysqli_error($con));
    }

    // Get the supplierID of the newly inserted supplier
    $supplierID = mysqli_insert_id($con);

    // Insert into tbl_paint
    $sql = "INSERT INTO `tbl_paint` (paint_color, supplierID) VALUES ('$paint_color', '$supplierID')";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die(mysqli_error($con));
    }

    // Get the paintID of the newly inserted paint
    $paintID = mysqli_insert_id($con);

    // Insert into tbl_entry
    $sql = "INSERT INTO `tbl_entry` (userID, customerID, paintID, date, batchNumber, diameter, height, paintRatio, acetateRatio, NewacetateL, NewpaintL, sprayViscosity, quantity, Endingdiameter, Endingheight, EndingpaintRatio, EndingacetateRatio, paintYield, acetateYield, remarks)
    VALUES ('$id', '$customerID', '$paintID', '$date', '$batchNumber', '$diameter', '$height', '$paintRatio', '$acetateRatio', '$NewacetateL', '$NewpaintL', '$sprayViscosity', '$quantity', '$Endingdiameter', '$Endingheight', '$EndingpaintRatio', '$EndingacetateRatio', '$paintYield', '$acetateYield', '$remarks')";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        die(mysqli_error($con));
    }

    // Get the EntryID of the newly inserted Entry
    $EntryID = mysqli_insert_id($con);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="IMAGES/faviconlogo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kalnia:wght@700&family=Noto+Serif+Makasar&family=Pattaya&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
    <title>Dashboard</title>
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
            width: 230px;
            height: 100px;
            border-radius: 10px;
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


        .editProfile_container {
            background-color: #3498db;
            padding: 3em 0 3em 0;
            flex: 1 1 100px;
            margin-right: auto;
            text-align: center;

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



        /*FOR FILTER BAR */
        .filterfield {
            width: 150px;
            height: 40px;
            margin-left: 2%;
            background-color: white;
            border-color: #86b7fe;
            border-radius: 5px;

        }


        #ampm {
            margin-left: 10px;
        }

        /*FOR DATA ENTRY */
        .modal-body {

            background-color: rgb(225, 225, 212);

        }

        .initial {
            display: flex;
            flex: 1;
            padding: 2%;

            height: 100%;
            background-color: #87ceeb;
            /*#98fb98 */
        }


        .styleform {
            width: 25%;
            height: 20px;
            margin-bottom: 20px;
            border-color: #86;
            border-radius: 5px;
        }

        .initial .form-column {
            width: 100%;
            /* Adjust the width as needed */
            margin: 0 auto;
            /* Center the column horizontally */
            /* Add any other custom styles here */
        }


        .modal-body .initial {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80%;
            /* Ensure the container fills the height of the modal body */
        }

        .modal-header {

            background-color: #5484f4;
        }

        /* Adjust the alignment of the modal title to center it */
        .center-modal-title {
            font-size: 30px;
            text-align: center;
            /* Center-align the modal title */
            margin: 0 auto;
            /* Center the title horizontally */
            margin-left: 40%;
            color: white;
        }

        /*FOR NEW PAINT MIX */
        .newpaintmix {
            display: flex;
            flex-direction: row;
            /* Boxes will be arranged horizontally */
            justify-content: space-around;
            /* Space evenly distributed along the main axis */
            align-items: center;

        }

        /*FOR PRODUCTION OUTPUT */
        .productionOutput {
            display: flex;
            flex-direction: row;
            /* Boxes will be arranged horizontally */
            justify-content: space-around;
            /* Space evenly distributed along the main axis */
            align-items: center;

        }

        /*FOR yield */
        .yield {
            display: flex;
            flex-direction: row;
            /* Boxes will be arranged horizontally */
            justify-content: space-around;
            /* Space evenly distributed along the main axis */
            align-items: center;

        }

        /*FOR ending */
        .ending {
            display: flex;
            flex-direction: row;
            /* Boxes will be arranged horizontally */
            justify-content: space-around;
            /* Space evenly distributed along the main axis */
            align-items: center;

        }

        /*FOR READONLY OF YIELD */


        .vertical-line {
            width: 4px;
            /* Adjust the width of the line as needed */
            height: 8vh;
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

        /* FOR CLOCK */

        .clockcontainer {
            width: 295px;
            height: 180px;
            position: absolute;
            top: 45%;
            left: 1704px;
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
            font-size: 35px;
            width: 30px;
            display: inline-block;
            text-align: center;
            position: relative;
        }

        .main1 {
            background-color: #5755FE;
            padding: 2%;
            flex: 1 1 150px;
            margin-top: 20px;
            margin-left: 30px;
        }

        .main2 {
            display: flex;
            justify-content: space-between;
        }

        header {
            margin-top: 40px;
        }

        .left {
            display: flex;
            /* Use flexbox for the left column */
            background-color: #5755FE;
            padding: 3em 0 3em 0;
            flex: 1 1 100px;
            margin-left: auto;
            flex-direction: column;
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .right {
            background-color: #5755FE;
            padding: 3em 0 3em 0;
            flex: 1 1 100px;
            margin-right: auto;
            padding-top: 0px;
            padding-bottom: 0px;

        }

        footer {
            background-color: #5755FE;
            padding: 1em 0;
            display: flex;
            justify-content: center;
            /* Align content horizontally in the center */
        }




        .xbox1 {
            width: 40%;
            height: 202px;
            padding: 10px;
            padding-left: 10px;
            margin-right: 18px;
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            border-radius: 20px;

        }

        .xbox2 {
            width: 30%;
            height: 202px;
            padding: 10px;
            padding-left: 10px;
            margin-right: 18px;
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            border-radius: 20px;

        }

        .xbox3 {
            width: 80%;
            height: 202px;
            padding: 10px;
            padding-left: 10px;
            margin-right: 16px;
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            border-radius: 20px;

        }

        .xbox4 {
            width: 98%;
            height: 500px;
            margin-top: 20px;
            text-align: center;
            border-radius: 20px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .xbox5 {
            margin-top: 20px;
            width: 100%;
            height: 500px;
            border-radius: 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            /* Center contents horizontally */
            align-items: center;
            /* Center contents vertically */
        }

        .xbox6 {
            margin-top: 20px;
            width: 98%;
            height: 510px;
            text-align: center;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .xbox7 {
            margin-top: 20px;
            width: 100%;
            height: 510px;
            text-align: center;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .xbox8 {
            margin-top: 20px;
            width: 48%;
            height: 600px;
            text-align: center;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .xbox9 {
            width: 80%;
            height: 202px;

            padding-left: 10px;

            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            border-radius: 20px;

        }

        .xbox-container {
            display: flex;
        }

        .xbox-container>div {
            border-radius: 20px;
            text-align: center;
            padding: 10px;
        }

        .box1 {
            background-color: white;
            color: black;
        }

        canvas#yearlyChart {
            height: 100px;
        }


        .box2 {

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
            color: black;
        }

        .box3 {
            background-color: white;
            color: black;

        }

        .box4 {
            background-color: white;

        }

        .box5 {
            background-color: #ACE2E1;

        }

        .box6 {
            background-color: white;

        }

        .box7 {
            background-color: white;

        }

        .box8 {
            background-color: white;

        }

        .box9 {
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-color: white;
        }

        /*FOR FILTER BAR */
        .filterfield {
            width: 150px;
            height: 40px;
            margin-left: 2%;
            background-color: white;
            border-color: #86b7fe;
            border-radius: 5px;
            margin-top: 10px;

        }

        .filterfieldMonth {

            width: 120px;
            height: 30px;
            margin-left: 2%;
            background-color: white;
            border-color: #86b7fe;
            border-radius: 5px;
            margin-top: 10px;
        }



        .morning {
            font-family: "Pattaya", sans-serif;

        }


        .item1 {

            width: 100%;
            /* Set width for each item */
            height: 100%;
            /* Set height for each item */
            margin-left: 60px;
            margin-top: 10px;

        }

        #piechart {

            width: 100%;
            height: 100%;

        }



        /* Define animation keyframes for sparkling effect */
        @keyframes sparkling {
            0% {
                background-color: red;
            }

            50% {
                background-color: white;
            }

            100% {
                background-color: red;
            }
        }

        /* Apply animation to error class */
        .error {
            animation: sparkling 1s ease infinite;
            /* Apply sparkling animation */
        }

        body.active .wrapper .section .xbox4 {

            width: 98%;
            height: 100%;

        }

        body.active .wrapper .section .xbox-container {
            margin-right: 4px;
        }

        body.active .wrapper .section .xbox4 {

            width: 98%;
            height: 100%;

        }

        body.active .wrapper .section .xbox5 {


            height: 560px;

        }

        body.active .wrapper .section .xbox6 {
            height: 100%;

        }

        body.active .wrapper .section .xbox7 {
            height: 565px;

        }

        body.active .wrapper .section .xbox8 {
            height: 100%;

        }

        body.active .wrapper .section .clockcontainer {
            margin-left: -4%;
            margin-top: 1%;

        }

        .custom-width {
            width: 50%;

            text-align: center;
        }
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
                <h1
                    style="text-align:center; font-size:40px; background-color:#6AD4DD; padding:10px; font-weight:bold;">
                    Paint and Acetate Yield Monitoring
                    System</h1>
                <header>
                    <div class="xbox-container">

                        <div class="xbox1 box1">
                            <h5 style="">Total Drum Painted</h5>
                            <label style="margin-left:2%;">From month:</label>
                            <input type="month" style="text-align: center;" class="filterfieldMonth" id="fromMonth"
                                name="fromMonth" autocomplete="off">
                            <br>
                            <label style="margin-left:20px;">To month:</label>
                            <input type="month" style="text-align: center;" class="filterfieldMonth" id="toMonth"
                                name="toMonth" autocomplete="off">
                            <br>
                            <input type="number"
                                style="width:240px; height:50px; margin-top:20px; text-align:center; border:none; font-weight:bold; font-size:30px;"
                                id="totalDrumOutput" readonly>
                        </div>



                        <div class="xbox2 box2">
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

                            // Retrieve total entries count
                            $sql = "SELECT COUNT(*) AS totalEntries
                            FROM tbl_entry AS entry
                            INNER JOIN tbl_user AS user ON entry.userID = user.userID
                            WHERE user.Username = 'Admin' AND DATE(entry.date) = '$lastEntryDate'";
                            $result = mysqli_query($con, $sql);

                            // Debugging
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
                            <h5 style="">Data Entry</h5>
                            <button type="button" class="btn btn-primary"
                                style="height:45px; width:45px; border-radius:50px; margin-top:61px; margin-left:51px;"
                                id="dataentry">
                                <i class="fa-solid fa-plus" style="font-size:30px; margin-left:-4px;"></i></button>
                            <h6>Total Entries:</h6>
                            <input type="number"
                                style=" width:150px;height:20px;text-align:center; font-weight:bold; background-color:; border:none; font-size:28px;"
                                value="<?php echo $totalEntries; ?>" readonly>
                        </div>
                        <div class="xbox3 box3">
                            <label style="margin-left:11%; font-size:20px;">Select Paint color: </label>
                            <select id="paintColorSelect" class="filterfield"
                                style="width:58%; font-size:20px; text-align:center; margin-bottom:10px; height:20%; border-color:black;">
                                <option value="">Select Paint color</option>
                                <!-- Add options dynamically from database if needed -->

                                <option value="Royal Blue">Royal Blue</option>
                                <option value="Buff">Buff</option>
                                <option value="Delft Blue">Delft Blue</option>
                                <option value="Golden Brown">Golden Brown</option>
                                <option value="Clear">Clear</option>
                                <option value="White">White</option>
                                <option value="Black">Black</option>
                                <option value="Alpha Gray">Alpha Gray</option>
                                <option value="Nile Green">Nile Green</option>
                                <option value="Emerald Green">Emerald Green</option>
                                <option value="Jade Green">Jade Green</option>
                                <option value="Pulsating Blue">Pulsating Blue</option>

                                <!-- Add more options as needed -->
                            </select>

                            <div class="table-wrapper" style="max-height: 145px; overflow-y: auto;">
                                <table id="yieldTable" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th style="border:none;"></th>
                                            <th colspan="2"
                                                style="text-align: center; font-size:30px; height:50px; border: 1px solid black;">
                                                Yield</th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid black; font-size:20px; height:30px;">Paint
                                                color</th>
                                            <th
                                                style="border: 1px solid black; font-size:20px; height:30px; width:152px;">
                                                Paint</th>
                                            <th style="border: 1px solid black; font-size:20px; height:30px;">Acetate
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody style="border: 1px solid black; font-size:20px; height:30px;">
                                        <!-- This tbody section will be populated dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="xbox9 box9" style="text-align: center;">
                            <h1 style="margin-bottom:10px; margin-top:20px; font-weight:bold; font-size:30px;"
                                id="greeting"></h1>
                            <!--FOR CLOCK-->
                            <div class="clockcontainer" style="text-align:center;">
                                <div class="clock">
                                    <span id="hrs"></span>
                                    <span>:</span>
                                    <span id="minutes"></span>
                                    <span>:</span>
                                    <span id="sec"></span>
                                    <span id="ampm"></span>
                                </div>
                            </div>
                            <!-- Date -->

                            <h2 style="font-size:20px; font-weight: bold; margin-bottom:10px;">
                                <?php echo date("l, F j, Y"); ?>
                            </h2>
                        </div>
                        <script>
                            // Function to update the greeting and background image
                            function updateGreetingAndBackground() {
                                var now = new Date();
                                var hours = now.getHours();

                                var greeting = document.getElementById('greeting');
                                if (hours >= 0 && hours < 12) {
                                    greeting.textContent = "Good Morning, <?php echo $Name; ?>!";
                                    document.querySelector('.box9').style.backgroundImage = "url('IMAGES/morning_background.jpg')";
                                } else {
                                    greeting.textContent = "Good Afternoon, <?php echo $Name; ?>!";
                                    document.querySelector('.box9').style.backgroundImage = "url('IMAGES/afternoon_background.jpg')";
                                }
                            }

                            // Call updateGreetingAndBackground() initially to display correct greeting and background image
                            updateGreetingAndBackground();

                            // Clock script
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

                                // Call updateGreetingAndBackground() every hour to update the greeting and background image
                                if (currentTime.getMinutes() === 0 && currentTime.getSeconds() === 0) {
                                    updateGreetingAndBackground();
                                }
                            }, 1000);
                        </script>
                    </div>
                </header>
                <div class="main2">

                    <aside class="left">

                        <div class="xbox4 box4">
                            <h4>Daily Report</h4>
                            <label style="margin-left:2%; margin-top:20px;">From date:</label>
                            <input type="date" style="text-align: center;" class="filterfield" id="min" name="min"
                                autocomplete="off">
                            <label style="margin-left:3%;">To date:</label>
                            <input type="date" style="text-align: center;" class="filterfield" id="max" name="max"
                                autocomplete="off">
                            <canvas id="areaChart" style="height:78%; width:100%;"></canvas>
                        </div>
                        <div class="xbox6 box6">
                            <h4>Weekly Report</h4>
                            <label style="margin-left:2%;">Select Month to show Weekly data:</label>
                            <input type="month" style="text-align: center;" class="filterfield" id="selectedMonth"
                                name="selectedMonth" autocomplete="off" required>
                            <canvas id="weeklyChart" style="height:80%; width:100%;"></canvas>
                        </div>

                    </aside>
                    <aside class="right">

                        <div class="xbox5 box5">
                            <!-- FOR PIE CHART -->
                            <div class="item1" style="padding:10px;  padding-right:60px;">
                                <div id="piechart"></div>
                            </div>
                        </div>

                        <div class="xbox7 box7">

                            <h4>Yearly Report</h4>
                            <!-- FOR YEARLY BAR CHART -->

                            <label style="margin-top:20px;">From year:</label>
                            <input type="number" style="text-align: center;" class="filterfield" id="from" name="from"
                                autocomplete="off" placeholder="year">
                            <label style="margin-left:20px;">To year:</label>
                            <input type="number" style="text-align: center;" class="filterfield" id="to" name="to"
                                autocomplete="off" placeholder="year">
                            <canvas id="yearlyChart" style="height:80%; width:100%;"></canvas>

                        </div>
                    </aside>
                    <!-- Data Entry modal -->

                    <div class="modal fade" id="initialmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title center-modal-title" id="exampleModalLabel">DATA ENTRY
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <fieldset>
                                            <div class="initial">
                                                <div class="form-column">
                                                    <div class="newpaintmix">
                                                        <h4>Initial Inventory</h4>
                                                    </div>
                                                    <br>
                                                    <div class="row"> <!-- Row for the input fields -->
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for date (centered) -->
                                                            <div class="form-floating">
                                                                <input type="date"
                                                                    style="width:100%; margin-right:15px;"
                                                                    class="form-control styleform" name="date"
                                                                    id="floatingDate1" value="<?php echo $date; ?>"
                                                                    required>
                                                                <label for="floatingDate1">Date:</label>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for select (centered) -->
                                                            <div class="form-floating">
                                                                <select name="paint_color" style="width:100%;"
                                                                    class="form-select styleform"
                                                                    id="floatingPaintColor" required>
                                                                    <option value="">------ Select ------</option>
                                                                    <option value="Royal Blue" <?php if ($paint_color == 'Royal Blue')
                                                                        echo 'selected'; ?>>Royal Blue</option>
                                                                    <option value="Delft Blue" <?php if ($paint_color == 'Delft Blue')
                                                                        echo 'selected'; ?>>
                                                                        Delft Blue</option>
                                                                    <option value="Buff" <?php if ($paint_color == 'Buff')
                                                                        echo 'selected'; ?>>Buff</option>
                                                                    <option value="Golden Brown" <?php if ($paint_color == 'Golden Brown')
                                                                        echo 'selected'; ?>>Golden Brown
                                                                    </option>
                                                                    <option value="Clear" <?php if ($paint_color == 'Clear')
                                                                        echo 'selected'; ?>>
                                                                        Clear</option>
                                                                    <option value="White" <?php if ($paint_color == 'White')
                                                                        echo 'selected'; ?>>
                                                                        White</option>
                                                                    <option value="Black" <?php if ($paint_color == 'Black')
                                                                        echo 'selected'; ?>>
                                                                        Black</option>
                                                                    <option value="Alpha Gray" <?php if ($paint_color == 'Alpha Gray')
                                                                        echo 'selected'; ?>>Alpha Gray</option>
                                                                    <option value="Nile Green" <?php if ($paint_color == 'Nile Green')
                                                                        echo 'selected'; ?>>Nile Green</option>
                                                                    <option value="Emerald Green" <?php if ($paint_color == 'Emerald Green')
                                                                        echo 'selected'; ?>>Emerald Green
                                                                    </option>
                                                                    <option value="Jade Green" <?php if ($paint_color == 'Jade Green')
                                                                        echo 'selected'; ?>>Jade Green</option>
                                                                    <option value="Pulsating Blue" <?php if ($paint_color == 'Pulsating Blue')
                                                                        echo 'selected'; ?>>Pulsating Blue</option>
                                                                </select>
                                                                <label for="floatingPaintColor">Paint Color:</label>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for diameter (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="diameter" id="floatingDiameter" min="0"
                                                                    step="any" placeholder="Diameter"
                                                                    value="<?php echo $diameter; ?>" required>
                                                                <label for="floatingDiameter">Diameter:</label>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for diameter (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="height" id="floatingheight" min="0" step="any"
                                                                    placeholder="height" value="<?php echo $height; ?>"
                                                                    required>
                                                                <label for="floatingheight">Height:</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row"> <!-- Row for the input fields -->
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for diameter (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:99%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="batchNumber" id="floatingBatchNo:" min="0"
                                                                    step="any" placeholder="Diameter"
                                                                    value="<?php echo $batchNumber; ?>" required>
                                                                <label for="floatingBatchNo:">Batch No:</label>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for select (centered) -->
                                                            <div class="form-floating">
                                                                <select name="supplier_name" style="width:100%; "
                                                                    class="form-select styleform" id="floatingSupplier"
                                                                    required>
                                                                    <option value="">------ Select ------</option>
                                                                    <option value="Nippon" <?php if ($supplier_name == 'Nippon')
                                                                        echo 'selected'; ?>>
                                                                        Nippon</option>
                                                                    <option value="Treasure Island" <?php if ($supplier_name == 'Treasure Island')
                                                                        echo 'selected'; ?>>Treasure
                                                                        Island</option>
                                                                    <option value="Inkote" <?php if ($supplier_name == 'Inkote')
                                                                        echo 'selected'; ?>>
                                                                        Inkote</option>
                                                                    <option value="Century" <?php if ($supplier_name == 'Century')
                                                                        echo 'selected'; ?>>
                                                                        Century</option>
                                                                </select>
                                                                <label for="floatingSupplier">Supplier:</label>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for diameter (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="paintRatio" id="floatingpaintRatio" min="0"
                                                                    step="any" placeholder="Paint ratio"
                                                                    value="<?php echo $paintRatio; ?>" required>
                                                                <label for="floatingpaintRatio">Paint ratio:</label>
                                                            </div>


                                                        </div>
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for diameter (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="acetateRatio" id="floatingacetateRatio"
                                                                    min="0" step="any" placeholder="Acetate ratio"
                                                                    value="<?php echo $acetateRatio; ?>" required>
                                                                <label for="floatingacetateRatio">Acetate ratio:</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr style="border-top: 5px solid black;">
                                                    <div class="ending">
                                                        <button type="button" class="btn btn-primary"
                                                            id="toggleEndingInventory"
                                                            style="font-size:20px;margin-left:px;width:30%;">
                                                            Ending Inventory
                                                        </button>
                                                    </div>

                                                    <!-- "Ending Inventory" section -->
                                                    <div class="collapse" id="collapseEndingInventory">
                                                        <div class="card card-body"
                                                            style="background-color:#87ceeb; padding-bottom:0px; border:none;">
                                                            <div class="row"> <!-- Row for the input fields -->
                                                                <div
                                                                    class="col-md-3 d-flex justify-content-center align-items-center">
                                                                    <!-- Column for diameter (centered) -->
                                                                    <div class="form-floating">
                                                                        <input type="number" style="width:100%;"
                                                                            class="form-control styleform custom-width"
                                                                            name="Endingdiameter"
                                                                            id="floatingEndingdiameter" min="0"
                                                                            step="any" placeholder="Ending diameter"
                                                                            value="<?php echo $Endingdiameter; ?>"
                                                                            required>
                                                                        <label for="floatingEndingdiameter">
                                                                            Diameter:</label>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-3 d-flex justify-content-center align-items-center">
                                                                    <!-- Column for diameter (centered) -->
                                                                    <div class="form-floating">
                                                                        <input type="number" style="width:100%;"
                                                                            class="form-control styleform custom-width"
                                                                            name="Endingheight" id="floatingDiameter"
                                                                            min="0" step="any"
                                                                            placeholder="Ending height"
                                                                            value="<?php echo $Endingheight; ?>"
                                                                            required>
                                                                        <label
                                                                            for="floatingEndingheight">Height:</label>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-3 d-flex justify-content-center align-items-center">
                                                                    <!-- Column for diameter (centered) -->
                                                                    <div class="form-floating">
                                                                        <input type="number" style="width:100%;"
                                                                            class="form-control styleform custom-width"
                                                                            name="EndingpaintRatio"
                                                                            id="floatingEndingpaintRatio" min="0"
                                                                            step="any" placeholder="Paint ratio"
                                                                            value="<?php echo $EndingpaintRatio; ?>"
                                                                            required>
                                                                        <label for="floatingEndingpaintRatio">Paint
                                                                            ratio:</label>
                                                                    </div>


                                                                </div>
                                                                <div
                                                                    class="col-md-3 d-flex justify-content-center align-items-center">
                                                                    <!-- Column for diameter (centered) -->
                                                                    <div class="form-floating">
                                                                        <input type="number" style="width:100%;"
                                                                            class="form-control styleform custom-width"
                                                                            name="EndingacetateRatio"
                                                                            id="floatingEndingacetateRatio" min="0"
                                                                            step="any" placeholder="Acetate ratio"
                                                                            value="<?php echo $EndingacetateRatio; ?>"
                                                                            required>
                                                                        <label for="floatingEndingacetateRatio">Acetate
                                                                            ratio:</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr style="border-top: 5px solid black;">

                                                    <div class="newpaintmix">
                                                        <h4>New Paint Mix</h4>
                                                    </div>
                                                    <br>
                                                    <div class="row"> <!-- Row for the input fields -->
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for select (centered) -->
                                                            <div class="form-floating">
                                                                <select name="newSupplier_name" style="width:100%; "
                                                                    class="form-select styleform"
                                                                    id="floatingnewSupplier_name" required>
                                                                    <option value="">------ Select ------</option>
                                                                    <option value="Nippon" <?php if ($newSupplier_name == 'Nippon')
                                                                        echo 'selected'; ?>>
                                                                        Nippon</option>
                                                                    <option value="Treasure Island" <?php if ($newSupplier_name == 'Treasure Island')
                                                                        echo 'selected'; ?>>Treasure
                                                                        Island</option>
                                                                    <option value="Inkote" <?php if ($newSupplier_name == 'Inkote')
                                                                        echo 'selected'; ?>>
                                                                        Inkote</option>
                                                                    <option value="Century" <?php if ($newSupplier_name == 'Century')
                                                                        echo 'selected'; ?>>
                                                                        Century</option>
                                                                </select>
                                                                <label for="floatingnewSupplier_name">Supplier:</label>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for diameter (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="sprayViscosity" id="floatingsprayViscosity"
                                                                    min="0" step="any" placeholder="Spray Viscosity"
                                                                    value="<?php echo $sprayViscosity; ?>" required>
                                                                <label for="floatingsprayViscosity">Spray
                                                                    Viscosity:</label>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for diameter (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="NewpaintL" id="floatingNewpaintL" min="0"
                                                                    step="any" placeholder="Paint Liter"
                                                                    value="<?php echo $NewpaintL; ?>" required>
                                                                <label for="floatingNewpaintL">Paint liter:</label>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-3 d-flex justify-content-center align-items-center">
                                                            <!-- Column for diameter (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="NewacetateL" id="floatingNewacetateL" min="0"
                                                                    step="any" placeholder="Acetate Liter"
                                                                    value="<?php echo $NewacetateL; ?>" required>
                                                                <label for="floatingNewacetateL">Acetate
                                                                    liter:</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="newpaintmix">
                                                        <h4>Production Output</h4>
                                                    </div>
                                                    <br>
                                                    <div class="row"> <!-- Row for the input fields -->
                                                        <div
                                                            class="col-md-4 d-flex justify-content-center align-items-center">
                                                            <!-- Column for customer name (centered) -->
                                                            <div class="form-floating">
                                                                <input type="text" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="customer_name" id="floatingcustomer_name"
                                                                    placeholder="Customer Name"
                                                                    value="<?php echo $customer_name; ?>" required>
                                                                <label for="floatingcustomer_name">Customer:</label>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-4 d-flex justify-content-center align-items-center">
                                                            <!-- Column for quantity (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="quantity" id="floatingquantity" min="0"
                                                                    step="any" placeholder="Quantity"
                                                                    value="<?php echo $quantity; ?>" required>
                                                                <label for="floatingquantity">Quantity:</label>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-4 d-flex justify-content-center align-items-center">
                                                            <!-- Column for remarks (centered) -->
                                                            <div class="form-floating">
                                                                <input type="text" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="remarks" id="floatingremarks"
                                                                    placeholder="Remarks"
                                                                    value="<?php echo $remarks; ?>" required>
                                                                <label for="floatingremarks">Remarks:</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="newpaintmix">
                                                        <h4>Yield</h4>
                                                    </div>
                                                    <br>
                                                    <div class="row justify-content-center">
                                                        <!-- Row for the input fields, centered -->
                                                        <div
                                                            class="col-md-4 d-flex justify-content-center align-items-center">
                                                            <!-- Column for customer name (centered) -->
                                                            <div class="form-floating">
                                                                <input type="text" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="paintYield" id="paintYield"
                                                                    placeholder="Paint yield"
                                                                    value="<?php echo $paintYield; ?>" readonly>
                                                                <label for="paintYield">Paint yield:</label>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-4 d-flex justify-content-center align-items-center">
                                                            <!-- Column for quantity (centered) -->
                                                            <div class="form-floating">
                                                                <input type="number" style="width:100%;"
                                                                    class="form-control styleform custom-width"
                                                                    name="acetateYield" id="floatingacetateYield"
                                                                    min="0" step="any" placeholder="Acetate yield"
                                                                    value="<?php echo $acetateYield; ?>" readonly>
                                                                <label for="floatingacetateYield">Acetate yield:</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-6 d-flex justify-content-center">
                                                            <button type="submit" id="update"
                                                                class="btn btn-primary btn-lg" name="submit"
                                                                style="font-size:24px; border-radius:50px; border-color:white; width:70%; padding-top:1%;padding-bottom:1%;">Add</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <footer>
                    <div class="xbox8 box8">
                        <h4>Monthly Report</h4>
                        <!-- FOR MONTHLY BAR CHART -->
                        <label style="margin-left:2%;">From date:</label>
                        <input type="month" style="text-align: center; margin-top:25px;" class="filterfield" id="min2"
                            name="min2" autocomplete="off">
                        <label style="margin-left:3%;">To date:</label>
                        <input type="month" style="text-align: center; margin-top:25px;" class="filterfield" id="max2"
                            name="max2" autocomplete="off">
                        <canvas id="yieldChart" style="height:80%; width:100%;"></canvas>
                    </div>
                </footer>
            </div>

            <!--Top menu -->
            <div class="sidebar">
                <!--profile image & text-->
                <div class="profile">
                    <img src="IMAGES/logo.jpg" alt="profile_picture">
                    <h6 style="font-size:20px; margin-top:30px; color:white;">Mindanao Container Corporation</h6>
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
                        <a href="dataEntry.php" class="active">
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
                    <li>
                        <a href="acetateReport.php">
                            <span class="icon"><i class="fa-solid fa-file-signature"></i></span>
                            <span class="item">Acetate Report</span>
                        </a>
                    </li>

                </ul>

            </div>


            <!-- Clickable image modal -->
            <div class="modal fade" id="clickable_image" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
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
                                                style="font-size:25px; margin-top:20px;">Update
                                                profile</button></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!--FOR FILTER BY COLOR-->
            <script>
                // Function to filter data based on selected paint color
                function filterByColor() {
                    var paintColor = document.getElementById("paintColorSelect").value.trim().toLowerCase();

                    // AJAX call to fetch data based on selected paint color
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("yieldTable").getElementsByTagName("tbody")[0].innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "filter_by_color.php?color=" + paintColor, true);
                    xhttp.send();
                }

                // Attach the filterByColor function to the select element's onchange event
                document.getElementById("paintColorSelect").addEventListener("change", filterByColor);
            </script>


            <!-- Error Handling and Real-Time Data Calculation Script -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Add event listener to all relevant input fields
                    ['paintYield', 'NewpaintL', 'NewacetateL', 'quantity', 'diameter', 'height', 'paintRatio', 'acetateRatio', 'Endingdiameter', 'Endingheight', 'EndingpaintRatio', 'EndingacetateRatio'].forEach(function (fieldName) {
                        document.querySelector(`input[name="${fieldName}"]`).addEventListener('input', updateYieldAndValidate);
                    });


                });

                function updateYieldAndValidate() {
                    // Update yield and validate paint yield
                    updateYield();
                    validatePaintYield();
                }

                function validatePaintYield() {
                    var paintYieldInput = document.getElementById('paintYield');
                    var paintYield = parseFloat(paintYieldInput.value);
                    // Check if the Paint Yield is below 4.0
                    if (paintYield < 4.0) {
                        // Add CSS class for color validation
                        paintYieldInput.classList.add('error');
                        return false; // Return false indicating validation failed
                    } else {
                        // Remove CSS class if value is valid
                        paintYieldInput.classList.remove('error');
                        return true; // Return true indicating validation passed
                    }
                }

                function updateYield() {
                    var formData = new FormData(document.querySelector('form'));
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "calculate_yield.php", true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var response = JSON.parse(xhr.responseText);
                            document.querySelector('input[name="paintYield"]').value = response.paintYield;
                            document.querySelector('input[name="acetateYield"]').value = response.acetateYield;
                            // After updating the yield, re-validate the paint yield
                            validatePaintYield();
                        }
                    };
                    xhr.send(formData);
                }
            </script>


            <!--BAR CHART FOR YEAR-->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
            <script>
                // PHP to fetch data
                <?php
                $sql = "SELECT SUM(paintYield) AS totalPaintYield, SUM(acetateYield) AS totalAcetateYield, YEAR(date) AS year FROM tbl_entry GROUP BY year";
                $result = mysqli_query($con, $sql);
                $data = [];
                while ($row = mysqli_fetch_array($result)) {
                    $data[] = $row;
                }
                ?>

                // JavaScript to format data for Chart.js
                var years = [];
                var totalPaintYields = [];
                var totalAcetateYields = [];

                <?php foreach ($data as $row): ?>                 years.push('<?php echo $row['year']; ?>'); totalPaintYields.push(<?php echo $row['totalPaintYield']; ?>); totalAcetateYields.push(<?php echo $row['totalAcetateYield']; ?>);
                <?php endforeach; ?>

                var ctx = document.getElementById('yearlyChart').getContext('2d');

                var yearlyChart;

                function filterData() {
                    var minYear = document.getElementById('from').value;
                    var maxYear = document.getElementById('to').value;

                    var filteredYears = [];
                    var filteredPaintYields = [];
                    var filteredAcetateYields = [];

                    for (var i = 0; i < years.length; i++) {
                        if (years[i] >= minYear && years[i] <= maxYear) {
                            filteredYears.push(years[i]);
                            filteredPaintYields.push(totalPaintYields[i]);
                            filteredAcetateYields.push(totalAcetateYields[i]);
                        }
                    }

                    yearlyChart.data.labels = filteredYears;
                    yearlyChart.data.datasets[0].data = filteredPaintYields;
                    yearlyChart.data.datasets[1].data = filteredAcetateYields;
                    yearlyChart.update();
                }

                // Attach event listeners to year inputs to trigger filtering in real-time
                document.getElementById('from').addEventListener('input', filterData);
                document.getElementById('to').addEventListener('input', filterData);

                yearlyChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: years,
                        datasets: [{
                            label: 'Total Paint Yield',
                            backgroundColor: 'rgba(255, 99, 132, 0.4)',
                            borderColor: 'rgba(255, 99, 132, 2)',
                            borderWidth: 1,
                            data: totalPaintYields
                        }, {
                            label: 'Total Acetate Yield',
                            backgroundColor: 'rgba(54, 162, 235, 0.4)',
                            borderColor: 'rgba(54, 162, 235, 2)',
                            borderWidth: 1,
                            data: totalAcetateYields
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
            <!-- BAR CHART FOR WEEK -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
            <script>
                var ctx = document.getElementById('weeklyChart').getContext('2d');
                var weeklyChart;

                function filterData() {
                    var selectedMonth = document.getElementById('selectedMonth').value;
                    fetch('fetch_weekly_data.php?month=' + selectedMonth)
                        .then(response => response.json())
                        .then(data => {
                            updateChart(data);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function updateChart(data) {
                    var weeks = data.weeks; // Week labels are already in the format "Week x"
                    var paintYields = data.paintYields;
                    var acetateYields = data.acetateYields;

                    weeklyChart.data.labels = weeks;
                    weeklyChart.data.datasets[0].data = paintYields;
                    weeklyChart.data.datasets[1].data = acetateYields;
                    weeklyChart.update();
                }

                document.getElementById('selectedMonth').addEventListener('change', filterData);

                weeklyChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Total Paint Yield',
                            backgroundColor: 'rgba(255, 99, 132, 0.4)',
                            borderColor: 'rgba(255, 99, 132, 2)',
                            borderWidth: 1,
                            data: []
                        }, {
                            label: 'Total Acetate Yield',
                            backgroundColor: 'rgba(54, 162, 235, 0.4)',
                            borderColor: 'rgba(54, 162, 235, 2)',
                            borderWidth: 1,
                            data: []
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Set default value to current month
                document.getElementById('selectedMonth').valueAsDate = new Date();
                filterData(); // Trigger filtering with default value
            </script>

            <!--TOTAL DRUM PAINTED-->
            <script>
                // Function to fetch data from the server using AJAX
                function fetchData(callback) {
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var data = JSON.parse(xhr.responseText);
                            callback(data);
                        }
                    };
                    xhr.open("GET", "totalDrum_fetchdata.php", true);
                    xhr.send();
                }

                // Function to calculate total drum count for the specified range of months
                function calculateTotalDrumForRange(data, fromMonth, toMonth) {
                    var totalDrum = 0;
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].month_year >= fromMonth && data[i].month_year <= toMonth) {
                            totalDrum += parseInt(data[i].totalPaintDrum);
                        }
                    }
                    return totalDrum;
                }

                // Function to update total drum count for the specified range of months
                function updateTotalDrumForRange() {
                    var fromMonth = document.getElementById('fromMonth').value;
                    var toMonth = document.getElementById('toMonth').value;
                    fetchData(function (data) {
                        var totalDrum = calculateTotalDrumForRange(data, fromMonth, toMonth);
                        document.getElementById('totalDrumOutput').value = totalDrum;
                    });
                }

                // Function to fetch data and update total drum count for the latest month
                function updateTotalDrumForLatestMonth() {
                    fetchData(function (data) {
                        // Get the current date
                        var currentDate = new Date();
                        // Extract the current year and month from the current date
                        var currentYear = currentDate.getFullYear();
                        var currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Month is zero-based
                        // Set "fromMonth" to the previous month and "toMonth" to the current month
                        var previousMonth = (currentDate.getMonth()).toString().padStart(2, '0');
                        var previousMonthYear = (currentMonth === '01') ? currentYear - 1 : currentYear;
                        document.getElementById('fromMonth').value = `${previousMonthYear}-${previousMonth}`;
                        document.getElementById('toMonth').value = `${currentYear}-${currentMonth}`;
                        // Calculate and display total drum count for the specified range of months
                        var totalDrum = calculateTotalDrumForRange(data, `${previousMonthYear}-${previousMonth}`, `${currentYear}-${currentMonth}`);
                        document.getElementById('totalDrumOutput').value = totalDrum;
                    });
                }

                // Attach event listeners to month inputs to trigger updateTotalDrumForRange function
                document.getElementById('fromMonth').addEventListener('input', updateTotalDrumForRange);
                document.getElementById('toMonth').addEventListener('input', updateTotalDrumForRange);

                // Initial call to updateTotalDrumForLatestMonth to display total paint drum for the latest month as default data
                updateTotalDrumForLatestMonth();


            </script>

            <!--BAR CHART FOR MONTH-->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
            <script>
                // PHP to fetch data
                <?php
                $sql = "SELECT SUM(paintYield) AS totalPaintYield, SUM(acetateYield) AS totalAcetateYield, DATE_FORMAT(date, '%Y-%m') AS month_year FROM tbl_entry GROUP BY month_year";
                $result = mysqli_query($con, $sql);
                $data = [];
                while ($row = mysqli_fetch_array($result)) {
                    $data[] = $row;
                }
                ?>

                // JavaScript to format data for Chart.js
                var months = [];
                var totalPaintYields = [];
                var totalAcetateYields = [];

                <?php foreach ($data as $row): ?>                 months.push('<?php echo $row['month_year']; ?>'); totalPaintYields.push(<?php echo $row['totalPaintYield']; ?>); totalAcetateYields.push(<?php echo $row['totalAcetateYield']; ?>);
                <?php endforeach; ?>

                var ctx = document.getElementById('yieldChart').getContext('2d');

                var yieldChart;

                function filterData() {
                    var minDate = document.getElementById('min2').value;
                    var maxDate = document.getElementById('max2').value;

                    var filteredMonths = [];
                    var filteredPaintYields = [];
                    var filteredAcetateYields = [];

                    for (var i = 0; i < months.length; i++) {
                        if (months[i] >= minDate && months[i] <= maxDate) {
                            filteredMonths.push(months[i]);
                            filteredPaintYields.push(totalPaintYields[i]);
                            filteredAcetateYields.push(totalAcetateYields[i]);
                        }
                    }

                    yieldChart.data.labels = filteredMonths;
                    yieldChart.data.datasets[0].data = filteredPaintYields;
                    yieldChart.data.datasets[1].data = filteredAcetateYields;
                    yieldChart.update();
                }

                // Attach event listeners to date inputs to trigger filtering in real-time
                document.getElementById('min2').addEventListener('input', filterData);
                document.getElementById('max2').addEventListener('input', filterData);

                yieldChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Total Paint Yield',
                            backgroundColor: 'rgba(255, 99, 132, 0.4)',
                            borderColor: 'rgba(255, 99, 132, 2)',
                            borderWidth: 1,
                            data: totalPaintYields
                        }, {
                            label: 'Total Acetate Yield',
                            backgroundColor: 'rgba(54, 162, 235, 0.4)',
                            borderColor: 'rgba(54, 162, 235, 2)',
                            borderWidth: 1,
                            data: totalAcetateYields
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>



            <!--FOR PIE CHART-->
            <script type="text/javascript">
                google.charts.load('current', { 'packages': ['corechart'] });
                google.charts.setOnLoadCallback(drawCharts);

                function drawCharts() {
                    drawPieChart();
                }

                // PHP to fetch data
                <?php
                $sql = "SELECT
                paint.paint_color,
                SUM(entry.totalPliter) AS totalPliter
                FROM tbl_entry AS entry
                LEFT JOIN tbl_paint AS paint ON entry.paintID = paint.paintID
                GROUP BY paint.paint_color";

                $result = mysqli_query($con, $sql);
                $data = [];
                while ($row = mysqli_fetch_array($result)) {
                    $data[] = $row;
                }
                ?>

                function drawPieChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Category', 'PaintLiters'],
                        <?php foreach ($data as $row): ?>['<?php echo $row['paint_color']; ?>', <?php echo $row['totalPliter']; ?>],
                        <?php endforeach; ?>
                    ]);

                    var colors = {
                        'Royal Blue': '#063970',
                        'Pulsating Blue': '#01acfb',
                        'Delft Blue': '#416D8C',
                        'Nile Green': '#76a85c',
                        'Black': 'black',
                        'Emerald Green': '#004d24',
                        'Jade Green': '#00A36C',
                        'White': 'white',
                        'Alpha Gray': '#71797E',
                        'Clear': '#faf1d7',
                        'Golden Brown': '#b08202',
                        'Buff': '#e2cc82'
                        // Add more color mappings as needed
                    };

                    var options = {
                        title: 'Paint usage Distribution per color',
                        titleTextStyle: { fontSize: 20, textAlign: 'center', titlePosition: 'center', marginBottom: 20 }, // Adjust title font size, alignment, and margin bottom
                        slices: {},
                        pieSliceText: 'percentage', // Display percentage in pie slices
                        legend: { position: 'right' }, // Show legend on the right side
                        legendTextStyle: { color: 'black', fontSize: 16 }, // Adjust legend text color and size
                        pieSliceTextStyle: { color: 'black', fontSize: 14 }, // Adjust pie slice text size
                        chartArea: { width: '100%', height: '90%' }, // Adjust pie chart dimensions
                        backgroundColor: '#ACE2E1', // Set background color
                        pieSliceText: 'value-and-percentage', // Display value and percentage
                        pieSliceTextStyle: { fontSize: 14 } // Adjust pie slice text size
                    };

                    for (var i = 0; i < data.getNumberOfRows(); i++) {
                        var paintColor = data.getValue(i, 0);
                        var paintLiters = data.getValue(i, 1);
                        options.slices[i] = { color: colors[paintColor] };
                        options.slices[i].label = paintColor + ': ' + paintLiters.toFixed(2) + ' Liters'; // Add paint color and liters to legend
                    }

                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                    chart.draw(data, options);
                }
            </script>


            <!-- FOR AREA CHART / line chart SCRIPT -->
            <script>
                // PHP to fetch data
                <?php
                $sql = "SELECT paintYield, acetateYield, date FROM tbl_entry";
                $result = mysqli_query($con, $sql);
                $data = [];
                while ($row = mysqli_fetch_array($result)) {
                    $data[] = $row;
                }
                ?>

                // JavaScript to format data for Chart.js
                var dates = [];
                var paintYields = [];
                var acetateYields = [];

                <?php foreach ($data as $row): ?>                 dates.push('<?php echo $row['date']; ?>'); paintYields.push(<?php echo $row['paintYield']; ?>); acetateYields.push(<?php echo $row['acetateYield']; ?>);
                <?php endforeach; ?>

                var ctx = document.getElementById('areaChart').getContext('2d');
                var areaChart;

                function filterData() {
                    var minDate = document.getElementById('min').value;
                    var maxDate = document.getElementById('max').value;

                    var filteredDates = [];
                    var filteredPaintYields = [];
                    var filteredAcetateYields = [];

                    for (var i = 0; i < dates.length; i++) {
                        if (dates[i] >= minDate && dates[i] <= maxDate) {
                            filteredDates.push(dates[i]);
                            filteredPaintYields.push(paintYields[i]);
                            filteredAcetateYields.push(acetateYields[i]);
                        }
                    }

                    areaChart.data.labels = filteredDates;
                    areaChart.data.datasets[0].data = filteredPaintYields;
                    areaChart.data.datasets[1].data = filteredAcetateYields;
                    areaChart.update();
                }

                // Attach event listeners to date inputs to trigger filtering in real-time
                document.getElementById('min').addEventListener('input', filterData);
                document.getElementById('max').addEventListener('input', filterData);

                areaChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Paint Yield',
                            backgroundColor: 'rgba(255, 99, 132, 0.4)',
                            borderColor: 'rgba(255, 99, 132, 2)',
                            borderWidth: 1,
                            data: paintYields,
                            fill: true
                        }, {
                            label: 'Acetate Yield',
                            backgroundColor: 'rgba(54, 162, 235, 0.4)',
                            borderColor: 'rgba(54, 162, 235, 2)',
                            borderWidth: 1,
                            data: acetateYields,
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            </script>


            <!--FOR DATA ENTRY Script-->
            <script>
                document.getElementById('dataentry').addEventListener('click', function () {
                    var initialmodal = new bootstrap.Modal(document.getElementById('initialmodal'));
                    initialmodal.show();
                })
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

            <!-- FOR clickable image dropdown SCRIPT-->
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


            <!--FOR SIDEBAR SCRIPT-->
            <script>
                var hamburger = document.querySelector(".hamburger");
                hamburger.addEventListener("click", function () {
                    document.querySelector("body").classList.toggle("active");
                })
            </script>

            <!--FOR LOGOUT SCRIPT-->
            <script>
                // Show the logout modal when the logout button is clicked
                document.getElementById('logoutButton').addEventListener('click', function () {
                    var myModal = new bootstrap.Modal(document.getElementById('logoutModal'));

                    // Save the current selected value before showing the modal
                    var select = document.querySelector('.dropdown');
                    var currentSelectedValue = select.value;

                    // Show the modal
                    myModal.show();

                    // Attach an event listener to handle modal dismissal
                    myModal._element.addEventListener('hidden.bs.modal', function () {
                        // Check if the user clicked "No" or closed the modal
                        var selectedOption = document.querySelector('.dropdown option[value="admin"]');
                        if (selectedOption) {
                            // Set the select option back to the default (admin)
                            selectedOption.selected = false;
                        }
                    });
                });
            </script>
</body>

</html>