<?php

include 'config/database.php';
// Fetch the customer's status based on their username
$query = "SELECT account_status FROM customers WHERE username = :username";
$stmt = $con->prepare($query);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
$customer_status = $customer['account_status'];
$inputDisabled = $customer_status == 'inactive' ? 'disabled' : '';
