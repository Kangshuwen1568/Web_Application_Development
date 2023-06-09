<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number SumDecrease</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container mt-5">
        <h1>Number Sum Decrease</h1>

        <form method="POST" action="">
            <div class="mb-1">
                <label for="number" class="form-label">Number</label>
                <input type="text" class="form-control" id="number" name="number">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit:</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $number = $_POST["number"];


            if (empty($number) || !is_numeric($number)) {
                echo '<div class="alert alert-danger" role="alert">Please fill in a number.</div>';
            } else if ($number <= 1) {
                echo '<div class="alert alert-danger" role="alert">Please enter a positive number.</div>';
            } else {
                $number = (int)$number;
                $sum = 0;

                for ($i = $number; $i >= 1; $i--) {
                    $sum += $i;
                }

                echo "<h2>Sum:</h2>";
                echo implode('+', range(1, $number)) . ' = ' . $sum;
            }
        }

        ?>
    </div>

</body>

</html>