<?php
include 'menu/validate_login.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Create Product</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <!-- container -->
    <div class="container">
        <!-- navbar -->
        <?php
        include 'menu/navbar.php';
        ?>
        <div class="page-header">
            <h1>Create Product</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        date_default_timezone_set('Asia/Kuala_Lumpur');
        if ($_POST) {
            // include database connection
            include 'config/database.php';

            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $promotionPrice = $_POST['promotion_price'];
            $category_id = $_POST['category_id'];
            $manufactureDate = $_POST['manufacture_date'];
            $expiredDate = $_POST['expired_date'];

            // initialize an array to store error messages
            $errors = array();

            // check name field is empty
            if (empty($name)) {
                $errors[] = "Name is required.";
            }

            // check description field is empty
            if (empty($description)) {
                $errors[] = "Description is required.";
            }

            // check price field is empty
            if (empty($price)) {
                $errors[] = "Price is required.";
            } else if (!is_numeric($price)) {
                $errors[] = "Price must be number.";
            }

            // check promotion price field is empty
            if (empty($promotionPrice)) {
                $errors[] = "Promotion price is required.";
            } else if (!is_numeric($promotionPrice)) {
                $errors[] = "Promotion price must be number.";
            }

            // check manufacture date field is empty
            if (empty($manufactureDate)) {
                $errors[] = "Manufacture date is required.";
            }

            // check expired date field is empty
            if (empty($expiredDate)) {
                $errors[] = "Expired date is required.";
            }

            // Check if the promotion price is not cheaper than the original price
            if ($promotionPrice >= $price) {
                $errors[] = "Promotion price must be cheaper than the original price.";
            }

            // Check if the expiration date is not earlier than the manufacturing date
            if ($expiredDate <= $manufactureDate) {
                $errors[] = "Expired date must be later than the manufacture date.";
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
                    // insert query
                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, category_id=:category_id, manufacture_date=:manufacture_date, expired_date=:expired_date, created=:created";
                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $promotionPrice);
                    $stmt->bindParam(':category_id', $category_id);
                    $stmt->bindParam(':manufacture_date', $manufactureDate);
                    $stmt->bindParam(':expired_date', $expiredDate);

                    $created = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':created', $created);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
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
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><input type='text' name='description' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' /></td>
                </tr>

                <tr>
                    <td>Promotion_price</td>
                    <td><input type='text' name='promotion_price' class='form-control' /></td>
                </tr>

                <tr>
                    <td>Category Name</td>
                    <td><select class="form-select" name="category_id">
                            <?php
                            include 'config/database.php';
                            //in "category" table中得到"category_name"的data
                            $query = "SELECT id, category_name FROM categories";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // 下拉菜单的选项
                            foreach ($categories as $category) { // Use $category['id'] as the value for each option
                                $categoryID = $category['id'];
                                $categoryName = $category['category_name'];
                                echo "<option value='$categoryID'>$categoryName</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Manufacture_date</td>
                    <td><input type='date' name='manufacture_date' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired_date</td>
                    <td><input type='date' name='expired_date' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->

</html>