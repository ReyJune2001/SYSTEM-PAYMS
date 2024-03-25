<!--FOR ADMIN PROFILE-->
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



if (isset ($_GET['data-entry-id'])) {
    $id = $_GET['data-entry-id'];
    // Fetch the data corresponding to the entry ID

    $sql = "SELECT
                paint.paint_color,
                supplier.supplier_name, supplier.newSupplier_name,
                customer.customer_name,
                entry.*
            FROM tbl_entry AS entry
            LEFT JOIN tbl_paint AS paint ON entry.paintID = paint.paintID
            LEFT JOIN tbl_supplier AS supplier ON paint.supplierID = supplier.supplierID
            LEFT JOIN tbl_customer AS customer ON entry.customerID = customer.customerID
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
    $EndingpaintRatio = $EndingacetateRatio = $paintYield = $acetateYield = $remarks = $DetailsID = $supplierID = $receiveID = $details = $receiver_name = '';

if (isset ($_POST['submit'])) {
    $date = $_POST['date'];
    $paint_color = $_POST['paint_color'];
    $supplier_name = $_POST['supplier_name'];
    $batchNumber = $_POST['batchNumber'];
    $diameter = $_POST['diameter'];
    $height = $_POST['height'];
    $paintRatio = $_POST['paintRatio'];
    $acetateRatio = $_POST['acetateRatio'];
    $newSupplier_name = $_POST['newSupplier_name'];
    $NewacetateL = isset ($_POST['NewacetateL']) ? $_POST['NewacetateL'] : '';
    $NewpaintL = isset ($_POST['NewpaintL']) ? $_POST['NewpaintL'] : '';
    $sprayViscosity = $_POST['sprayViscosity'];
    $customer_name = isset ($_POST['customer_name']) ? $_POST['customer_name'] : '';
    $quantity = $_POST['quantity'];
    $Endingdiameter = $_POST['Endingdiameter'];
    $Endingheight = $_POST['Endingheight'];
    $EndingpaintRatio = $_POST['EndingpaintRatio'];
    $EndingacetateRatio = $_POST['EndingacetateRatio'];
    $paintYield = $_POST['paintYield'];
    $acetateYield = $_POST['acetateYield'];



    /*Para nga ma-insert ang mga data sa mga tables, kinahanglan
    na mag insert ka nga magkasunod-sunod og foreign key, dependi kong unsay
    una nga table with foreign key */

    // Insert into tbl_customer
    $sql = "INSERT INTO `tbl_customer` (customer_name, userID) VALUES ('$customer_name', '$id')";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die (mysqli_error($con));
    }

    // Get the customerID of the newly inserted customer
    $customerID = mysqli_insert_id($con);

    // Insert into tbl_supplier
    $sql = "INSERT INTO `tbl_supplier` (supplier_name, newSupplier_name) VALUES ('$supplier_name', '$newSupplier_name')";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die (mysqli_error($con));
    }

    // Get the supplierID of the newly inserted supplier
    $supplierID = mysqli_insert_id($con);

    // Insert into tbl_paint
    $sql = "INSERT INTO `tbl_paint` (paint_color, supplierID) VALUES ('$paint_color', '$supplierID')";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die (mysqli_error($con));
    }

    // Get the paintID of the newly inserted paint
    $paintID = mysqli_insert_id($con);

    // Insert into tbl_entry
    $sql = "INSERT INTO `tbl_entry` (userID, customerID, paintID, date, batchNumber, diameter, height, paintRatio, acetateRatio, NewacetateL, NewpaintL, sprayViscosity, quantity, Endingdiameter, Endingheight, EndingpaintRatio, EndingacetateRatio, paintYield, acetateYield, remarks)
    VALUES ('$id', '$customerID', '$paintID', '$date', '$batchNumber', '$diameter', '$height', '$paintRatio', '$acetateRatio', '$NewacetateL', '$NewpaintL', '$sprayViscosity', '$quantity', '$Endingdiameter', '$Endingheight', '$EndingpaintRatio', '$EndingacetateRatio', '$paintYield', '$acetateYield', '$remarks')";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        die (mysqli_error($con));
    }

    // Get the EntryID of the newly inserted Entry
    $EntryID = mysqli_insert_id($con);

}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--FOR FONT STYLE-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:wght@700&family=Noto+Serif+Makasar&family=Pattaya&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:wght@700&family=Noto+Serif+Makasar&family=Pattaya&family=Tiro+Kannada:ital@0;1&display=swap" rel="stylesheet">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <title>Paint-Acetate Data Entry</title>
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
            margin-top: 0px;

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

        /*ADMIN PROFILE STYLES*/
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


        /*MAIN CONTENT */

        .main1 {
            background-color: gray;
            padding: 3%;

            flex: 1 1 150px;
            margin-top: 20px;
            margin-left: 30px;
            height: 100%;
        }



        .main2 {
            display: flex;
            flex: 1;
            padding-top: 2%;
            padding-bottom: 2%;
            height: 100%;

        }

        header {
            font-family: "Pattaya", sans-serif;
            font-size: 40px;
            padding-bottom: 1%;
            text-align: center;
            color: white;
        }

        main {
            
            background-color: gray;
            flex: 1 1 110px;
            text-align: center;

        }

        .right {
            height: 190px;
            background-color: rgb(0, 255, 38);
            padding: 3em 0 3em 0;
            flex: 1 1 20px;
            margin-right: auto;
            text-align: center;
            border-radius: 20px;
            
            background-image: url('IMAGES/morningbackground.jpg'); /* Replace 'path/to/your/image.jpg' with the actual path to your image */
            background-size: cover; /* Ensures the background image covers the entire box */
            background-repeat: no-repeat; /* Prevents the background image from repeating */
            background-position: center; /* Centers the background image */
            background-size: cover;
            
        }

        /* Pseudo-element for dark opacity */
