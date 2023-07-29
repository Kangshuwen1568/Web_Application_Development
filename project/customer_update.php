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
        include 'navbar.php';
        // include database connection
        include 'config/database.php';
        ?>
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <!-- PHP read record by ID will be here-->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT username, password, firstname, lastname, gender, date_of_birth, email, registration, account_status FROM customers WHERE id = ? LIMIT 0,1";
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
            $registration = $row['registration'];
            $account_status = $row['account_status'];
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
                $query = "UPDATE customers SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, date_of_birth=: date_of_birth, email=:email, registration=:registration, account_status=:account_status WHERE id = :id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $old_password = htmlspecialchars(strip_tags($_POST['old_password']));
                $new_password = htmlspecialchars(strip_tags($_POST['new_password']));
                $comfirm_password = htmlspecialchars(strip_tags($_POST['comfirm_password']));
                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                $email = htmlspecialchars(strip_tags($_POST['email']));
                $registration = htmlspecialchars(strip_tags($_POST['registration']));
                $account_status = htmlspecialchars(strip_tags($_POST['account_status']));
                // initialize an array to store error messages
                $errors = array();
                // Check if the password fields are not empty and valid
                if (!empty($_POST['old_password']) || !empty($_POST['new_password']) || !empty($_POST['confirm_password'])) {
                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];
                    $confirm_password = $_POST['confirm_password'];

                    if (strlen($new_password) < 6) {
                        $errors[] = "New password should be at least 6 characters.";
                    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/", $new_password)) {
                        $errors[] = "New password should contain at least 1 uppercase letter, 1 lowercase letter, and 1 number. No symbols allowed.";
                    } elseif ($new_password !== $confirm_password) {
                        $errors[] = "New passwords do not match.";
                    }
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
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
                    $stmt->bindParam(':password', $hashed_password);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':registration', $registration);
                    $stmt->bindParam(':account_status', $account_status);
                    $stmt->bindParam(':id', $id);
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' value="<?php echo htmlspecialchars($username, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Change Password</td>
                    <td>
                        <input type="password" class="form-control" name="old_password" placeholder="old password" />
                        <input type="password" class="form-control" name="new_password" placeholder="new password" />
                        <input type="password" class="form-control" name="confirm_password" placeholder="confirm password" />
                    </td>
                </tr>
                <tr>
                    <td>Firstname</td>
                    <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Lastname</td>
                    <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input type='radio' id="male" name='gender' value='male' <?php if ($row['gender'] == "Male") {
                                                                                        echo 'checked';
                                                                                    } ?>>
                        <label for="male">Male</label><br>
                        <input type='radio' id="female" name='gender' value='female' <?php if ($row['gender'] == "Female") {
                                                                                            echo 'checked';
                                                                                        } ?>>
                        <label for="female">Female</label><br>
                        <input type='radio' id="other" name='gender' value='other' <?php if ($row['gender'] == "Other") {
                                                                                        echo 'checked';
                                                                                    } ?>>
                        <label for="other">Other</label>
                    </td>
                </tr>

                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>

                <tr>
                    <td>email</td>
                    <td><input type='text' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Registration</td>
                    <td><input type='datetime-local' name='registration' value="<?php echo htmlspecialchars($registration, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td>
                        <input type='radio' id="active" name='account_status' value='active' <?php if ($row['account_status'] == "Active") {
                                                                                                    echo 'checked';
                                                                                                } ?>>
                        <label for="active">Active</label><br>
                        <input type='radio' id="inactive" name='account_status' value='inactive' <?php if ($row['account_status'] == "Inactive") {
                                                                                                        echo 'checked';
                                                                                                    } ?>>
                        <label for="inactive">Inactive</label><br>
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