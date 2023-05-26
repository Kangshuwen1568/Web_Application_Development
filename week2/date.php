<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>



</head>

<body>
    <div class="container mt-5">
        <!-- heading name -->
        <div class="fs-1">
            <strong>What is your date of birth?</strong>
        </div>


        <div class="row">
            <!-- menu of day -->
            <div class="col">
                <div class="dropdown">
                    <button class="btn btn-info btn-lg dropdown-toggle" type="button" id="dayDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Day
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dayDropdown">
                        <?php
                        for ($day = 1; $day <= 31; $day++) {
                            echo "<li><a class='dropdown-item' href='#'onclick='updateDropdown(\"dayDropdown\", $day)'>$day</a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- menu of month -->
            <div class="col">
                <div class="dropdown">
                    <button class="btn btn-warning btn-lg dropdown-toggle" type="button" id="monthDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Month
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="monthDropdown">
                        <?php
                        for ($month = 1; $month <= 12; $month++) {
                            echo "<li><a class='dropdown-item' href='#'onclick='updateDropdown(\"monthDropdown\", $month)'>$month</a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- menu of year -->
            <div class="col">
                <div class="dropdown">
                    <button class="btn btn-danger btn-lg dropdown-toggle" type="button" id="yearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Year
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="yearDropdown">
                        <?php
                        $currentYear = date('Y');
                        for ($year = 1900; $year <= $currentYear; $year++) {
                            echo "<li><a class='dropdown-item' href='#'onclick='updateDropdown(\"yearDropdown\", $year)'>$year</a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- this function is when select the option then will display in menubox -->
    <script>
        function updateDropdown(dropdownId, value) {
            let dropdownButton = document.getElementById(dropdownId);
            dropdownButton.textContent = value;
        }
    </script>

</body>


</html>