<?php
include 'connect.php';

if (isset($_POST['deletedata'])) {
    $delete = $_POST['userID'];

    // Sanitize the input to prevent SQL injection
    $delete = mysqli_real_escape_string($con, $delete);

    // Delete from tbl_supplier
    $sql_supplier = "DELETE FROM tbl_supplier WHERE supplierID = '$delete'";
    $result_supplier = mysqli_query($con, $sql_supplier);

    // Delete from tbl_paint
    $sql_paint = "DELETE FROM tbl_paint WHERE paintID = '$delete'";
    $result_paint = mysqli_query($con, $sql_paint);

    // Delete from tbl_entry
    $sql_entry = "DELETE FROM tbl_entry WHERE EntryID = '$delete'";
    $result_entry = mysqli_query($con, $sql_entry);

    // Check if all deletes were successful
    if ($result_supplier && $result_paint && $result_entry) {
        // Redirect to volume.php after successful deletion
        header('location: volume.php');
        exit(); // Add exit() after header to prevent further execution
    } else {
        // Handle errors if needed
        die(mysqli_error($con));
    }
}
?>
