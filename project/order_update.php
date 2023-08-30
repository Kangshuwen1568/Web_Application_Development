<?php
include 'menu/validate_login.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Update Order</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- CSS -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <!--container-->
    <div class="container">
        <?php
        include 'menu/navbar.php';
        // include database connection
        include 'config/database.php';
        ?>
        <div class="page-header">
            <h1>Update Order</h1>
        </div>

        <!-- PHP read record by ID will be here-->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        include 'config/database.php';

        try {
            $customer_query = "SELECT customers.id, customers.username FROM customers JOIN order_summary ON customers.id = order_summary.customer_id WHERE order_summary.order_id = :id";
            $customer_stmt = $con->prepare($customer_query);
            $customer_stmt->bindParam(":id", $id);
            $customer_stmt->execute();
            // store retrieved row to a variable
            $row = $customer_stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['username'];

            // Retrieve products list
            $product_query = "SELECT id, name FROM products";
            $product_stmt = $con->prepare($product_query);
            $product_stmt->execute();
            // this is how to get number of rows returned
            //$num = $stmt->rowCount();
            $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }

        // Initialize an array to store error messages

        if ($_POST) {
            try {
                // Retrieve existing order date
                $get_order_date_query = "SELECT order_date FROM order_summary WHERE order_id = :id";
                $get_order_date_stmt = $con->prepare($get_order_date_query);
                $get_order_date_stmt->bindParam(":id", $id);
                $get_order_date_stmt->execute();
                $existing_order_date = $get_order_date_stmt->fetchColumn();
                // Retrieve form data
                //$customer_id = $_POST['customer_id'];
                //$order_date = $_POST['order_date'];
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
                $errors = array();
                // Check if at least one product is selected
                if (empty($product_id)) {
                    $errors[] = "Please select a product.";
                }
                // Check if at least one product is selected
                $selectedProductCount = count(array_filter($product_id));
                if ($selectedProductCount === 0) {
                    $errors[] = "Please select at least one product.";
                }
                // Check if the quantities are valid (greater than 0)
                foreach ($quantity as $quantityValue) {
                    if ($quantityValue <= 0) {
                        $errors[] = "Quantity must be greater than 0.";
                        break;  // Stop the loop if a quantity is invalid
                    }
                }

                // Remove duplicated products and corresponding quantities
                $noduplicate = array_unique($product_id);
                if (sizeof($noduplicate) != sizeof($product_id)) {
                    foreach ($product_id as $key => $val) {
                        if (!in_array($val, $noduplicate)) {
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
                    // Update order summary 
                    $update_summary_query = "UPDATE order_summary SET order_date=:order_date WHERE order_id=:id";
                    // Prepare query for execution
                    $update_summary_stmt = $con->prepare($update_summary_query);
                    // Bind the parameters and execute
                    $update_summary_stmt->bindParam(":order_date", $existing_order_date);
                    $update_summary_stmt->bindParam(":id", $id);
                    $update_summary_stmt->execute();

                    // Delete existing order details
                    $delete_details_query = "DELETE FROM order_details WHERE order_id=:id";
                    $delete_details_stmt = $con->prepare($delete_details_query);
                    $delete_details_stmt->bindParam(":id", $id);
                    $delete_details_stmt->execute();

                    // Insert updated order details into the order_details table
                    $insert_details_query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";


                    for ($i = 0; $i < count($product_id); $i++) {
                        $stmt_details = $con->prepare($insert_details_query);
                        $stmt_details->bindParam(':order_id', $id);
                        $stmt_details->bindParam(':product_id', $product_id[$i]);
                        $stmt_details->bindParam(':quantity', $quantity[$i]);
                        $stmt_details->execute();
                    }
                    echo "<div class='alert alert-success'>Order updated successfully.</div>";
                }
                $selected_product = isset($noduplicate) ? count($noduplicate) : count($product_id);
            }
            // show error
            catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
            }
        }

        ?>

        <!--HTML form to update record will be here -->
        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Customer Name</td>
                    <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
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

                        <select name="product_id[]" class="form-select form-select-lg mb-3 col">
                            <option value="" selected hidden>Please select a product</option>
                            <?php
                            // 下拉菜单的选项
                            foreach ($products as $product) { // Use $customer['id'] as the value for each option
                                $productID = $product['id'];
                                $productName = $product['name'];
                                // Check if the current product ID matches

                                echo "<option value='$productID'>$productName</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="number" class="form-select form-select-lg mb-3" name="quantity[]" /></td>

                    <td><button onclick='deleteRow(this)' class='btn d-flex justify-content-center btn-danger mt-1'>Delete</button></td>

                </tr>
                <tr>
                    <td>

                    </td>
                    <td colspan="4">
                        <input type="button" value="Add More Product" class="btn btn-success add_one" />
                    </td>
                </tr>
            </table>
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Update order' class='btn btn-primary' />
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