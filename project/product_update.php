<?php
include 'menu/validate_login.php';
include 'menu/input_disabled.php';
$_SESSION['image'] = "product";
$target_dir = "uploads/"; // Initialize the target directory variable
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Update Product</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- CSS -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <!--container-->
    <div class="container">
        <?php
        include 'menu/navbar.php';
        // include database connection
        include 'config/database.php';
        ?>
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
        <!-- PHP read record by ID will be here-->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, name, description, price, promotion_price, category_id, manufacture_date, expired_date, image FROM products WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $category_id = $row['category_id'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];
            $image = $row['image'];
            // Get the old image value from the database
            $old_image = $image;
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
        <?php
        $file_upload_error_messages = "";
        if ($customer_status == 'inactive') {
            echo "<div class='alert alert-danger'>Your account is inactive. Your account does not have permission.</div>";
        } else {
            // check if form was submitted
            if ($_POST) {
                try {
                    // write update query
                    // in this case, it seemed like we have so many fields to pass and
                    // it is better to label them and not use question marks
                    $query = "UPDATE products SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, image=:image, category_id=:category_id, manufacture_date=:manufacture_date, expired_date=:expired_date WHERE id = :id";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    // posted values
                    $name = htmlspecialchars(strip_tags($_POST['name']));
                    $description = htmlspecialchars(strip_tags($_POST['description']));
                    //$price = htmlspecialchars(strip_tags($_POST['price']));
                    //$promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                    $category_id = htmlspecialchars(strip_tags($_POST['category_id']));
                    $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                    $expired_date = htmlspecialchars(strip_tags($_POST['expired_date']));
                    $price = floatval(str_replace(['RM', ',', ' '], '', $_POST['price']));
                    $promotion_price = floatval(str_replace(['RM', ',', ' '], '', $_POST['promotion_price']));
                    // initialize an array to store error messages
                    $errors = array();
                    // Check if the promotion price is not cheaper than the original price
                    if ($promotion_price >= $price) {
                        $errors[] = "Promotion price must be cheaper than the original price.";
                    }

                    // Check if the expiration date is not earlier than the manufacturing date
                    if ($expired_date <= $manufacture_date) {
                        $errors[] = "Expired date must be later than the manufacture date.";
                    }

                    // Check if a new image is uploaded
                    if (!empty($_FILES["image"]["name"])) {
                        //$target_dir = "uploads/";
                        $target_file = $target_dir . basename($_FILES["image"]["name"]);
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        // Check if the uploaded file is an image
                        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                        if (!in_array($imageFileType, $allowed_extensions)) {
                            $file_upload_error_messages .= "Only JPG, JPEG, PNG, and GIF files are allowed.<br>";
                        } else {
                            // Additional validation for image dimensions and size
                            list($width, $height) = getimagesize($_FILES["image"]["tmp_name"]);
                            if ($width !== $height) {
                                $file_upload_error_messages .= "Only square images are allowed.<br>";
                            }

                            // Check maximum width and height
                            if ($width > 600 || $height > 600) {
                                $file_upload_error_messages .= "Only square images are allowed.<br>";
                            }
                            if ($_FILES["image"]["size"] > (512000)) {
                                $file_upload_error_messages .= "Image size should not exceed 512KB.<br>";
                            }
                            // Generate a unique filename
                            $image = sha1_file($_FILES["image"]["tmp_name"]) . "-" . basename($_FILES["image"]["name"]);

                            // Delete the old image file if it's not the default image and exists
                            if ($old_image !== "product_image_coming_soon.jpg" && file_exists($target_dir . $old_image)) {
                                unlink($target_dir . $old_image);
                            }

                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image)) {
                                // Image uploaded successfully
                            } else {
                                $file_upload_error_messages .= "Error uploading the image.<br>";
                            }
                        }
                    } else {
                        // If no new image is uploaded, keep the old image filename
                        $image = $old_image;
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
                        if (empty($file_upload_error_messages)) {
                            //bind the parameters
                            $stmt->bindParam(':name', $name);
                            $stmt->bindParam(':description', $description);
                            $stmt->bindParam(':price', $price);
                            $stmt->bindParam(':promotion_price', $promotion_price);
                            $stmt->bindParam(':category_id', $category_id);
                            $stmt->bindParam(':manufacture_date', $manufacture_date);
                            $stmt->bindParam(':expired_date', $expired_date);
                            $stmt->bindParam(':image', $image);
                            $stmt->bindParam(':id', $id);
                            // Execute the query
                            if ($stmt->execute()) {
                                echo "<div class='alert alert-success'>Record was updated.</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                            }
                        } else {
                            // Display image-related error messages
                            echo "<div class='alert alert-danger'>";
                            echo "<div>{$file_upload_error_messages}</div>";
                            echo "<div>Update the record to upload photo.</div>";
                            echo "</div>";
                        }
                    }
                } catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }
        }
        ?>

        <!--HTML form to update record will be here -->
        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' <?php echo $inputDisabled; ?> /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control' <?php echo $inputDisabled; ?>><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="RM <?php echo number_format($price, 2); ?>" class='form-control' <?php echo $inputDisabled; ?> /></td>
                </tr>

                <tr>
                    <td>Promotion price</td>
                    <td><input type='text' name='promotion_price' value="RM <?php echo number_format($promotion_price, 2); ?>" class='form-control' <?php echo $inputDisabled; ?> /></td>
                </tr>


                <tr>
                    <td>Product Image</td>
                    <td>
                        <img src="uploads/<?php echo htmlspecialchars($image, ENT_QUOTES); ?>" width="100px" <?php echo $inputDisabled; ?>>
                        <br><br>
                        <input type="file" name="image" <?php echo $inputDisabled; ?> />
                    </td>
                </tr>

                <tr>
                    <td>Category Name</td>
                    <td><select class=" form-select" name="category_id" <?php echo $inputDisabled; ?>>
                            <?php
                            //in "category" table中得到"category_name"的data
                            $query = "SELECT id, category_name FROM categories";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // 下拉菜单的选项
                            foreach ($categories as $category) { // Use $category['id'] as the value for each option
                                $categoryID = $category['id'];
                                $categoryName = $category['category_name'];
                                // Check if the current category ID matches the product's category ID
                                $selected = ($categoryID == $category_id) ? 'selected' : '';
                                echo "<option value='$categoryID' $selected>$categoryName</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Manufacture date</td>
                    <td><input type='date' name='manufacture_date' value="<?php echo htmlspecialchars($manufacture_date, ENT_QUOTES); ?>" class='form-control' <?php echo $inputDisabled; ?> /></td>
                </tr>
                <tr>
                    <td>Expired date</td>
                    <td><input type='date' name='expired_date' value="<?php echo htmlspecialchars($expired_date, ENT_QUOTES); ?>" class='form-control' <?php echo $inputDisabled; ?> /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' <?php echo $inputDisabled; ?> />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>




    </div>
    <!-- end .container -->
</body>

</html>