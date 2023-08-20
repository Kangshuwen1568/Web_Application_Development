<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    $check_product_category_query = "SELECT COUNT(*) FROM products WHERE category_id = ?";
    $check_product_category_stmt = $con->prepare($check_product_category_query);
    $check_product_category_stmt->bindParam(1, $id);
    $check_product_category_stmt->execute();
    $order_count = $check_product_category_stmt->fetchColumn();

    if ($order_count > 0) {

        die('Cannot delete the customer. They have ' . $order_count . ' orders.');
    }

    // delete query
    $delete_query = "DELETE FROM categories WHERE id = ?";
    $delete_stmt = $con->prepare($delete_query);
    $delete_stmt->bindParam(1, $id);

    if ($delete_stmt->execute()) {
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: category_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
