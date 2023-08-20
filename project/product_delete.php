<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    // check if the product is associated with any orders
    $check_product_query = "SELECT COUNT(*) FROM order_details WHERE product_id = ?";
    $check_product_stmt = $con->prepare($check_product_query);
    $check_product_stmt->bindParam(1, $id);
    $check_product_stmt->execute();
    $order_count = $check_product_stmt->fetchColumn();

    if ($order_count > 0) {
        // to prompt message of product is associated with orders 
        die('Cannot delete the product. It is associated with ' . $order_count . ' orders.');
    }

    // delete query
    $delete_query = "DELETE FROM products WHERE id = ?";
    $delete_stmt = $con->prepare($delete_query);
    $delete_stmt->bindParam(1, $id);

    if ($delete_stmt->execute()) {
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: product_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
