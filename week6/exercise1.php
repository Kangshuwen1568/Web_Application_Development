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
            $year = $_POST['date_year'];
            $month = $_POST["date_month"];
            $day = $_POST["date_day"];

            date_default_timezone_set('Asia/Kuala_Lumpur');
            $age = $currentDate->format('Y') - $birthDate->format('Y');
            if ($currentDate->format('md') < $birthDate->format('md')) {
                $age--;
            }

            $zodiac = '';
            $constellation = '';

            $currentDate = new DateTime();
            $birthDate = new DateTime("$year-$month-$day");

            $animalZodiac = array(
                'Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 'Snake',
                'Horse', 'Goat', 'Monkey', 'Rooster', 'Dog', 'Pig'
            );

            $zodiacIndex = ($year - $startYear) % 12;
            $zodiac = $animalZodiac[$zodiacIndex];
            /*
            if (($month == 'March' && $day >= 21) || ($month == 'April' && $day <= 19)) {
                $constellation = 'Aries';
            } elseif (($month == 'April' && $day >= 20) || ($month == 'May' && $day <= 20)) {
                $constellation = 'Taurus';
            } elseif (($month == 'May' && $day >= 21) || ($month == 'June' && $day <= 20)) {
                $constellation = 'Gemini';
            } elseif (($month == 'June' && $day >= 21) || ($month == 'July' && $day <= 22)) {
                $constellation = 'Cancer';
            } elseif (($month == 'July' && $day >= 23) || ($month == 'August' && $day <= 22)) {
                $constellation = 'Leo';
            } elseif (($month == 'August' && $day >= 23) || ($month == 'September' && $day <= 22)) {
                $constellation = 'Virgo';
            } elseif (($month == 'September' && $day >= 23) || ($month == 'October' && $day <= 22)) {
                $constellation = 'Libra';
            } elseif (($month == 'October' && $day >= 23) || ($month == 'November' && $day <= 21)) {
                $constellation = 'Scorpio';
            } elseif (($month == 'November' && $day >= 22) || ($month == 'December' && $day <= 21)) {
                $constellation = 'Sagittarius';
            } elseif (($month == 'December' && $day >= 22) || ($month == 'January' && $day <= 19)) {
                $constellation = 'Capricorn';
            } elseif (($month == 'January' && $day >= 20) || ($month == 'February' && $day <= 18)) {
                $constellation = 'Aquarius';
            } elseif (($month == 'February' && $day >= 19) || ($month == 'March' && $day <= 20)) {
                $constellation = 'Pisces';
            }*/



            echo "<p>Age: $age years old</p>";
            echo "<p>Animal zodiac sign: $zodiac</p>";
            echo "<p>Zodiac constellation: $constellation</p>";
        }
        ?>
    </div>
</body>

</html>