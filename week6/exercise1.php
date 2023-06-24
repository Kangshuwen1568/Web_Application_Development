<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Birthday Form</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="dateofbirth" class="form-label">Date of Birth:</label>
                <div class="row">
                    <div class="col">
                        <select class="form-select" id="day" name="day" required>
                            <option value="">Day</option>
                            <?php
                            for ($day = 1; $day <= 31; $day++) {
                                echo "<option value='$day'>$day</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select" id="month" name="month" required>
                            <option value="">Month</option>
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
                        <select class="form-select" id="year" name="year" required>
                            <option value="">Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = 1900; $year <= $currentYear; $year++) {
                                echo "<option value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $day = $_POST['day'];
            $months = $_POST['month'];
            $year = $_POST['year'];

            $zodiac = "";
            if (checkdate($months, $day, $year)) {
                $zodiac = array(
                    "Rat", "Cow", "Tiger", "Rabbit", "Dragon", "Snake",
                    "Horse", "Sheep", "Monkey", "Chicken", "Dog", "Pig"
                );

                $calculate_zodiac = ($year - 1900) % 12;
                $Chinese_zodiac = $zodiac[$calculate_zodiac];



                echo "<p>Date of Birth: $day /" . $months . "/ $year</p>";
                echo "<p>Zodiac sign: $Chinese_zodiac</p>";
                //echo "<p>Zodiac constellation: $constellation</p>";
            } else {
                echo "Please select the valid date.";
            }
        }
        ?>
    </div>
</body>

</html>