<?php
include 'menu/validate_login.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Read One Record</title>
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
            <h1>Read Product</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';
        //include 'file_upload.php';
        // read current record's data
        try {
            // prepare select query
            $query = "SELECT products.id, products.name, products.description, products.price, products.promotion_price, products.manufacture_date, products.expired_date, products.category_id, categories.category_name, products.image 
                FROM products INNER JOIN categories ON products.category_id = categories.id WHERE products.id = :id ";
            $stmt = $con->prepare($query);

            // Bind the parameter
            $stmt->bindParam(":id", $id);
            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $image = $row['image'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];
            $category_id = $row['category_id'];
            $category_name = $row['category_name'];
            // shorter way to do that is extract($row)
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Product Image</td>
                <td><img src="uploads/<?php echo $image; ?>" alt="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" width='100'></td>
            </tr>

            <tr>
                <td>Price</td>
                <td>RM <?php echo number_format((float)$price, 2, '.', ''); ?></td>
            </tr>
            <tr>
                <td>Promotion Price</td>
                <td>RM <?php echo number_format((float)$promotion_price, 2, '.', ''); ?></td>

            </tr>
            <tr>
                <td>Manufacture Date</td>
                <td><?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Expired Date</td>
                <td><?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Category Name</td>
                <td><?php echo htmlspecialchars($category_name, ENT_QUOTES);  ?></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                </td>
            </tr>
        </table>

    </div> <!-- end .container -->

</body>

</html>