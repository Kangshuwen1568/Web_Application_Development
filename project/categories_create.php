<!DOCTYPE HTML>
<html>

<head>
    <title>Create Categories</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <!-- container -->
    <div class="container">
        <!-- navbar -->
        <?php
        include 'navbar.php';
        ?>
        <div class="page-header">
            <h1>Create Categories</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';

            $name = $_POST['name'];
            $description = $_POST['description'];

            // initialize an array to store error messages
            $errors = array();

            // check name field is empty
            if (empty($name)) {
                $errors[] = "Category Name is required.";
            }

            // check description field is empty
            if (empty($description)) {
                $errors[] = "Description is required.";
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
                    $query = "INSERT INTO categories SET name=:name, description=:description";
                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);

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
                    <td>Category Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><input type='text' name='description' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='categories_read.php' class='btn btn-danger'>Back to read categories</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->

</html>