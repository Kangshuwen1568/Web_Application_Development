<?php
session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
    <!-- container -->
    <div class="container">

        <nav class="container navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <!--logo-->
                <a class="navbar-brand">SW</a>
            </div>
        </nav>

        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';

            $username = $_POST['username_email'];
            $password = $_POST['password'];

            $errors = array();

            //check if username/email is empty
            if (empty($username)) {
                $errors[] = "Username/email is required.";
            }

            //check if password is empty
            if (empty($password)) {
                $errors[] = "Password is required.";
            }

            // check if any errors occurred
            /*if (!empty($errors)) {
                $errorMessage = "<div class='alert alert-danger'>";
                // display out the error messages
                foreach ($errors as $error) {
                    $errorMessage .= $error . "<br>";
                }
                $errorMessage .= "</div>";
                echo $errorMessage;*/

            if (!empty($errors)) {
                $errorMessage = "<ul>";
                // concatenate the error messages
                foreach ($errors as $error) {
                    $errorMessage .= "<li>{$error}</li>";
                }
                $errorMessage .= "</ul>";

                echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var errorText = document.getElementById('errorText');
                    errorText.innerHTML = '{$errorMessage}';
                    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                });
            </script>";
            } else {
                try {
                    // select query
                    $query = "SELECT id, username, password, email, account_status FROM customers WHERE username=:username_email OR email=:username_email";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':username_email', $username);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$row) {
                        // Username/email not found
                        echo "<div class='alert alert-danger'>Username/email not found.</div>";
                    } else {
                        // Check if the entered password matches the hashed password from the database
                        if (password_verify($password, $row['password'])) {  //$password（user打的），$row['password']
                            // Check if the account is active
                            if ($row['account_status'] == 'active') {
                                // Login successful
                                $_SESSION['username'] = $row['username'];
                                header("Location: index.php");
                                exit();
                            } elseif ($row['account_status'] == 'inactive') {
                                // Inactive account
                                $_SESSION['username'] = $row['username']; // Store username in session
                                header("Location: index.php"); // Redirect to desired page after login
                                exit();
                                /*} else {

                                // Inactive account
                                echo "<div class='alert alert-danger'>Inactive account.</div>";
                            }*/
                            } else {
                                // Incorrect password
                                echo "<div class='alert alert-danger'>Incorrect password.</div>";
                            }
                        }
                    }
                } catch (PDOException $exception) { // show error
                    die('ERROR: ' . $exception->getMessage());
                }
            }
        }
        ?>


        <!-- html form here where the product information will be entered -->
        <div class="d-flex flex-column min-vh-100 center align-items-center pt-5 mt-5">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="border border-3 border-black rounded p-4">
                    <div class="card-title">
                        <h3>Login</h3>
                    </div>

                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username_email" class="form-label">Username/Email</label>
                            <input type="text" class="form-control" id="username_email" name="username_email" placeholder="username/email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="password">
                        </div>
                        <button type="submit" class="btn btn-primary mb-3">Login</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- end .container -->
</body>

</html>

<!-- bootstrap error modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">localhost says:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="errorText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--https://getbootstrap.com/docs/5.3/components/modal/-->