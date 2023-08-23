<?php
include 'menu/validate_login.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Read Order Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php
        include 'menu/navbar.php';
        ?>

        <div class="page-header">
            <h1>Read Order Detail</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        // include database connection
        include 'config/database.php';

        $query = "SELECT order_details.order_detail_id, order_details.order_id, products.name, products.price, products.promotion_price, order_details.quantity
        FROM order_details INNER JOIN products ON order_details.product_id = products.id WHERE order_details.order_id =:id";

        $cus_query = "SELECT order_summary.order_date,
        customers.firstname, customers.lastname
        FROM order_summary 
        INNER JOIN order_details ON order_details.order_id = order_summary.order_id
        INNER JOIN customers ON order_summary.customer_id = customers.id WHERE order_details.order_id =:id";

        $stmt = $con->prepare($query);
        $stmt->bindParam(":id", $id);

        $cus_stmt = $con->prepare($cus_query);
        $cus_stmt->bindParam(":id", $id);
        //$stmt->bindParam(":customer_id", $customer_id);
        // delete message prompt will be here


        // select all data

        // bind the parameters

        $stmt->execute();
        $cus_stmt->execute();
        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='order_create.php' class='btn btn-primary m-b-1em'>Create New Order</a>";

        //check if more than 0 record found
        if ($num > 0) {



            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            //echo "<th>Order Detail ID</th>";
            //echo "<th>Order ID</th>";
            echo "<th>Product Name</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "<th>Total Amount</th>";
            echo "</tr>";


            // initialize the total amount variable
            $totalAmount = 0;
            if ($cus_row = $cus_stmt->fetch(PDO::FETCH_ASSOC)) {
                // display customer name and order date
                extract($cus_row);
                echo "<div class='mb-4'>";
                echo "<p>Customer Name: {$firstname} {$lastname}</p>";
                echo "<p>Order Date: {$order_date}</p>";
                echo "</div>";
            }
            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);



                // calculate the total amount for the product based on promotion price or regular price
                $productPrice = ($promotion_price > 0 && $promotion_price < $price) ? $promotion_price : $price;
                $productTotalAmount = $productPrice * $quantity;
                $totalAmount += $productTotalAmount;

                // creating new table row per record
                echo "<tr>";
                //echo "<td>{$order_detail_id}</td>";
                //echo "<td>{$order_id}</td>";
                echo "<td>{$name}</td>";
                if ($promotion_price < $price && ($promotion_price != 0)) {
                    echo "<td class='d-flex justify-content-end'>
                            <p class=' me-1 text-decoration-line-through'>RM" . number_format((float)$price, 2, '.', '') . "</p>
                            <p>RM" . number_format((float)$promotion_price, 2, '.', '') . "</p>
                        </td>";
                } else {
                    echo "<td class='text-end'>" . number_format((float)$productPrice, 2, '.', '') . "</td>";
                }
                echo "<td class='text-end'>{$quantity}</td>";
                echo "<td class='text-end'>RM" . number_format($productTotalAmount, 2) . "</td>"; // Display total amount with 2 decimal places
                echo "</tr>";
            }
            // end table
            echo "</table>";


            // display the Total Order Amount below the table
            echo "<h3 class='text-end'>Total Order Amount: RM" . number_format($totalAmount, 2) . "</h3>";

            echo "<a href='order_read.php' class='btn btn-danger'>Back to Order List</a>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>

    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
</body>

</html>