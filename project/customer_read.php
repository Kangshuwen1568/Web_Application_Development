<?php
include 'menu/validate_login.php';

?>
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
        include 'menu/navbar.php';
        ?>

        <div class="page-header">
            <h1>Read Customers</h1>
        </div>

        <div class="mb-3">
            <form class="d-flex" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET">
                <input class="form-control me-2" type="text" name="search" placeholder="Search Customer by name/email" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        include 'config/database.php';
        include 'file_upload.php';
        // include database connection
        //include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        // select all data
        $search_keyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT id, username, firstname, lastname, email, account_status, image FROM customers ";
        if (!empty($search_keyword)) {
            $query .= " WHERE username LIKE :keyword OR firstname LIKE :keyword OR lastname LIKE :keyword OR email LIKE :keyword";
            $search_keyword = "%{$search_keyword}%";
        }
        $query .= " ORDER BY id DESC";
        $stmt = $con->prepare($query); // prepare query for execution
        if (!empty($search_keyword)) {
            $stmt->bindParam(':keyword', $search_keyword);
        }
        // bind the parameters

        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='customer_create.php' class='btn btn-primary m-b-1em'>Create New Customers</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Username</th>";
            echo "<th>Firstname</th>";
            echo "<th>Lastname</th>";
            echo "<th>Image</th>";
            echo "<th>Email</th>";
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
                echo "<td>{$id}</td>";
                echo "<td>{$username}</td>";
                echo "<td>{$firstname}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td><img src='uploads/{$image}' alt='Image' width='100'></td>";
                // Check if the image file exists in the uploads directory
                //if (!empty($image) && file_exists("uploads/{$image}")) {
                //echo "<td><img src='uploads/{$image}' alt='{$username}' width='100'></td>";
                //} else {
                // Display the default user image if no image is available
                //echo "<td><img src='uploads/default_user.png' alt='{$username}' width='100'></td>";
                //}

                echo "<td>{$email}</td>";
                echo "<td>{$account_status}</td>";
                echo "<td>";
                // read one record
                echo "<a href='customer_read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='customer_update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_customer({$id});'  class='btn btn-danger'>Delete</a>";
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
        function delete_customer(id) {

            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'customer_delete.php?id=' + id;
            }
        }
    </script>

    <!--BOOTSTRAP5 JS-->
</body>

</html>