<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Name</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Name Form</h1>
        <form method="post" action="">
            <div class="mb-1">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="mb-1">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $firstName = $_POST["firstname"];
            $lastName = $_POST["lastname"];

            $FirstName = ucwords(strtolower($firstName));
            $LastName = ucwords(strtolower($lastName));

            echo "<h2>Name:</h2>";
            echo "<p>" . $LastName . " " . $FirstName . "</p>";
        }
        ?>
    </div>
</body>

</html>