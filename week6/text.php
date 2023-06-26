<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Week 6 Q2</title>
</head>

<body>
    <div class="container">
        <h1 class="my-3">Question 2</h1>
        <form method="POST" action="">

            <div class="row my-2">
                <div class="form-group my-1">
                    <label for="malaysianIC">Malaysian IC:</label>
                    <input type="text" class="form-control" id="malaysianIC" name="malaysianIC" placeholder="e.g. 010203101234" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary my-2" name="submit">Submit</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {

            $malaysianIC = $_POST['malaysianIC'];
            $ICPattern = "/^\d{12}$/";
            $month = array('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');

            if (!empty($malaysianIC) && preg_match($ICPattern, $malaysianIC)) {

                // extract 2 numbers start from index X
                $yearOfBirth = substr($malaysianIC, 0, 2);
                $monthOfBirth = substr($malaysianIC, 2, 2);
                $dayOfBirth = substr($malaysianIC, 4, 2);
                $placeOfBirth = substr($malaysianIC, 6, 2);

                if ($yearOfBirth > (date('Y') - 2000) || ($yearOfBirth == (date('Y') - 2000) && $monthOfBirth > date('m')) || ($yearOfBirth == (date('Y') - 2000) && $monthOfBirth == date('m') && $dayOfBirth > date('d'))) {
                    $yearOfBirth += 1900;
                } else {
                    $yearOfBirth += 2000;
                }

                if (checkdate($monthOfBirth, $dayOfBirth, $yearOfBirth)) {

                    $zodiacArray = array("Monkey", "Rooster", "Dog", "Pig", "Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Goat");
                    $zodiac = $zodiacArray[$yearOfBirth % 12];

                    if (($monthOfBirth == 4 && $dayOfBirth >= 19) || ($monthOfBirth == 5 && $dayOfBirth <= 13)) {
                        $constellation = "Aries";
                    } else if (($monthOfBirth == 5 && $dayOfBirth >= 14) || ($monthOfBirth == 6 && $dayOfBirth <= 19)) {
                        $constellation = "Taurus";
                    } else if (($monthOfBirth == 6 && $dayOfBirth >= 20) || ($monthOfBirth == 7 && $dayOfBirth <= 20)) {
                        $constellation = "Gemini";
                    } else if (($monthOfBirth == 7 && $dayOfBirth >= 21) || ($monthOfBirth == 8 && $dayOfBirth <= 9)) {
                        $constellation = "Cancer";
                    } else if (($monthOfBirth == 8 && $dayOfBirth >= 10) || ($monthOfBirth == 9 && $dayOfBirth <= 15)) {
                        $constellation = "Leo";
                    } else if (($monthOfBirth == 9 && $dayOfBirth >= 16) || ($monthOfBirth == 10 && $dayOfBirth <= 30)) {
                        $constellation = "Virgo";
                    } else if (($monthOfBirth == 10 && $dayOfBirth >= 31) || ($monthOfBirth == 11 && $dayOfBirth <= 22)) {
                        $constellation = "Libra";
                    } else if (($monthOfBirth == 11 && $dayOfBirth >= 23) || ($monthOfBirth == 11 && $dayOfBirth <= 29)) {
                        $constellation = "Scorpio";
                    } else if (($monthOfBirth == 11 && $dayOfBirth >= 30) || ($monthOfBirth == 12 && $dayOfBirth <= 17)) {
                        $constellation = "Ophiuchus";
                    } else if (($monthOfBirth == 12 && $dayOfBirth >= 18) || ($monthOfBirth == 1 && $dayOfBirth <= 18)) {
                        $constellation = "Sagittarius";
                    } else if (($monthOfBirth == 1 && $dayOfBirth >= 19) || ($monthOfBirth == 2 && $dayOfBirth <= 15)) {
                        $constellation = "Capricorn";
                    } else if (($monthOfBirth == 2 && $dayOfBirth >= 16) || ($monthOfBirth == 3 && $dayOfBirth <= 11)) {
                        $constellation = "Aquarius";
                    } else if (($monthOfBirth == 3 && $dayOfBirth >= 12) || ($monthOfBirth == 4 && $dayOfBirth <= 18)) {
                        $constellation = "Pisces";
                    }

                    $placeArray = ['01' => 'Johor', '02' => 'Kedah', '03' => 'Kelantan', '04' => 'Malacca', '05' => 'Negeri Sembilan', '06' => 'Pahang', '07' => 'Pulau Pinang', '08' => 'Perak', '09' => 'Perlis', '10' => 'Selangor', '11' => 'Terengganu', '12' => 'Sabah', '13' => 'Sarawak', '14' => 'Federal Territory of Kuala Lumpur', '15' => 'Federal Territory of Labuan', '16' => 'Federal Territory of Putrajaya', '21' => 'Johor', '22' => 'Johor', '23' => 'Johor', '24' => 'Johor', '25' => 'Kedah', '26' => 'Kedah', '27' => 'Kedah', '28' => 'Kelantan', '29' => 'Kelantan', '30' => 'Malacca', '31' => 'Negeri Sembilan', '32' => 'Pahang', '33' => 'Pahang', '34' => 'Pulau Pinang', '35' => 'Pulau Pinang', '36' => 'Perak', '37' => 'Perak', '38' => 'Perak', '39' => 'Perak', '40' => 'Perlis', '41' => 'Selangor', '42' => 'Selangor', '43' => 'Selangor', '44' => 'Selangor', '45' => 'Terengganu', '46' => 'Terengganu', '47' => 'Sabah', '48' => 'Sabah', '49' => 'Sabah', '50' => 'Sarawak', '51' => 'Sarawak', '52' => 'Sarawak', '53' => 'Sarawak', '54' => 'Federal Territory of Kuala Lumpur', '55' => 'Federal Territory of Kuala Lumpur', '56' => 'Federal Territory of Kuala Lumpur', '57' => 'Federal Territory of Kuala Lumpur', '58' => 'Federal Territory of Labuan', '59' => 'Negeri Sembilan'];
                    if (isset($placeArray[$placeOfBirth])) {
                        $place = $placeArray[$placeOfBirth];
                    } else {
                        $place = "notfound";
                    }

                    echo "<div class='alert alert-success role=alert'> Date of birth: " . $month[$monthOfBirth - 1] . " " . $dayOfBirth . ", " . $yearOfBirth . "<br>" . "</div>";

                    echo '<div class="row p-0 m-0">';
                    echo '<div class="col p-0 m-0 text-center">';
                    echo '<div class="alert alert-success" role="alert">' . "Your Chinese Zodiac: $zodiac." . '</div>';
                    echo '<img class="chinesezodiac" src="img/' . strtolower($zodiac) . '.png" alt="chinesezodiac img">';
                    echo '</div>';

                    echo '<div class="col p-0 m-0 text-center">';
                    echo '<div class="alert alert-success" role="alert">' . "Your constellation: $constellation." . '</div>';
                    echo '<img class="constellation" src="img/' . strtolower($constellation) . '.png" alt="constellation img">';
                    echo '</div>';

                    echo '<div class="col p-0 m-0 text-center">';
                    echo '<div class="alert alert-success" role="alert">' . "Your birthplace: $place." . '</div>';
                    echo '<img class="place" src="img/' . strtolower(str_replace(' ', '', $place)) . '.jpg" alt="place img">';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">' . "Invalid date of birth." . '</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">' . "Please enter a valid Malaysian ID that contains 12 digits." . '</div>';
            }
        }
        ?>
    </div>
</body>

</html>