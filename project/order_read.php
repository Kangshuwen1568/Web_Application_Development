<?php
include 'menu/validate_login.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Read order summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <?php
        include 'menu/navbar.php';
        ?>

        <div class="page-header">
            <h1>Read Order Summary</h1>
        </div>

        <div class="mb-3">
            <form class="d-flex" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET">
                <input class="form-control me-2" type="text" name="search" placeholder="Search Customer by name" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>

        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        // select all data
        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT order_summary.order_id, customers.firstname, customers.lastname, order_summary.order_date FROM order_summary INNER JOIN customers ON order_summary.customer_id = customers.id";
        if (!empty($searchKeyword)) {
            $query .= " WHERE customers.firstname LIKE :keyword OR customers.lastname LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY order_summary.order_id DESC";
        $stmt = $con->prepare($query); // prepare query for execution
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }
        // bind the parameters

        // delete message prompt will be here
        $stmt->execute();

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
            //echo "<th>Order ID</th>";
            echo "<th>Customer Name</th>";
            echo "<th>Order Date</th>";
            echo "<th>Total Amount</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                $total_amount_query = "SELECT SUM(IF(products.promotion_price > 0 AND products.promotion_price < products.price, 
                                       products.promotion_price * order_details.quantity, 
                                       products.price * order_details.quantity)) AS total_amount
                        FROM order_details 
                        INNER JOIN products ON order_details.product_id = products.id 
                        WHERE order_details.order_id = :order_id";
                $total_amount_stmt = $con->prepare($total_amount_query);
                $total_amount_stmt->bindParam(":order_id", $order_id);
                $total_amount_stmt->execute();
                $total_amount_row = $total_amount_stmt->fetch(PDO::FETCH_ASSOC);
                $total_amount = $total_amount_row['total_amount'];
                // creating new table row per record
                echo "<tr>";
                //echo "<td>{$order_id}</td>";
                //echo "<td>{$firstname} {$lastname}</td>";
                echo "<td><a class='link-underline-light link-dark' href='order_detail_read.php?id={$order_id}'>{$firstname} {$lastname}</a></td>";
                echo "<td>{$order_date}</td>";
                //echo "<td>{$totalAmount}</td>";
                echo "<td class='text-end'>RM" . number_format($total_amount, 2) . "</td>";
                echo "<td class='col-2'>";
                // read one record
                echo "<a href='order_detail_read.php?id={$order_id}' class='btn btn-info m-r-1em'>Read</a>";
                // we will use this links on next part of this post
                echo "<a href='order_update.php?id={$order_id}' class='btn btn-primary m-r-1em mx-1'>Edit</a>";
                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_order({$order_id});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";

                echo "</tr>";
            }
            // end table
            echo "</table>";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>
    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script type='text/javascript'>
        // confirm record deletion
        function delete_order(id) {

            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'order_delete.php?id=' + id;
            }
        }
    </script>
</body>

</html>