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

        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            //include database connection
            include 'config/database.php';
        }

        ?>

        <!-- html form here where the product information will be entered -->
        <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
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
    <!-- end .container -->
</body>

</html>