.right::before {
    content: '';
    position: absolute;
    top: 276px;
    left: 1222px;
    width: 745px;
    height: 190px;
    background-color: rgba(0, 0, 0, 0.2); /* Adjust the opacity level as needed */
    border-radius: inherit; /* Inherit border-radius from parent */
}
        .morning{
            font-family: "Pattaya", sans-serif;
        }
        footer {
            background-color: darkcyan;
            text-align: center;

            padding: 2em 0 2em 0;

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

         /* FOR CLOCK */

         .clockcontainer {
            width: 295px;
            height: 180px;
            position: absolute;
            top: 51%;
            left: 79%;
            transform: translate(-50%, -50%);


        }

        .clock {

            
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .clock span {
            font-weight: bold;
            font-size: 30px;
            width: 30px;
            display: inline-block;
            text-align: center;
            position: relative;
        }
        #ampm{
            margin-left: 10px;
        }

        /*FOR DATA ENTRY */
        .modal-body {

            background-color: rgb(225, 225, 212);

        }

        .initial {
            display: flex;
            flex: 1;
            padding-top: 2%;
            padding-bottom: 2%;
            height: 100%;
            background-color: #87ceeb;
            /*#98fb98 */
        }


        .styleform {
            width: 25%;
            height: 35px;
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
            height: 100%;
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

        .vertical-line1 {
            width: 4px;
            /* Adjust the width of the line as needed */
            height: 15vh;
            /* Sets the height to be the full height of the viewport */
            background-color: gray;
            /* Change the color of the line */
            position: absolute;

            left: 1011px;
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

            width: 25%;
            height: 80px;
            margin-top: 20px;
            padding-left: -10px;

            border: 2px solid #6be87a;
            text-align: center;
        }

        .boxYield {
            background-color: white;
        }


        /*for collapsible drawer */
        /* Custom styles for collapsible drawer */
        #drawer.drawer.p-2 {
            margin-top: 222px;
        }

        .drawer {
            position: absolute;
            right: 35px;
            /* Adjusted position to move drawer closer to the middle */
            transform: translateY(-50%);
            width: 600px;
            height: 300px;
            padding: 20px;
            background-color: rgb(5, 68, 104);
            /* Change this to your desired background color */
            border-left: 1px solid #dee2e6;
            /* Add border for separation */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add shadow for visual effect */
            transition: right 0.3s ease;
        }

        /*for close drawer */
        .drawer.open {
            right: 356px;

        }

        .toggle-drawer {
            position: absolute;
            top: 50%;
            right: -50px;
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

        .M-container {
        
         display: flex;
         flex-direction: row; /* Boxes will be arranged horizontally */
         align-items: center; /* Center vertically on the cross axis */
         
         background-color: gray;
         
        }


        .xbox1 {
        width: 50%;
        height: 190px;
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
        height: 190px;
        padding: 10px;
        padding-left: 10px;
        margin-right: 18px;
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
        border-radius: 20px;
        
        }
        .xbox3 {
        width: 30%;
        height: 190px;
        padding: 10px;
        padding-left: 10px;
        margin-right: 18px;
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
        border-radius: 20px;
        
        }

        .xbox4 {
        width: 820px;
        height: 500px;
        margin-top:20px;
        text-align: center;
        border-radius: 20px;
        padding-left: 10px;
        padding-right: 10px;
        }

        .xbox5 {
        margin-top: 68px;
        width: 100%;
        height: 500px;
        text-align: center;
        border-radius: 20px;
        margin-bottom: 20px;
        }
        .xbox6 {
        margin-top:20px;
        width: 820px;
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
        margin-top:20px;
        width: 820px;
        height: 515px;
        text-align: center;
        border-radius: 20px;
        margin-bottom: 20px;
        margin-left: 25%;
        
        }

        .box1 {
            background-color: white;
        }
 

        .box2 {
        
        background-image: url('IMAGES/dataentry.png'); /* Replace 'path/to/your/image.jpg' with the actual path to your image */
        background-size: cover; /* Ensures the background image covers the entire box */
        background-repeat: no-repeat; /* Prevents the background image from repeating */
        background-position: center; /* Centers the background image */
        background-size: 100px;
        background-color: white;
        }

        .box3 {
        background-color: white;
        
        }
        .box4 {
        background-color: white;
        
        }
        .box5 {
        background-color:white;
        
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
        .filterfieldMonth{
            
            width: 150px;
            height: 30px;
            margin-left: 2%;
            background-color: white;
            border-color: #86b7fe;
            border-radius: 5px;
            margin-top: 10px;
        }

         /* Style for individual items */
         .item {
            width: 700px;
            /* Set width for each item */
            height: 500px;
            /* Set height for each item */  
        }
        
     

        #piechart{
            margin-left:50px;
            padding-right: 20px;
            width: 100%;
            height: 500px;
        }
       


        /*FOR SYSTEM RESPONSIVE */
    </style>
</head>

<body>
    <div class="wrapper">

        <div class="section">

            <div class="admin_profile">

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



            <!--MAIN CONTENT-->
            <div class="main1">
                <header><h3 style="font-size:50px;">Paint - Acetate Yield Monitoring System</h3></header>
                <div class="main2">
                    
                    <main>
                    <div class="M-container">
                    <div class="xbox1 box1">
                    <h5 style="">Total Drum Painted</h5>
                    <label style="margin-left:2%;">From month:</label>
                    <input type="month" style="text-align: center;" class="filterfieldMonth" id="fromMonth" name="fromMonth" autocomplete="off">
                    <br>
                    <label style="margin-left:20px;">To month:</label>
                    <input type="month" style="text-align: center;" class="filterfieldMonth" id="toMonth" name="toMonth" autocomplete="off">
                    <br>
                    <input type="number" style="width:250px; height:50px; margin-top:10px; text-align:center; font-size:20px;" id="totalDrumOutput" readonly>
                </div>
                        <div class="xbox2 box2">
                        <h5 style="">Data Entry</h5>
                            <button type="button" class="btn btn-primary" style="height:45px; width:45px; border-radius:50px; margin-top:55px; margin-left:50px;" id="dataentry">
                            <i class="fa-solid fa-plus" style="font-size:20px;"></i></button>
                            <h6 style="margin-bottom:0px;">Total Entries:</h6>
                            <input type="number" style=" width:150px;height:16px; margin-bottom:5px;text-align:center; background-color:; font-size:15px;">

                        </div>
                        <div class="xbox3 box3">
                        <h5 style="margin-left:12px;">Yield</h5>
                        <label style="margin-left:20px;">Paint&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acetate
                        <span class="vertical-line1" style="margin-left:90px;"></span></label>
                        <br>
                        <input type="number"
                         style="text-align: center; background-color:; height:50px; margin-left:20px; font-size: 20px; width: 32%; border: none !important; outline: none !important;">

                         <input type="number"
                         style="text-align: center; background-color:; margin-left:40px; height:50px; font-size: 20px; width: 32%;  border: none !important; outline: none !important;">
                        </div>
                    </div>

                    <div class="xbox4 box4">
                        <h4>Daily Report</h4>
                    
                        <canvas id="areaChart"></canvas>
                        <label style="margin-left:2%;">From date:</label>
                        <input type="date" style="text-align: center;" class="filterfield" id="min" name="min" autocomplete="off">
                        <label style="margin-left:3%;">To date:</label>
                        <input type="date" style="text-align: center;" class="filterfield" id="max" name="max" autocomplete="off">
                    </div>
                    <div class="xbox6 box6">
                    <h4>Weekly Report</h4>
                    <canvas id="weeklyChart"></canvas>
                    <label style="margin-left:2%;">Select Month to show Weekly data:</label>
                    <input type="month" style="text-align: center;" class="filterfield" id="selectedMonth" name="selectedMonth" autocomplete="off" required>
                </div>
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
                                                        <label>Date:</label>
                                                        <input type="date" style="text-align: center;" class="styleform"
                                                            name="date" value="<?php echo $date; ?>" required>

                                                        <label style="margin-left:6%;">Diameter:</label>
                                                        <input type="number" style="text-align: center;"
                                                            class="styleform" name="diameter" min="0" step="any"
                                                            placeholder="diameter" value="<?php echo $diameter; ?>"
                                                            required>
                                                        <br>
                                                        <label style="">Paint Color:</label>
                                                        <select name="paint_color"
                                                            style="text-align: center; margin-right:4%;"
                                                            class="styleform" required>
                                                            <option value="">------ Select ------</option>
                                                            <option value="Royal Blue" <?php if ($paint_color == 'Royal Blue')
                                                                echo 'selected'; ?>>Royal Blue</option>
                                                            <option value="Deft Blue" <?php if ($paint_color == 'Deft Blue')
                                                                echo 'selected'; ?>>Deft Blue</option>
                                                            <option value="Buff" <?php if ($paint_color == 'Buff')
                                                                echo 'selected'; ?>>Buff
                                                            </option>
                                                            <option value="Golden Brown" <?php if ($paint_color == 'Golden Brown')
                                                                echo 'selected'; ?>>Golden Brown</option>
                                                            <option value="Clear" <?php if ($paint_color == 'Clear')
                                                                echo 'selected'; ?>>Clear
                                                            </option>
                                                            <option value="White" <?php if ($paint_color == 'White')
                                                                echo 'selected'; ?>>White
                                                            </option>
                                                            <option value="Black" <?php if ($paint_color == 'Black')
                                                                echo 'selected'; ?>>Black
                                                            </option>
                                                            <option value="Alpha Gray" <?php if ($paint_color == 'Alpha Gray')
                                                                echo 'selected'; ?>>Alpha Gray</option>
                                                            <option value="Nile Green" <?php if ($paint_color == 'Nile Green')
                                                                echo 'selected'; ?>>Nile Green</option>
                                                            <option value="Emirald Green" <?php if ($paint_color == 'Emirald Green')
                                                                echo 'selected'; ?>>Emirald Green</option>
                                                            <option value="Jade Green" <?php if ($paint_color == 'Jade Green')
                                                                echo 'selected'; ?>>Jade Green</option>
                                                        </select>
                                                        <label style="margin-left:4%;">Height:</label>
                                                        <input type="number"
                                                            style="text-align: center; margin-right:6%;"
                                                            class="styleform" name="height" min="0" step="any"
                                                            placeholder="height" value="<?php echo $height; ?>"
                                                            required>
                                                        <br>
                                                        <label
                                                            style="text-align: center; margin-left:73px;">Supplier:</label>
                                                        <select name="supplier_name" style="text-align: center; "
                                                            class="styleform" required>
                                                            <option value="">------ Select ------</option>
                                                            <option value="Nippon" <?php if ($supplier_name == 'Nippon')
                                                                echo 'selected'; ?>>
                                                                Nippon</option>
                                                            <option value="Treasure Island" <?php if ($supplier_name == 'Treasure Island')
                                                                echo 'selected'; ?>>Treasure Island</option>
                                                            <option value="Inkote" <?php if ($supplier_name == 'Inkote')
                                                                echo 'selected'; ?>>
                                                                Inkote</option>
                                                            <option value="Century" <?php if ($supplier_name == 'Century')
                                                                echo 'selected'; ?>>
                                                                Century</option>
                                                        </select>

                                                        <label style="margin-left:5%;">Paint ratio:</label>
                                                        <input type="number"
                                                            style="text-align: center; margin-right:13%;"
                                                            class="styleform" name="paintRatio" min="0" step="any"
                                                            placeholder="paint ratio" value="<?php echo $paintRatio; ?>"
                                                            required>
                                                        <br>
                                                        <label style="margin-left:5%;">Batch No:</label>
                                                        <input type="number" style="text-align: center;"
                                                            class="styleform" name="batchNumber"
                                                            placeholder="batch number"
                                                            value="<?php echo $batchNumber; ?>" required>

                                                        <label style="margin-left:3%;">Acetate ratio:</label>
                                                        <input type="number"
                                                            style="text-align: center; margin-right:9%;"
                                                            class="styleform" name="acetateRatio" min="0" step="any"
                                                            placeholder="acetate ratio"
                                                            value="<?php echo $acetateRatio; ?>" required>
                                                        <br><br>

                                                        <hr style="border-top: 5px solid black;">
                                                        <br>

                                                        <div class="ending">
                                                            <button type="button" class="btn btn-primary"
                                                                id="toggleEndingInventory"
                                                                style="font-size:20px;margin-left:px;width:30%;">
                                                                Ending Inventory
                                                            </button>
                                                        </div>
                                                        <br>
                                                        <!-- "Ending Inventory" section -->
                                                        <div class="collapse" id="collapseEndingInventory">
                                                            <div class="card card-body"
                                                                style="background-color:#87ceeb; border:none;">
                                                                <div class="form-column">
                                                                    <label style="margin-left:;">Diameter:</label>
                                                                    <input type="number" style="text-align: center;"
                                                                        class="styleform" name="Endingdiameter" min="0"
                                                                        step="any" placeholder="diameter"
                                                                        value="<?php echo $Endingdiameter; ?>" required>


                                                                    <label style="margin-left:8%">Height:</label>
                                                                    <input type="number"
                                                                        style="text-align: center; margin-right:4%;"
                                                                        class="styleform" name="Endingheight" min="0"
                                                                        step="any" placeholder="height"
                                                                        value="<?php echo $Endingheight; ?>" required>
                                                                    <br>

                                                                    <label style="margin-left:1%;">Paint ratio:</label>
                                                                    <input type="number" style="text-align: center;"
                                                                        class="styleform" name="EndingpaintRatio"
                                                                        min="0" step="any" placeholder="paint ratio"
                                                                        value="<?php echo $EndingpaintRatio; ?>"
                                                                        required>

                                                                    <label style="margin-left:3%;">Acetate
                                                                        ratio:</label>
                                                                    <input type="number"
                                                                        style="text-align: center; margin-right:6%;"
                                                                        class="styleform" name="EndingacetateRatio"
                                                                        min="0" step="any" placeholder="acetate ratio"
                                                                        value="<?php echo $EndingacetateRatio; ?>"
                                                                        required>
                                                                    <br><br>
                                                                </div>
                                                            </div>
                                                        </div>


                                                                    <div class="newpaintmix">
                                                                        <h4>New Paint Mix</h4>
                                                                    </div>
                                                                    <br>

                                                                    <label style="margin-left:6%;">Supplier:</label>
                                                                    <select name="newSupplier_name" min="0" step="any"
                                                                        style="text-align: center;" class="styleform"
                                                                        required>
                                                                        <option value="">------ Select ------</option>
                                                                        <option value="Nippon" <?php if ($newSupplier_name == 'Nippon')
                                                                            echo 'selected'; ?>>Nippon</option>
                                                                        <option value="Treasure Island" <?php if ($newSupplier_name == 'Treasure Island')
                                                                            echo 'selected'; ?>>Treasure Island</option>
                                                                        <option value="Inkote" <?php if ($newSupplier_name == 'Inkote')
                                                                            echo 'selected'; ?>>Inkote</option>
                                                                        <option value="Century" <?php if ($newSupplier_name == 'Century')
                                                                            echo 'selected'; ?>>Century</option>
                                                                    </select>

                                                                    <label style="margin-left:1%;">Spay
                                                                        Viscosity:</label>
                                                                    <input type="number"
                                                                        style="text-align: center; margin-right:9%;"
                                                                        class="styleform" name="sprayViscosity" min="0"
                                                                        step="any" placeholder="spray viscosity"
                                                                        value="<?php echo $sprayViscosity; ?>" required>

                                                                    <br>

                                                                    <label>Paint (L):</label>
                                                                    <input type="number" style="text-align: center;"
                                                                        class="styleform" name="NewpaintL" min="0"
                                                                        step="any" placeholder="paint liter"
                                                                        value="<?php echo $NewpaintL; ?>" required>

                                                                    <label style="margin-left:30px;">Acetate
                                                                        (L):</label>
                                                                    <input type="number"
                                                                        style="text-align: center;margin-right:3%;"
                                                                        class="styleform" name="NewacetateL" min="0"
                                                                        step="any" placeholder="acetate liter"
                                                                        value="<?php echo $NewacetateL; ?>" required>

                                                                    <br><br>

                                                                    <div class="productionOutput">
                                                                        <h4>Production Output</h4>
                                                                    </div>
                                                                    <br>

                                                                    <label style="margin-left:2%;">Customer:</label>
                                                                    <input type="text" style="text-align: center;"
                                                                        class="styleform" name="customer_name"
                                                                        placeholder="customer"
                                                                        value="<?php echo $customer_name; ?>" required>

                                                                    <label style="margin-left:6%;">Quantity:</label>
                                                                    <input type="number"
                                                                        style="text-align: center; margin-right:5%;"
                                                                        class="styleform" name="quantity" min="0"
                                                                        step="any" placeholder="quantity"
                                                                        value="<?php echo $quantity; ?>" required>
                                                                    <br><br>
                                                              

                                                        <div class="yield">
                                                            <h4>Yield</h4>
                                                        </div>

                                                        <div class="boxstyle">
                                                            <div class="mainbox boxYield">
                                                                <label
                                                                    style="margin-left:17px;">Paint&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acetate<span
                                                                        class="vertical-line"></span></label><br>
                                                                <input type="number"
                                                                    style="text-align: center; margin-left:21px; width: 35%; border: none !important; outline: none !important;"
                                                                    class="readonlyInput styleform" id="paintYield"
                                                                    min="0" step="any" name="paintYield"
                                                                    value="<?php echo $paintYield; ?>" readonly>

                                                                <input type="number"
                                                                    style="text-align: center; margin-left:25px; width: 35%; border: none !important; outline: none !important;"
                                                                    class="readonlyInput styleform" id="acetateYield"
                                                                    min="0" step="any" name="acetateYield"
                                                                    value="<?php echo $acetateYield; ?>" readonly>
                                                            </div>
                                                        </div>

                                                        <br><br>
                                                        <button type="submit" id="update" class="btn btn-primary btn-lg"
                                                            name="submit"
                                                            style="font-size:20px; border-radius:50px; border-color:white; width:30%; padding-top:1%;padding-bottom:1%;">Add</button>


                                                    </div>


                                                </div>
                                            </fieldset>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </main>
                    
                    <aside class="right">
                        <h1 class="morning" style="margin-bottom:10px;">Good Morning, <?php echo $Name; ?> !</h1>
                        
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
                    <!-- Date -->
                    
                    <h2 style="font-size:30px; font-weight: bold;"><?php echo date("l, F j, Y"); ?></h2>
                    
                <div class="xbox5 box5">
                    <!-- FOR PIE CHART -->
                    <div class="item">
                        <div id="piechart"></div>
                    </div>
                </div>

                    <div class="xbox7 box7">
                        <h4>Monthly Report</h4>
                        <!-- FOR MONTHLY BAR CHART -->
                        <canvas id="yieldChart"></canvas>
                        <label style="margin-left:2%;">From date:</label>
                        <input type="month" style="text-align: center; margin-top:25px;" class="filterfield" id="min2" name="min2" autocomplete="off">
                        <label style="margin-left:3%;">To date:</label>
                        <input type="month" style="text-align: center; margin-top:25px;" class="filterfield" id="max2" name="max2" autocomplete="off">
                    
                    </div>
                
                    </aside>
                </div>
                <div class="xbox8 box8">
                <h4 style="margin-left:px;">Yearly Report</h4>
                <!-- FOR YEARLY BAR CHART -->
                <canvas id="yearlyChart"></canvas>
                <label style="margin-left:2%;">From year:</label>
                <input type="number" style="text-align: center;" class="filterfield" id="from" name="from" autocomplete="off" placeholder="year">
                <label style="margin-left:3%;">To year:</label>
                <input type="number" style="text-align: center;" class="filterfield" id="to" name="to" autocomplete="off" placeholder="year">
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

                </ul>

            </div>


        </div>


    </div>


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
    
    <?php foreach ($data as $row): ?>
        years.push('<?php echo $row['year']; ?>');
        totalPaintYields.push(<?php echo $row['totalPaintYield']; ?>);
        totalAcetateYields.push(<?php echo $row['totalAcetateYield']; ?>);
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
    // PHP to fetch data
    <?php
    $sql = "SELECT SUM(paintYield) AS totalPaintYield, SUM(acetateYield) AS totalAcetateYield, DATE_FORMAT(date, '%Y-%m-%v') AS week_year FROM tbl_entry GROUP BY week_year";
    $result = mysqli_query($con, $sql);
    $data = [];
    while ($row = mysqli_fetch_array($result)) {
        $data[] = $row;
    }
    ?>

    // JavaScript to format data for Chart.js
    var weeks = [];
    var totalPaintYields = [];
    var totalAcetateYields = [];

    <?php foreach ($data as $row): ?>
        weeks.push('<?php echo $row['week_year']; ?>');
        totalPaintYields.push(<?php echo $row['totalPaintYield']; ?>);
        totalAcetateYields.push(<?php echo $row['totalAcetateYield']; ?>);
    <?php endforeach; ?>

    var ctx = document.getElementById('weeklyChart').getContext('2d');
    var weeklyChart;

    function filterData() {
        var selectedMonth = document.getElementById('selectedMonth').value;
        
        var filteredWeeks = [];
        var filteredPaintYields = [];
        var filteredAcetateYields = [];

        for (var i = 0; i < weeks.length; i++) {
            if (weeks[i].startsWith(selectedMonth)) {
                filteredWeeks.push(weeks[i]);
                filteredPaintYields.push(totalPaintYields[i]);
                filteredAcetateYields.push(totalAcetateYields[i]);
            }
        }

        weeklyChart.data.labels = filteredWeeks;
        weeklyChart.data.datasets[0].data = filteredPaintYields;
        weeklyChart.data.datasets[1].data = filteredAcetateYields;
        weeklyChart.update();
    }

    // Attach event listener to month input to trigger filtering in real-time
    document.getElementById('selectedMonth').addEventListener('change', filterData);

    weeklyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: weeks,
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

<!--TOTAL DRUM PAINTED-->
<script>
    // Function to fetch data from PHP
    function fetchData() {
        <?php
        $sql = "SELECT SUM(quantity) AS totalPaintDrum, DATE_FORMAT(date, '%Y-%m') AS month_year FROM tbl_entry GROUP BY month_year";
        $result = mysqli_query($con, $sql);
        $data = [];
        while ($row = mysqli_fetch_array($result)) {
            $data[] = $row;
        }
        ?>

        var drumData = <?php echo json_encode($data); ?>;
        return drumData;
    }

    // Function to calculate total drum count for the selected range of months
    function calculateTotalDrum(data, fromMonth, toMonth) {
        var totalDrum = 0;
        for (var i = 0; i < data.length; i++) {
            if (data[i].month_year >= fromMonth && data[i].month_year <= toMonth) {
                totalDrum += parseInt(data[i].totalPaintDrum);
            }
        }
        return totalDrum;
    }

    // Function to update total drum count
    function updateTotalDrum() {
        var fromMonth = document.getElementById('fromMonth').value;
        var toMonth = document.getElementById('toMonth').value;
        var drumData = fetchData(); // Fetch data from PHP

        var totalDrum = calculateTotalDrum(drumData, fromMonth, toMonth);
        document.getElementById('totalDrumOutput').value = totalDrum;
    }

    // Attach event listeners to month inputs to trigger updateTotalDrum function
    document.getElementById('fromMonth').addEventListener('input', updateTotalDrum);
    document.getElementById('toMonth').addEventListener('input', updateTotalDrum);

    // Initial call to updateTotalDrum to display initial total drum count
    updateTotalDrum();
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
    
    <?php foreach ($data as $row): ?>
        months.push('<?php echo $row['month_year']; ?>');
        totalPaintYields.push(<?php echo $row['totalPaintYield']; ?>);
        totalAcetateYields.push(<?php echo $row['totalAcetateYield']; ?>);
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
            <?php foreach ($data as $row): ?>
                ['<?php echo $row['paint_color']; ?>', <?php echo $row['totalPliter']; ?>],
            <?php endforeach; ?>
        ]);

        var options = {
            title: 'Total usage of Paint Color by liter'
        };

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
    
    <?php foreach ($data as $row): ?>
        dates.push('<?php echo $row['date']; ?>');
        paintYields.push(<?php echo $row['paintYield']; ?>);
        acetateYields.push(<?php echo $row['acetateYield']; ?>);
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

    <!--FOR REAL-TIME DATA OF YIELD-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add event listener to input fields for new paint and acetate liters
            ['NewpaintL', 'NewacetateL', 'quantity'].forEach(function (fieldName) {
                document.querySelector(`input[name="${fieldName}"]`).addEventListener('input', updateYield);
            });

            // Add event listener to input fields that affect yield calculations
            ['diameter', 'height', 'paintRatio', 'acetateRatio'].forEach(function (fieldName) {
                document.querySelector(`input[name="${fieldName}"]`).addEventListener('input', updateYield);
            });

            // Add event listener to input fields that affect yield calculations
            ['Endingdiameter', 'Endingheight', 'EndingpaintRatio', 'EndingacetateRatio'].forEach(function (fieldName) {
                document.querySelector(`input[name="${fieldName}"]`).addEventListener('input', updateYield);
            });
        });


        function updateYield() {
            var formData = new FormData(document.querySelector('form'));
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "calculate_yield.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.querySelector('input[name="paintYield"]').value = response.paintYield;
                    document.querySelector('input[name="acetateYield"]').value = response.acetateYield;
                }
            };
            xhr.send(formData);
        }

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