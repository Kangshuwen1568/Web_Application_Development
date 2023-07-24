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
        include 'navbar.php';
        ?>
        <div class="page-header">
            <h1>Create New Order</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        // include database connection
        include 'config/database.php';
        $query = "SELECT id, name FROM products";
        $stmt = $con->prepare($query);
        $stmt->execute();
        // this is how to get number of rows returned
        $num = $stmt->rowCount();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if ($_POST) {
            // include database connection

            $customer_id = $_POST['customer_id'];
            $order_date = $_POST['order_date'];
            $productid = $_POST['product_id'];
            $quantities = $_POST['quantity'];

            // initialize an array to store error messages
            $errors = array();

            // check order date field is empty
            if (empty($order_date)) {
                $errors[] = "Order date is required.";
            }

            // Check if at least one product is selected
            if (empty($productid)) {
                $errors[] = "Please select at least one product.";
            }

            // Check if the quantities are valid (greater than 0)
            foreach ($quantities as $quantity) {
                if ($quantity < 1) {
                    $errors[] = "Quantity must be greater than 0.";
                    break;      //when user input less that 1, error message such display in"errors array", and will stop the foreach(loop)
                }
            }

            // check if any errors occurred
            if (!empty($errors)) {
                $errorMessage = "<div class='alert alert-danger'>";
                // display out the error messages
                foreach ($errors as $error) {
                    $errorMessage .= $error . "<br>";
                }
                $errorMessage .= "</div>";
                echo $errorMessage;
            } else {
                try {
                    // Insert order summary
                    $insert_summary_query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date";
                    // prepare query for execution
                    $stmt = $con->prepare($insert_summary_query);
                    // bind the parameters
                    $stmt->bindParam(':customer_id', $customer_id);

                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $order_date = date('Y-m-d H:i:s');
                    $stmt->bindParam(':order_date', $order_date);


                    // Execute the query
                    if ($stmt->execute()) {
                        // Get the last inserted order ID
                        $order_id = $con->lastInsertId();
                        // Insert order details
                        $insert_order_details_query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                        // prepare query for execution
                        $stmt = $con->prepare($insert_order_details_query);

                        // bind the parameters
                        for ($i = 0; $i < count($productid); $i++) {
                            $stmt->bindParam(':order_id', $order_id);
                            $stmt->bindParam(':product_id', $productid[$i]);
                            $stmt->bindParam(':quantity', $quantities[$i]);
                            $stmt->execute();
                        }

                        echo "<div class='alert alert-success'>Order created successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to create the order.</div>";
                    }
                }
                // show error
                catch (PDOException $exception) {
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
                    <td><select name='customer_id' class='form-select'>
                            <?php
                            //in "customers" table中得到"customers_name"的data
                            $query = "SELECT id, username FROM customers";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            // this is how to get number of rows returned
                            $num = $stmt->rowCount();
                            $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // 下拉菜单的选项
                            foreach ($customers as $customer) { // Use $customer['id'] as the value for each option
                                $customerID = $customer['id'];
                                $customerName = $customer['username'];
                                echo "<option value='$customerID'>$customerName</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Product</td>
                    <td>
                        Product 1:
                        <select name="product_id[]" class='form-select'>
                            <?php
                            // 下拉菜单的选项
                            foreach ($products as $product) { // Use $customer['id'] as the value for each option
                                $productID = $product['id'];
                                $productName = $product['name'];
                                echo "<option value='$productID'>$productName</option>";
                            }
                            ?>
                        </select>
                        Quantity: <input type="number" name="quantity[]" value="0" min="1" class="mb-3">
                        <br>
                        Product 2:
                        <select name="product_id[]" class='form-select '>
                            <?php
                            // 下拉菜单的选项
                            foreach ($products as $product) { // Use $customer['id'] as the value for each option
                                $productID = $product['id'];
                                $productName = $product['name'];
                                echo "<option value='$productID'>$productName</option>";
                            }
                            ?>
                        </select>
                        Quantity: <input type="number" name="quantity[]" value="0" min="1" class="mb-3">

                        <br>
                        Product 3:
                        <select name="product_id[]" class='form-select'>
                            <?php
                            // 下拉菜单的选项
                            foreach ($products as $product) { // Use $customer['id'] as the value for each option
                                $productID = $product['id'];
                                $productName = $product['name'];
                                echo "<option value='$productID'>$productName</option>";
                            }
                            ?>
                        </select>
                        Quantity: <input type="number" name="quantity[]" value="0" min="1" class="mb-3">
                    </td>
                </tr>
                <tr>
                    <td>Order Date</td>
                    <td><input type="date" name="order_date" class="form-control" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Place' class='btn btn-primary' />
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->

</html>