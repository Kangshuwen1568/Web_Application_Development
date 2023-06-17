<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Registration Form</h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter firstname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter lastname" required>
            </div>
            <div class="mb-3">
                <label for="dateofbirth" class="form-label">Date of Birth:</label>
                <div class="row">
                    <div class="col">
                        <select class="form-select" id="date_day" name="date_day" required>
                            <option value="">Day</option>
                            <?php
                            for ($day = 1; $day <= 31; $day++) {
                                echo "<option value='$day'>$day</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select" id="date_month" name="date_month" required>
                            <option value="">Month</option>
                            <?php
                            $months = array(
                                "January", "February", "March", "April", "May", "June",
                                "July", "August", "September", "October", "November", "December"
                            );
                            foreach ($months as $month) {
                                echo "<option value='$month'>$month</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">

                        <select class="form-select" id="date_year" name="date_year" required>
                            <option value="">Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = 1990; $year <= $currentYear; $year++) {
                                echo "<option value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="other" value="other" required>
                    <label class="form-check-label" for="other">Other</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                <div class="form-text">Minimum 6 characters, starting with a letter, and only _ or - is allowed in between.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="form-text">Minimum 6 characters, at least 1 uppercase letter, 1 lowercase letter, and 1 number. No symbols allowed.</div>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email@gmail.com" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Register</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $date_day = $_POST['date_day'];
            $date_month = $_POST['date_month'];
            $date_year = $_POST['date_year'];
            $gender = $_POST['gender'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $email = $_POST['email'];

            if (empty($firstname)) {
                $errors[] = "Firstname is required.";
            }

            if (empty($lastname)) {
                $errors[] = "Lastname is required.";
            }

            if (empty($date_day) || empty($date_month) || empty($date_year)) {
                $errors[] = "Please select a date of birth.";
            }

            if (empty($gender)) {
                $errors[] = "Please select a gender.";
            }

            if (empty($username)) {
                $errors[] = "Username is required.";
            } elseif (!preg_match("/^[a-zA-Z][a-zA-Z0-9_-]{5,}$/", $username)) {
                $errors[] = "Username should be at least 6 characters, first must be a character cannot be number, and contain only _ or - is allowed in between.";
            }

            if (empty($password)) {
                $errors[] = "Password is required.";
            } elseif (strlen($password) < 6) {
                $errors[] = "Password should be at least 6 characters.";
            } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/", $password)) {
                $errors[] = "Password should contain at least 1 uppercase letter, 1 lowercase letter, and 1 number. No symbols allowed.";
            } elseif ($password !== $confirm_password) {
                $errors[] = "Passwords do not match. Important! Please make sure the password is same.";
            }

            if (empty($email)) {
                $errors[] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format, Must be email@gmail.com.";
            }

            // If no any errors, then will process the registration
            if (empty($errors)) {
                echo "Registration successful!";
            } else {
                // Display error messages
                foreach ($errors as $error) {
                    echo "<p class='text-danger'>$error</p>";
                }
            }
        }
        ?>

    </div>


</body>

</html>