<?php
include 'menu/validate_login.php';
include 'config/database.php';
/// Retrieve the username from the session
$loggedInUsername = $_SESSION['username'];

// Fetch the customer ID based on the logged-in username
$query = "SELECT id, account_status FROM customers WHERE username = :username";
$stmt = $con->prepare($query);
$stmt->bindParam(':username', $loggedInUsername);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
$customer_id = $customer['id'];
$customer_status = $customer['account_status'];
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Create New Order</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <!-- container -->
    <div class="container">
        <!-- navbar -->
        <?php
        include 'menu/navbar.php';
        ?>
        <?php
        // include database connection
        include 'config/database.php';
        $query = "SELECT id, name FROM products";
        $stmt = $con->prepare($query);
        $stmt->execute();
        // this is how to get number of rows returned
        //$num = $stmt->rowCount();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="page-header">
            <h1>Create New Order</h1>
        </div>

        <!-- PHP insert code will be here -->

        <?php
        // Check the customer's status before allowing the order creation process to proceed
        if ($customer_status == 'inactive') {
            echo "<div class='alert alert-danger'>Your account is inactive. You cannot place an order.</div>";
        } else {
            if ($_POST) {
                try {
                    //$customer_id = $_POST['customer_id'];
                    $order_date = $_POST['order_date'];

                    $product_id = $_POST['product_id'];
                    $quantity = $_POST['quantity'];
                    // Initialize an array to store error messages
                    $errors = array();

                    // check order date field is empty
                    //if (empty($customer_id)) {
                    ///$errors[] = "Please select your name.";
                    //}

                    // Check if at least one product is selected
                    if (empty($product_id)) {
                        $errors[] = "Please select a product.";
                    }

                    // Check if the quantities are valid (greater than 0)
                    foreach ($quantity as $quantityValue) {
                        if ($quantityValue <= 0) {
                            $errors[] = "Quantity must be greater than 0.";
                            break;  // Stop the loop if a quantity is invalid
                        }
                    }

                    // check order date field is empty
                    if (empty($order_date)) {
                        $errors[] = "Order date is required.";
                    }

                    // Remove duplicated products and corresponding quantities
                    $noduplicate = array_unique($product_id);
                    if (sizeof($noduplicate) != sizeof($product_id)) {
                        foreach ($product_id as $key => $val) {
                            if (!array_key_exists($key, $noduplicate)) {
                                $errors[] = "Duplicated products have been chosen.";
                                unset($product_id[$key]);
                                unset($quantity[$key]);
                            }
                        }
                    }

                    // Check if any errors occurred
                    if (!empty($errors)) {
                        $errorMessage = "<div class='alert alert-danger'>";
                        foreach ($errors as $error) {
                            $errorMessage .= $error . "<br>";
                        }
                        $errorMessage .= "</div>";
                        echo $errorMessage;
                    } else {
                        // Insert order summary
                        $insert_summary_query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date";
                        // Prepare query for execution
                        $stmt_summary = $con->prepare($insert_summary_query);
                        // Bind the parameters
                        $stmt_summary->bindParam(':customer_id', $customer_id);
                        $stmt_summary->bindParam(':order_date', $order_date);

                        // Execute the query
                        if ($stmt_summary->execute()) {
                            // Get the last inserted order ID
                            $order_id = $con->lastInsertId();
                            // Insert order details
                            $insert_order_details_query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                            // Prepare query for execution
                            $stmt_details = $con->prepare($insert_order_details_query);

                            // Bind the parameters and execute for each product
                            for ($i = 0; $i < count($product_id); $i++) {
                                $stmt_details->bindParam(':order_id', $order_id);
                                $stmt_details->bindParam(':product_id', $product_id[$i]);
                                $stmt_details->bindParam(':quantity', $quantity[$i]);
                                $stmt_details->execute();
                            }

                            echo "<script>window.location.href='order_detail_read.php?id={$order_id}'</script>";


                            echo "<div class='alert alert-success'>Order created successfully.</div>";
                            exit();
                        }
                    }
                } catch (PDOException $exception) {
                    echo "<div class='alert alert-danger'>Unable to create the order.</div>";
                    die('ERROR: ' . $exception->getMessage());
                }
            }
        }
        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Customer Name</td>
                    <td><input type="text" name="customer_name" id="customer_name" class="form-control" value="<?php echo $loggedInUsername; ?>" readonly /></td>
                </tr>
            </table>

            <table class='table table-hover table-responsive table-bordered' id="row_del">
                <tr>
                    <td class="text-center text-light">#</td>
                    <td class="text-center">Product</td>
                    <td class="text-center">Quantity</td>
                    <td class="text-center">Action</td>
                </tr>

                <tr class="pRow">
                    <td class="text-center">1</td>
                    <td class="d-flex">
                        <?php
                        $inputDisabled = $customer_status == 'inactive' ? 'disabled' : ''; // Check account status and set 'disabled' attribute if inactive
                        ?>
                        <select name="product_id[]" class="form-select form-select-lg mb-3 col" aria-label=".form-select-lg example" <?php echo $inputDisabled; ?>>
                            <option>Please select a product</option>
                            <?php
                            // 下拉菜单的选项
                            foreach ($products as $product) { // Use $customer['id'] as the value for each option
                                $productID = $product['id'];
                                $productName = $product['name'];
                                echo "<option value='$productID'>$productName</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="number" class="form-select form-select-lg mb-3" name="quantity[]" aria-label=".form-select-lg example" <?php echo $inputDisabled; ?> /></td>
                    <td><input href='#' onclick='deleteRow(this)' class='btn d-flex justify-content-center btn-danger mt-1' value="Delete" <?php echo $inputDisabled; ?> /></td>

                </tr>
                <tr>
                    <td>

                    </td>
                    <td colspan="4">
                        <input type="button" value="Add More Product" class="btn btn-success add_one" <?php echo $inputDisabled; ?> />
                    </td>
                </tr>
            </table>
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Order Date</td>
                    <td><input type="date" name="order_date" class="form-control" <?php echo $inputDisabled; ?> /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>

                        <input type='submit' value='Place' class='btn btn-primary' <?php echo $inputDisabled; ?> />

                        <a href='order_read.php' class='btn btn-danger'>Back to read order</a>
                    </td>
                </tr>
            </table>
        </form>

        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var rows = document.getElementsByClassName('pRow');
                    // Get the last row in the table
                    var lastRow = rows[rows.length - 1];
                    // Clone the last row
                    var clone = lastRow.cloneNode(true);
                    // Insert the clone after the last row
                    lastRow.insertAdjacentElement('afterend', clone);

                    // Loop through the rows
                    for (var i = 0; i < rows.length; i++) {
                        // Set the inner HTML of the first cell to the current loop iteration number
                        rows[i].cells[0].innerHTML = i + 1;
                    }
                }
            }, false);

            function deleteRow(r) {
                var total = document.querySelectorAll('.pRow').length;
                if (total > 1) {
                    var i = r.parentNode.parentNode.rowIndex;
                    document.getElementById("row_del").deleteRow(i);

                    var rows = document.getElementsByClassName('pRow');
                    for (var i = 0; i < rows.length; i++) {
                        // Set the inner HTML of the first cell to the current loop iteration number
                        rows[i].cells[0].innerHTML = i + 1;
                    }
                } else {
                    alert("You need order at least one item.");
                }
            }
        </script>


    </div>
    <!-- end .container -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>