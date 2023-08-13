<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['message'] = 'Please login to access this page!';
    header('location:login.php');
    exit();
}
