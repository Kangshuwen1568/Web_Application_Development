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
        include 'navbar.php';
        ?>

        <div class="page-header">
            <h1>Read Order Detail</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        // include database connection
        include 'config/database.php';

        $query = "SELECT order_details.order_detail_id, order_details.order_id, products.name, order_details.quantity
        FROM order_details INNER JOIN products ON order_details.product_id = products.id WHERE order_details.order_id =:id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":id", $id);
        // delete message prompt will be here


        // select all data

        // bind the parameters

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
            echo "<th>Order Detail ID</th>";
            echo "<th>Order ID</th>";
            echo "<th>Product Name</th>";
            echo "<th>Quantity</th>";
            //echo "<th></th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$order_detail_id}</td>";
                echo "<td>{$order_id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$quantity}</td>";
                echo "</tr>";
            }
            // end table
            echo "</table>";
            echo "<a href='order_read.php' class='btn btn-danger'>Back to Order List</a>";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>

    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
</body>

</html>