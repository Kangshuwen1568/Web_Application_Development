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
        include 'navbar.php';
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

        // select all data
        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT order_summary.order_id, customers.firstname, customers.lastname, order_summary.order_date FROM order_summary INNER JOIN customers ON order_summary.customer_id = customers.id";
        if (!empty($searchKeyword)) {
            $query .= " WHERE customers.firstname LIKE :keyword OR customers.lastname LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY order_summary.order_id ASC";
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
            echo "<th>Order ID</th>";
            echo "<th>Customer Name</th>";
            echo "<th>Order Date</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$order_id}</td>";
                echo "<td>{$firstname} {$lastname}</td>";
                echo "<td>{$order_date}</td>";
                echo "<td class='col-2'>";
                // read one record
                echo "<a href='order_detail_read.php?id={$order_id}' class='btn btn-info m-r-1em'>Read Order Details</a>";
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
</body>

</html>