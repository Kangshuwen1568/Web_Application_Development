<?php
include 'menu/validate_login.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <!-- navbar -->
        <?php
        include 'menu/navbar.php';
        include 'config/database.php';
        ?>

        <div class="container">
            <div class="page-header">
                <h1>Welcome to E-commerce System.&#128722;</h1>
            </div>
            <p></p>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        $customer_query = "SELECT * FROM customers";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT * FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_summary_query = "SELECT * FROM order_summary";
        $order_summary_stmt = $con->prepare($order_summary_query);
        $order_summary_stmt->execute();
        $order_summary = $order_summary_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_detail_query = "SELECT * FROM order_details";
        $order_detail_stmt = $con->prepare($order_detail_query);
        $order_detail_stmt->execute();
        $order_details = $order_detail_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="container row m-auto justify-content-center">
            <div class="col border  border-dark border-3 text-center p-3 m-1">
                <h3>Total number of customers</h3>
                <p class="fs-4"><?php echo count($customers); ?></p>
            </div>
            <div class="col border border-dark border-3 text-center p-3 m-1">
                <h3>Total number of products</h3>
                <p class="fs-4"><?php echo count($products); ?></p>
            </div>
            <div class="col border border-dark border-3 text-center p-3 m-1">
                <h3>Total number of orders</h3>
                <p class="fs-4"><?php echo count($order_summary); ?></p>
            </div>
        </div>


        <h2 class="container text-center mt-3">Latest & Highest Order Details</h2>
        <div class="container row m-auto gap-3">
            <div class="col border border-dark border-3 p-5">
                <h3 class=" text-center">Latest Order ID and Summary</h3>
                <p class="mt-3">Customer Name:
                    <?php
                    $latest_order_query = "SELECT order_summary.order_id, order_summary.customer_id, order_summary.order_date, 
                    SUM(order_details.quantity) AS total_quantity, SUM(CASE WHEN products.promotion_price IS NOT NULL THEN products.promotion_price * order_details.quantity ELSE products.price * order_details.quantity END) AS total_amount 
                    FROM order_summary JOIN order_details ON order_summary.order_id = order_details.order_id 
                    JOIN products ON order_details.product_id = products.id
                        WHERE order_summary.order_id=(SELECT MAX(order_id) FROM order_summary)";
                    $latest_order_stmt = $con->prepare($latest_order_query);
                    $latest_order_stmt->execute();
                    $latest_order = $latest_order_stmt->fetch(PDO::FETCH_ASSOC);

                    $customer_id = $latest_order['customer_id'];
                    $customer_name_query = "SELECT firstname, lastname FROM customers WHERE id=?";
                    $customer_name_stmt = $con->prepare($customer_name_query);
                    $customer_name_stmt->bindParam(1, $customer_id);
                    $customer_name_stmt->execute();
                    $customer_name = $customer_name_stmt->fetch(PDO::FETCH_ASSOC);
                    echo $customer_name['firstname'] . " " . $customer_name['lastname'];
                    echo "<p><span>Order Date:</span> " . $latest_order['order_date'] . "</p>";
                    echo "<p><span>Total Quantity:</span> " . $latest_order['total_quantity'] . "</p>";
                    echo "<p><span>Total Amount:</span> RM " . number_format((float)$latest_order['total_amount'], 2, '.', '') . "</p>";
                    ?>
                </p>

            </div>
            <div class="col border border-dark border-3 p-5">
                <h3 class=" text-center">Highest Purchased Amount Order</h3>
                <p class="mt-3"><span>Customer Name:</span>
                    <?php
                    $highest_order_query = "SELECT order_summary.order_id, order_summary.customer_id, order_summary.order_date, 
                    SUM(order_details.quantity) AS total_quantity,
                    SUM(CASE WHEN products.promotion_price IS NOT NULL THEN products.promotion_price * order_details.quantity ELSE products.price * order_details.quantity END) AS total_amount
                    FROM order_summary JOIN order_details ON order_summary.order_id = order_details.order_id
                    JOIN products ON order_details.product_id = products.id
                    GROUP BY order_summary.order_id ORDER BY total_amount DESC LIMIT 1";
                    $highest_order_stmt = $con->prepare($highest_order_query);
                    $highest_order_stmt->execute();
                    $highest_order = $highest_order_stmt->fetch(PDO::FETCH_ASSOC);

                    $customer_id = $highest_order['customer_id'];
                    $customer_name_query = "SELECT firstname, lastname FROM customers WHERE id=?";
                    $customer_name_stmt = $con->prepare($customer_name_query);
                    $customer_name_stmt->bindParam(1, $customer_id);
                    $customer_name_stmt->execute();
                    $customer_name = $customer_name_stmt->fetch(PDO::FETCH_ASSOC);
                    echo $customer_name['firstname'] . " " . $customer_name['lastname'];

                    echo "<p><span>Order Date:</span> " . $highest_order['order_date'] . "</p>";
                    echo "<p><span>Total Quantity:</span> " . $highest_order['total_quantity'] . "</p>";
                    echo "<p><span>Total Amount:</span> RM " . number_format((float)$highest_order['total_amount'], 2, '.', '') . "</p>";
                    ?>
                </p>

            </div>
        </div>

        <h2 class="container text-center mt-3">Product Details</h2>
        <div class="container row m-auto gap-3">
            <div class="col border border-dark border-3 p-5 text-center">
                <h2 class="mb-3">Top 5 Selling Products</h2>
                <?php
                $top_product_query = "SELECT order_details.product_id, products.name, SUM(order_details.quantity) AS total_quantity
                             FROM order_details
                             JOIN products ON order_details.product_id = products.id
                             GROUP BY order_details.product_id
                             ORDER BY total_quantity DESC
                             LIMIT 5";
                $top_product_stmt = $con->prepare($top_product_query);
                $top_product_stmt->execute();
                $top_products = $top_product_stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($top_products as $product) {
                    echo "<p>{$product['name']} &#10145; {$product['total_quantity']} SOLD</p>";
                }
                ?>
            </div>

            <div class="col border border-dark border-3 p-5 text-center">
                <h2 class="mb-3">3 Products Never Purchased</h2>
                <?php
                $no_purchased_product_query = "SELECT id, name FROM products WHERE NOT EXISTS(SELECT product_id FROM order_details WHERE order_details.product_id = products.id)";
                $no_purchased_product_stmt = $con->prepare($no_purchased_product_query);
                $no_purchased_product_stmt->execute();
                $no_purchased_products = $no_purchased_product_stmt->fetchAll(PDO::FETCH_ASSOC);

                $display_count = 0; // will counter for displayed products

                foreach ($no_purchased_products as $product) {
                    if ($display_count < 3) { // display only 3 products
                        echo "<p>{$product['name']}</p>";
                        $display_count++;
                    } else {
                        break; // break the loop after display 3 products
                    }
                }
                ?>
            </div>
        </div>


    </div>

</body>

</html>