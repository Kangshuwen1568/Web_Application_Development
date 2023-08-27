<?php
include 'menu/validate_login.php';

$_SESSION['image'] = "customer";
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Update Customer</title>
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
        ?>
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <!-- PHP read record by ID will be here-->
        <?php
        //include 'file_upload.php';
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';
        //include 'file_upload.php';
        // read current record's data
        try {
            // prepare select query
            $query = "SELECT username, password, firstname, lastname, gender, date_of_birth, email, account_status, image FROM customers WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $username = $row['username'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $date_of_birth = $row['date_of_birth'];
            $email = $row['email'];
            $account_status = $row['account_status'];
            $image = $row['image'];
            // Get the old image value from the database
            $old_image = $image;
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- PHP post to update record will be here -->
        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE customers SET username=:username, firstname=:firstname, lastname=:lastname, image=:image, gender=:gender, date_of_birth=:date_of_birth, email=:email, account_status=:account_status WHERE id = :id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $email = htmlspecialchars(strip_tags($_POST['email']));
                $account_status = $_POST['account_status'];
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];

                // initialize an array to store error messages
                $errors = array();

                // Check if the password fields are not empty and valid
                if (!empty($old_password) && !empty($new_password) && !empty($confirm_password)) {
                    if (strlen($new_password) < 6) {
                        $errors[] = "New password should be at least 6 characters.";
                    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/", $new_password)) {
                        $errors[] = "New password should contain at least 1 uppercase letter, 1 lowercase letter, and 1 number. No symbols allowed.";
                    } elseif ($new_password !== $confirm_password) {
                        $errors[] = "New passwords do not match.";
                    } else {
                        // If the password fields are not empty and valid, include password update in the query
                        $query .= ", password=:password";
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    }
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Invalid email format.";
                }

                // Check if a new image is uploaded
                if (!empty($_FILES["image"]["name"])) {
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check if the uploaded file is an image
                    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($imageFileType, $allowed_extensions)) {
                        $errors[] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
                    } else {
                        $image = sha1_file($_FILES["image"]["tmp_name"]) . "-" . basename($_FILES["image"]["name"]);

                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image)) {
                            // Image uploaded successfully
                        } else {
                            $errors[] = "Error uploading the image.";
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

                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    //$stmt->bindParam(':password', $hashed_password); // Use the updated hashed password
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':account_status', $account_status);
                    $stmt->bindParam(':image', $image);
                    $stmt->bindParam(':id', $id);

                    if (isset($hashed_password)) {
                        $stmt->bindParam(':password', $hashed_password);
                    }

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
                // show errors
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>


        <!--HTML form to update record will be here -->
        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' value="<?php echo htmlspecialchars($username, ENT_QUOTES);  ?>" class='form-control' readonly /></td>
                </tr>
                <tr>
                    <td>Change Password</td>
                    <td>
                        <input type="password" class="form-control" name="old_password" placeholder="Old password" />
                        <input type="password" class="form-control" name="new_password" placeholder="New password" />
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password" />
                    </td>
                </tr>
                <tr>
                    <td>Firstname</td>
                    <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?>" class='form-control' readonly /></td>
                </tr>
                <tr>
                    <td>Lastname</td>
                    <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?>" class='form-control' readonly /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input type='radio' id='male' name='gender' value='male' <?php echo ($gender === 'male') ? 'checked' : ''; ?>>
                        <label for="male">Male</label><br>

                        <input type='radio' id='female' name='gender' value='female' <?php echo ($gender === 'female') ? 'checked' : ''; ?>>
                        <label for="female">Female</label><br>

                        <input type='radio' id='other' name='gender' value='other' <?php echo ($gender === 'other') ? 'checked' : ''; ?>>
                        <label for="other">Other</label>

                    </td>
                </tr>


                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?>" class='form-control' readonly /></td>
                </tr>

                <tr>
                    <td>email</td>
                    <td><input type='text' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' readonly /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td>
                        <input type='radio' id="active" name='account_status' value='active' <?php echo ($account_status === 'active') ? 'checked' : ''; ?>>
                        <label for="active">Active</label><br>

                        <input type='radio' id="inactive" name='account_status' value='inactive' <?php echo ($account_status === 'inactive') ? 'checked' : ''; ?>>
                        <label for="inactive">Inactive</label><br>

                    </td>
                </tr>
                <tr>
                    <td>Profile Image</td>
                    <td>
                        <img src="uploads/<?php echo htmlspecialchars($image, ENT_QUOTES); ?>" width="100px">
                        <br><br>
                        <input type="file" name="image" />
                    </td>

                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to read customer</a>
                    </td>
                </tr>
            </table>
        </form>




    </div>
    <!-- end .container -->
</body>

</html>