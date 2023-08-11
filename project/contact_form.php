<?php
include 'menu/validate_login.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <!-- navbar -->
        <?php
        include 'menu/navbar.php';
        ?>

        <div class="page-header">
            <h1>Contact Form</h1>
        </div>

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td><textarea name='message' class='form-control' rows='10' cols='30'></textarea></td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' class='form-control' placeholder='name@email.com' /></td>
                </tr>

                <tr>
                    <td>Phone Number</td>
                    <td><input type='text' name='phonenumber' class='form-control' /></td>
                </tr>

                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                </td>
                </tr>
            </table>
        </form>

        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';

            $name = $_POST['name'];
            $message = $_POST['message'];
            $email = $_POST['email'];
            $phonenumber = $_POST['phonenumber'];

            // initialize an array to store error messages
            $errors = array();

            // check name field is empty
            if (empty($name)) {
                $errors[] = "Name is required.";
            }

            // check message field is empty
            if (empty($message)) {
                $errors[] = "Message is required.";
            }

            // check email field is empty
            if (empty($email)) {
                $errors[] = "Email is required.";
            }

            // check phonenumber field is empty
            if (empty($phonenumber)) {
                $errors[] = "Phone Number is required.";
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
                    $query = "INSERT INTO contactus SET name=:name, message=:message, email=:email, phonenumber=:phonenumber";
                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':message', $message);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':phonenumber', $phonenumber);

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
    </div>

</body>

</html>