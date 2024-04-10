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

if (isset ($_GET['data-entry-id'])) {
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
    <meta charset="utf-8">
    <link rel="icon" href="IMAGES/faviconlogo.png" type="image/x-icon">
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
    <title>Data Entry</title>
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
            .endingstyle{
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
            .input-yield{
                display: flex;
                flex-direction: row;
                width: 20%;
            }
            .input{
                width: 82px;
                height: 40px;
                text-align: center;
                border:none;
                font-size: 20px;
            }
            input{
                border-color: white;
            }

             /*SUCCESSFUL MODAL */
            /* Customize modal styles */
            .custom-modal .modal-content {
                background-color:  #2eae3d;
                /* Background color */
                color: #fff;
                /* Text  color */
            }

            .custom-modal .modal-header {
                border-bottom: 1px solid  #2eae3d;
                /* Border color for the header */
            }

            /*HEADER MODAL OF UPDATE */
            .center-modal-title {
                font-size: 30px;
                margin-left: 175px;
            }

            .custom-modal .modal-footer {
                border-top: 1px solid  #2eae3d;
                /* Border color for the footer */
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
                                <div class="newpaintmix">
                                    <h4>Initial Inventory</h4>
                                </div>
                                <br>
                               <h6 style="text-align:left; margin-left: 20px; color:#484848;">Date:</h6>
                                <input type="date" style="text-align: center;" class="styleform"  name="date" value="<?php echo $date; ?>" required>
                                <input type="number" style="text-align: center;" class="styleform" name="diameter"
                                    min="0" step="any" placeholder="diameter" value="<?php echo $diameter; ?>" required>
                                <br>
                                
                                <select name="paint_color" style="text-align: center;"
                                    class="styleform" required>
                                    <option value="">-- Paint color --</option>
                                    <option value="Royal Blue" <?php if ($paint_color == 'Royal Blue')
                                        echo 'selected'; ?>>Royal Blue</option>
                                    <option value="Delft Blue" <?php if ($paint_color == 'Delft Blue')
                                        echo 'selected'; ?>>Delft Blue</option>
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
                                    <option value="Emerald Green" <?php if ($paint_color == 'Emerald Green')
                                        echo 'selected'; ?>>Emerald Green</option>
                                    <option value="Jade Green" <?php if ($paint_color == 'Jade Green')
                                        echo 'selected'; ?>>Jade Green</option>
                                    <option value="Pulsating Blue" <?php if ($paint_color == 'Pulsating Blue')
                                        echo 'selected'; ?>>Pulsating Blue</option>
                                </select>
                                
                                <input type="number" style="text-align: center;" class="styleform"
                                    name="height" min="0" step="any" placeholder="height" value="<?php echo $height; ?>"
                                    required>
                                <br>
                                
                                <select name="supplier_name" style="text-align: center; " class="styleform" required>
                                    <option value="">-- Supplier --</option>
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

                                <input type="number" style="text-align: center;" class="styleform"
                                    name="paintRatio" min="0" step="any" placeholder="paint ratio"
                                    value="<?php echo $paintRatio; ?>" required>
                                <br>

                                <input type="number" style="text-align: center;" class="styleform" name="batchNumber"
                                    placeholder="batch number" value="<?php echo $batchNumber; ?>" required>


                                <input type="number" style="text-align: center;" class="styleform"
                                    name="acetateRatio" min="0" step="any" placeholder="acetate ratio"
                                    value="<?php echo $acetateRatio; ?>" required>
                                <br><br>

                                <hr style="border-top: 5px solid black;">
                                <br>

                                <div class="ending">
                                    <button type="button" class="btn" id="toggleEndingInventory"
                                        style="font-size:20px;width:70%; background-color:#e3a242;">
                                        Ending Inventory
                                    </button>
                                </div>
                                <br>
                                <!-- "Ending Inventory" section -->
                                <div class="collapse" id="collapseEndingInventory">
                                    <div class="card card-body" style="background-color:#87ceeb; border:none;">
                                        <div class="form-column">
                                            
                                            <input type="number" style="text-align: center;" class="endingstyle"
                                                name="Endingdiameter" min="0" step="any" placeholder="diameter"
                                                value="<?php echo $Endingdiameter; ?>" required>


                                            
                                            <input type="number" style="text-align: center;"
                                                class="endingstyle" name="Endingheight" min="0" step="any"
                                                placeholder="height" value="<?php echo $Endingheight; ?>" required>
                                            <br>

                                           
                                            <input type="number" style="text-align: center;" class="endingstyle"
                                                name="EndingpaintRatio" min="0" step="any" placeholder="paint ratio"
                                                value="<?php echo $EndingpaintRatio; ?>" required>

                                           
                                            
                                            <input type="number" style="text-align: center;"
                                                class="endingstyle" name="EndingacetateRatio" min="0" step="any"
                                                placeholder="acetate ratio" value="<?php echo $EndingacetateRatio; ?>"
                                                required>
                                            <br><br>
                                        </div>
                                    </div>
                                </div>

                                <hr style="border-top: 5px solid black;">

                                <div class="newpaintmix">
                                    <h4>New Paint Mix</h4>
                                </div>
                                <br>

                                
                                <select name="newSupplier_name" min="0" step="any" style="text-align: center;"
                                    class="styleform" required>
                                    <option value="">-- Supplier --</option>
                                    <option value="Nippon" <?php if ($newSupplier_name == 'Nippon')
                                        echo 'selected'; ?>>Nippon</option>
                                    <option value="Treasure Island" <?php if ($newSupplier_name == 'Treasure Island')
                                        echo 'selected'; ?>>Treasure Island</option>
                                    <option value="Inkote" <?php if ($newSupplier_name == 'Inkote')
                                        echo 'selected'; ?>>Inkote</option>
                                    <option value="Century" <?php if ($newSupplier_name == 'Century')
                                        echo 'selected'; ?>>Century</option>
                                </select>

                           
                                <input type="number" style="text-align: center;" class="styleform"
                                    name="sprayViscosity" min="0" step="any" placeholder="spray viscosity"
                                    value="<?php echo $sprayViscosity; ?>" required>

                                <br>

                       
                                <input type="number" style="text-align: center;" class="styleform" name="NewpaintL"
                                    min="0" step="any" placeholder="paint liter" value="<?php echo $NewpaintL; ?>"
                                    required>


                                <input type="number" style="text-align: center;" class="styleform"
                                    name="NewacetateL" min="0" step="any" placeholder="acetate liter"
                                    value="<?php echo $NewacetateL; ?>" required>

                                <br><br>

                                <div class="productionOutput">
                                    <h4>Production Output</h4>
                                </div>
                                <br>

                               
                                <input type="text" style="text-align: center;" class="styleform" name="customer_name"
                                    placeholder="customer" value="<?php echo $customer_name; ?>" required>

                        
                                <input type="number" style="text-align: center; margin-right:5%;" class="styleform"
                                    name="quantity" min="0" step="any" placeholder="quantity"
                                    value="<?php echo $quantity; ?>" required>
                                <br><br>

                                <label style="margin-left:-18%; ">Remarks:</label>
                                <input type="text" style="height:60px; font-size: 20px; text-align: center;" class="styleform"
                                    name="remarks" placeholder="remarks" value="<?php echo $remarks; ?>">
                                <div class="yield">
                                    <h4>Yield</h4>
                                </div>

                                <div class="boxstyle">
                                    <div class="mainbox boxYield">
                                        <label style="margin-left:10px;">Paint<span style="margin-left:35px;">Acetate</span><span
                                                class="vertical-line"></span></label><br>
                                    <div class="input-yield">
                                        <input type="number"
                                        class="input" id="paintYield"
                                        min="0" step="any" name="paintYield"
                                        value="<?php echo $paintYield; ?>" >

                                        <input type="number"
                                        class="input" id="acetateYield"
                                        min="0" step="any" name="acetateYield"
                                        value="<?php echo $acetateYield; ?>" >
                                    </div>
                                    </div>
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
                    <a href="mobileDataEntry.php" class="btn btn-primary">OK</a>
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