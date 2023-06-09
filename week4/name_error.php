<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Name_error</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container mt-5">
        <h1>Name</h1>
        <form method="POST" action="">
            <div class="mb-1">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" name="first_name">
            </div>
            <div class="mb-1">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="last_name">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $firstName = $_POST["first_name"];
            $lastName = $_POST["last_name"];

            if (empty($firstName) || empty($lastName)) {
                echo '<div class="alert alert-danger" role="alert">Please enter your name.</div>';
            } else {
                $FirstName = ucwords(strtolower($firstName));
                $LastName = ucwords(strtolower($lastName));

                echo "<h2>Name:</h2>";
                echo "<p>" . $LastName . " " . $FirstName . "</p>";
            }
        }
        ?>
    </div>

</body>

</html>