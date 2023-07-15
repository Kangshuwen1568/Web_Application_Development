<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <!-- navbar -->
        <?php
        include 'navbar.php';
        ?>
        <div class="page-header">
            <h1>Create Customer</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';

            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $date_of_birth = $_POST['date_of_birth'];
            $email = $_POST['email'];
            $account_status = $_POST['account_status'];
            date_default_timezone_set('asia/Kuala_Lumpur');
            // initialize an array to store error messages
            $errors = array();

            // check username field is empty
            if (empty($username)) {
                $errors[] = "Username is required.";
            } elseif (!preg_match("/^[a-zA-Z][a-zA-Z0-9_-]{5,}$/", $username)) {
                $errors[] = "Username should be at least 6 characters, first must be a character cannot be number, and contain only _ or - is allowed in between.";
            }

            // check password field is empty
            if (empty($password)) {
                $errors[] = "Password is required.";
            } elseif (strlen($password) < 6) {
                $errors[] = "Password should be at least 6 characters.";
            } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/", $password)) {
                $errors[] = "Password should contain at least 1 uppercase letter, 1 lowercase letter, and 1 number. No symbols allowed.";
            } elseif ($password !== $confirm_password) {
                $errors[] = "Passwords do not match. Important! Please make sure the password is same.";
            }

            // check firstname field is empty
            if (empty($firstname)) {
                $errors[] = "Firstname is required.";
            }

            // check lastname field is empty
            if (empty($lastname)) {
                $errors[] = "Lastname is required.";
            }

            // check gender field is empty
            if (empty($gender)) {
                $errors[] = "Gender is required.";
            }

            // check date field is empty
            if (empty($date_of_birth)) {
                $errors[] = "Date of birth is required.";
            }

            // check email field is empty
            if (empty($email)) {
                $errors[] = "Email is required.";
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Invalid email format.";
                }
            }

            // check account status field is empty
            if (empty($account_status)) {
                $errors[] = "Account status is required.";
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
                    $query = "INSERT INTO customers SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, date_of_birth=:date_of_birth, email=:email, registration=:registration, account_status=:account_status";
                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':account_status', $account_status);

                    $registration = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':registration', $registration);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
                // show error
                catch (PDOException $exception) {
                    //die('ERROR: ' . $exception->getMessage());
                    if ($exception->getCode() == 23000) {
                        echo '<div class= "alert alert-danger role=alert">' . 'Username has been taken' . '</div>';
                    } else {
                        echo '<div class= "alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                    }
                }
            }
        }
        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>

                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" id="username" class="form-control" /></td>
                </tr>

                <tr>
                    <td>Password</td>
                    <td><input type="password" class="form-control" id="password" name="password" /></td>

                </tr>

                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" class="form-control" id="confirm_password" name="confirm_password" /></td>
                </tr>

                <tr>
                    <td>First Name</td>
                    <td><input type="text" class="form-control" id="firstname" name="firstname" placeholder="" /></td>
                </tr>

                <tr>
                    <td>Last Name</td>
                    <td><input type="text" class="form-control" id="lastname" name="lastname" placeholder="" /></td>
                </tr>

                <tr>
                    <td>Gender</td>
                    <td><input type="radio" name="gender" id="male" value="male" checked>
                        <label for="male">Male</label><br>
                        <input type="radio" name="gender" id="female" value="female">
                        <label for="female">Female</label><br>
                        <input type="radio" name="gender" id="other" value="other">
                        <label for="other">Other</label>
                </tr>

                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='date_of_birth' class='form-control' value="<?php echo isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : ''; ?>" /></td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" id="email" class="form-control"></td>
                </tr>

                <tr>
                    <td>Account Status</td>
                    <td><input type="radio" name="account_status" id="active" value="active" checked>
                        <label class="form-check-label" for="active">Active</label>

                        <input type="radio" name="account_status" id="inactive" value="inactive">
                        <label class="form-check-label" for="inactive">Inactive</label>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td><input type='submit' value='Save' class='btn btn-primary' /></td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->


</body>

</html>