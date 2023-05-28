<!DOCTYPE html>
<html>

<head>
    <title>Date Today</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">


        <?php
        // Get the current date
        $currentDate = date('Y-m-d');
        $currentYear = date('Y');
        $currentMonth = date('m');
        $currentDay = date('d');
        ?>

        <form>
            <div class="row">
                <div class="col-md-4">
                    <label for="day">Day</label>
                    <select class="form-select" name="day" id="day">
                        <?php
                        // Generate the options for days
                        for ($day = 1; $day <= 31; $day++) {
                            $selected = ($day == $currentDay) ? 'selected' : '';
                            echo "<option value='$day' $selected>$day</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="month">Month</label>
                    <select class="form-select" name="month" id="month">
                        <?php
                        // Generate the options for months
                        $months = [
                            '01' => 'January',
                            '02' => 'February',
                            '03' => 'March',
                            '04' => 'April',
                            '05' => 'May',
                            '06' => 'June',
                            '07' => 'July',
                            '08' => 'August',
                            '09' => 'September',
                            '10' => 'October',
                            '11' => 'November',
                            '12' => 'December'
                        ];

                        foreach ($months as $monthNum => $monthName) {
                            $selected = ($monthNum == $currentMonth) ? 'selected' : '';
                            echo "<option value='$monthNum' $selected>$monthName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year">Year</label>
                    <select class="form-select" name="year" id="year">
                        <?php
                        // Generate the options for years
                        for ($year = $currentYear - 10; $year <= $currentYear + 10; $year++) {
                            $selected = ($year == $currentYear) ? 'selected' : '';
                            echo "<option value='$year' $selected>$year</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</body>

</html>