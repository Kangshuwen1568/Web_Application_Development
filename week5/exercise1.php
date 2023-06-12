<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Name Form</title>
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

            <div class="row">

                <div class="col">
                    <label for="day" class="form-label">Day</label>
                    <select class="form-select" id="day" name="day">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col">
                    <label for="month" class="form-label">Month</label>
                    <select class="form-select" id="month" name="month">
                        <?php
                        $months = [
                            "January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                        ];

                        foreach ($months as $index => $month) {
                            $value = $index + 1;
                            echo "<option value='$value'>$month</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col">

                    <label for="year" class="form-label">Year</label>
                    <select class="form-select" id="year" name="year">
                        <?php
                        for ($i = 1990; $i <= 2023; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>


        </form>
        <?php
        if (isset($_POST['submit'])) {
            $firstName = $_POST["firstname"];
            $lastName = $_POST["lastname"];
            $year = $_POST["year"];
            $month = $_POST["month"];
            $day = $_POST["day"];

            $FirstName = ucwords(strtolower($firstName));
            $LastName = ucwords(strtolower($lastName));

            $currentDate = new DateTime();
            $birthDate = new DateTime("$year-$month-$day");

            $age = $currentDate->format('Y') - $birthDate->format('Y');
            if ($currentDate->format('md') < $birthDate->format('md')) {
                $age--;
            }

            if ($age >= 18) {
                echo "<p>Name: " . $LastName . " " . $FirstName . "</p>";
                echo "<p>Birthday: $day " . date("F", mktime(0, 0, 0, $month, 10)) . " $year</p>";
                echo "<p>Age: $age years old</p>";
            } else {
                echo '<div class="alert alert-danger" role="alert">You must be 18 year old or above.</div>';
            }
        }
        ?>


    </div>
</body>

</html>