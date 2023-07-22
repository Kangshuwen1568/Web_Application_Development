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
            <h1>Read Category</h1>
        </div>

        <!-- Search form-->

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here


        // select all data                  
        $search_keyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT id, category_name, description FROM categories ";
        if (!empty($search_keyword)) {
            $query .= " WHERE category_name LIKE :keyword";
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
        echo "<a href='category_create.php' class='btn btn-primary m-b-1em'>Create New Categories</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Category Name</th>";
            echo "<th>Description</th>";
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
                echo "<td>{$category_name}</td>";
                echo "<td>{$description}</td>";

                //Action part table
                echo "<td>";
                // read one record
                echo "<a href='category_read_one.php?id={$id}' class='btn btn-info m-r-1em text-white mx-1'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='category_update.php?id={$id}' class='btn btn-primary m-r-1em mx-1'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_product({$id});'  class='btn btn-danger mx-1'>Delete</a>";
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