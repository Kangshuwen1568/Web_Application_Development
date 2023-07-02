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
            $date_day = $_POST['date_day'];
            $date_month = $_POST['date_month'];
            $date_year = $_POST['date_year'];
            $account_status = $_POST['account_status'];

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
                $errors[] = "Please select a gender.";
            }

            // check date field is empty
            if (empty($date_day) || empty($date_month) || empty($date_year)) {
                $errors[] = "Please select a date of birth.";
            }

            // check account status field is empty
            if (empty($account_status)) {
                $errors[] = "Please select a account status.";
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
                    $query = "INSERT INTO customers SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, date_of_birth=:date_of_birth, registration=:registration, account_status=:account_status";
                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);

                    $date_of_birth = $date_year . '-' . $date_month . '-' . $date_day; // Define the $date_of_birth variable
                    $stmt->bindParam(':date_of_birth', $date_of_birth);

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
                    die('ERROR: ' . $exception->getMessage());
                }
            }
        }
        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <!--<table class='table table-hover table-responsive table-bordered'>-->

            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                <div class="form-text">Minimum 6 characters, starting with a letter, and only _ or - is allowed in between.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="form-text">Minimum 6 characters, at least 1 uppercase letter, 1 lowercase letter, and 1 number. No symbols allowed.</div>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>

            <div class="mb-3">
                <label for="firstname" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter firstname">
            </div>

            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter lastname">
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                    <label class="form-check-label" for="other">Other</label>
                </div>
            </div>

            <!--date of birth-->
            <div class="mb-3">
                <label for="dateofbirth" class="form-label">Date of Birth:</label>
                <div class="row">
                    <div class="col">
                        <select class="form-select" id="date_day" name="date_day">
                            <option value="" selected disabled>Day</option>
                            <?php
                            for ($day = 1; $day <= 31; $day++) {
                                echo "<option value='$day'>$day</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select" id="date_month" name="date_month">
                            <option value="" selected disabled>Month</option>
                            <?php
                            $months = array(
                                "January", "February", "March", "April", "May", "June",
                                "July", "August", "September", "October", "November", "December"
                            );
                            foreach ($months as $x => $month) {
                                $indexmonth = $x + 1;
                                echo "<option value='$indexmonth'>$month</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">

                        <select class="form-select" id="date_year" name="date_year">
                            <option value="" selected disabled>Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = 1900; $year <= $currentYear; $year++) {
                                echo "<option value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="account_status" class="form-label">Account Status:</label>
                <select class="form-select" id="account_status" name="account_status">
                    <option value="" selected disabled>Select Account Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Register</button>
            <!--</table>-->
        </form>


    </div>
    <!-- end .container -->


</body>

</html>