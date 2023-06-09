<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container mt-5">
        <h1>Number Sum</h1>
        <form method="POST" action="">
            <div class="mb-1">
                <label for="firstnumber" class="form-label">First Number:</label>
                <input type="text" class="form-control" id="firstnumber" name="firstnumber">
            </div>
            <div class="mb-1">
                <label for="lastnumber" class="form-label">Last Number:</label>
                <input type="text" class="form-control" id="lastnumber" name="lastnumber">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $firstnumber = $_POST["firstnumber"];
            $lastnumber = $_POST["lastnumber"];

            if (!is_numeric($lastnumber) || !is_numeric($lastnumber)) {
                echo '<div class="alert alert-danger" role="alert">Please fill in a number.</div>';
            } else {
                $sum = $firstnumber + $lastnumber;

                echo "<h2>Sum:</h2>";
                echo "<p>" . $sum . "</p>";
            }
        }
        ?>
    </div>

</body>

</html>