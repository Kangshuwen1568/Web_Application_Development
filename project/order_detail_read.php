<!DOCTYPE HTML>
<html>

<head>
    <title>Create a Record</title>
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
            <h1>Read Products</h1>
        </div>

        <!-- Search form -->
        <div class="mb-3">
            <form class="d-flex" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET">
                <input class="form-control me-2" type="text" name="search" placeholder="Search Customer by username" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here


        // select all data
        $search_keyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT customers.username, order_summary.order_date, order_summary.order_id
        FROM order_summary INNER JOIN order_details ON order_summary.order_id = order_details.order_detail_id INNER JOIN customers ON customers.id = order_summary.customer_id";



        if (!empty($search_keyword)) {
            $query .= " WHERE username LIKE :keyword";
            $search_keyword = "%{$search_keyword}%";
        }
        $query .= " ORDER BY order_detail_id ASC";
        $stmt = $con->prepare($query); // prepare query for execution
        if (!empty($search_keyword)) {
            $stmt->bindParam(':keyword', $search_keyword);
        }
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
            echo "<th>Customer</th>";
            echo "<th>Order date</th>";
            echo "<th>Action</th>";
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
                echo "<td>{$order_id}</td>";
                echo "<td>{$username}</td>";
                echo "<td>{$order_date}</td>";     // Display the Categoryname

                /*if ($promotion_price < $price && ($promotion_price != 0)) {
                    echo "<td class='d-flex justify-content-end'>
                            <p class=' me-1 text-decoration-line-through'>" . number_format((float)$price, 2, '.', '') . "</p>
                            <p>" . number_format((float)$promotion_price, 2, '.', '') . "</p>
                        </td>";
                } else {
                    echo "<td class='text-end'>" . number_format((float)$price, 2, '.', '') . "</td>";
                }*/

                //Action part table
                echo "<td>";
                // read one record
                echo "<a href='order_detail_read.php?id={$order_id}' class='btn btn-info m-r-1em text-white mx-1'>Read</a>";
                /*
                // we will use this links on next part of this post
                echo "<a href='product_update.php?id={$id}' class='btn btn-primary m-r-1em mx-1'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_product({$id});'  class='btn btn-danger mx-1'>Delete</a>";*/
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
</body>

</html>