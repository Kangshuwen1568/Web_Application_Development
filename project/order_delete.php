<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    // delete query
    $query = "DELETE FROM order_details WHERE order_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);

    // delete query
    $order_summary_query = "DELETE FROM order_summary WHERE order_id = ?";
    $order_summary_stmt = $con->prepare($order_summary_query);
    $order_summary_stmt->bindParam(1, $id);

    if ($stmt->execute() && $order_summary_stmt->execute()) {
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: order_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
