<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    // Get the filename of the customer image before deleting the record
    $get_customer_image_query = "SELECT image FROM customers WHERE id = ?";
    $get_customer_image_stmt = $con->prepare($get_product_image_query);
    $get_customer_image_stmt->bindParam(1, $id);
    $get_customer_image_stmt->execute();
    $customer_image = "uploads/" . $get_customer_image_stmt->fetchColumn(); // Add "uploads/" prefix

    // Delete the customer image file if it exists and is not the default image
    if ($customer_image !== "uploads/user.png" && file_exists($customer_image)) {
        unlink($customer_image);
    }

    $check_customer_query = "SELECT COUNT(*) FROM order_summary WHERE customer_id = ?";
    $check_customer_stmt = $con->prepare($check_customer_query);
    $check_customer_stmt->bindParam(1, $id);
    $check_customer_stmt->execute();
    $order_count = $check_customer_stmt->fetchColumn();

    if ($order_count > 0) {
        // Customer is associated with orders, prompt a message
        die('Cannot delete the customer. They have ' . $order_count . ' orders.');
    }

    // delete query
    $delete_query = "DELETE FROM customers WHERE id = ?";
    $delete_stmt = $con->prepare($delete_query);
    $delete_stmt->bindParam(1, $id);

    if ($delete_stmt->execute()) {
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: customer_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}

// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
