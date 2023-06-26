<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>IC Form</h1>

        <form method="post" action="">
            <div class="mb-3">
                <label for="ic">IC Number:</label>
                <input type="text" id="ic" name="ic" placeholder="xxxxxx-xx-xxxx" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $ic = $_POST['ic'];
            //^: It denotes the start of the string.
            //[0-9]: It matches any digit.
            //{6}: It specifies that the previous pattern (digit) should occur exactly 6 times.
            //-: It matches a hyphen character.
            //{2}: It specifies that the previous pattern (digit) should occur exactly 2 times.
            //-: It matches a hyphen character.
            //{4}: It specifies that the previous pattern (digit) should occur exactly 4 times.
            //$: It denotes the end of the string.
            $ICPattern = "/^[0-9]{6}-[0-9]{2}-[0-9]{4}$/";
            $month = array(
                "JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE",
                "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"
            );

            if (!empty($ic) && preg_match($ICPattern, $ic)) {
                $dayObrith = substr($ic, 4, 2);
                $monthObirth = substr($ic, 2, 2);
                $yearObirth = substr($ic, 0, 2);
                //
                if (($yearObirth + 2000) > date('Y')) {
                    //年份是99=2099，大过currentyear，改成1900年+99=1999年
                    $yearObirth += 1900;
                } else {
                    //(年份是01+2000=2001)小过currentyear，改成2000年+01=2001
                    $yearObirth += 2000;
                }

                // Validate date of birth
                if (checkdate($monthObirth, $dayObrith, $yearObirth)) {
                    $zodiac = "";
                    $zodiacImage = "";

                    if ($yearObirth % 12 === 0) {
                        $zodiac = "Monkey";
                        $zodiacImage = "img/monkey.png";
                    } else if ($yearObirth % 12 === 1) {
                        $zodiac = "Rooster";
                        $zodiacImage = "img/rooster.png";
                    } else if ($yearObirth % 12 === 2) {
                        $zodiac = "Dog";
                    } else if ($yearObirth % 12 === 3) {
                        $zodiac = "Pig";
                        $zodiacImage = "img/pig.png";
                    } else if ($yearObirth % 12 === 4) {
                        $zodiac = "Rat";
                        $zodiacImage = "img/rat.png";
                    } else if ($yearObirth % 12 === 5) {
                        $zodiac = "Cow";
                        $zodiacImage = "img/cow.png";
                    } else if ($yearObirth % 12 === 6) {
                        $zodiac = "Tiger";
                        $zodiacImage = "img/tiger.png";
                    } else if ($yearObirth % 12 === 7) {
                        $zodiac = "Rabbit";
                        $zodiacImage = "img/rabbit.png";
                    } else if ($yearObirth % 12 === 8) {    //2000year除12 余数8
                        $zodiac = "Dragon";
                        $zodiacImage = "img/dragon.png";
                    } else if ($yearObirth % 12 === 9) {
                        $zodiac = "Snake";
                        $zodiacImage = "img/snake.png";
                    } else if ($yearObirth % 12 === 10) {
                        $zodiac = "Horse";
                        $zodiacImage = "img/horse.png";
                    } else if ($yearObirth % 12 === 11) {
                        $zodiac = "Goat";
                        $zodiacImage = "img/goat.png";
                    }

                    $constellation = "";
                    $constellationImage = "";

                    if (($monthObirth == 1 && $dayObrith >= 20) || ($monthObirth == 2 && $dayObrith <= 18)) {
                        $constellation = "Aquarius";
                        $constellationImage = "img/aquarius.png";
                    } else if (($monthObirth == 2 && $dayObrith >= 19) || ($monthObirth == 3 && $dayObrith <= 20)) {
                        $constellation = "Pisces";
                        $constellationImage = "img/pisces.png";
                    } else if (($monthObirth == 3 && $dayObrith >= 21) || ($monthObirth == 4 && $dayObrith <= 19)) {
                        $constellation = "Aries";
                        $constellationImage = "img/aries.png";
                    } else if (($monthObirth == 4 && $dayObrith >= 20) || ($monthObirth == 5 && $dayObrith <= 20)) {
                        $constellation = "Taurus";
                        $constellationImage = "img/taurus.png";
                    } else if (($monthObirth == 5 && $dayObrith >= 21) || ($monthObirth == 6 && $dayObrith <= 20)) {
                        $constellation = "Gemini";
                        $constellationImage = "img/gemini.png";
                    } else if (($monthObirth == 6 && $dayObrith >= 21) || ($monthObirth == 7 && $dayObrith <= 22)) {
                        $constellation = "Cancer";
                        $constellationImage = "img/cancer.png";
                    } else if (($monthObirth == 7 && $dayObrith >= 23) || ($monthObirth == 8 && $dayObrith <= 22)) {
                        $constellation = "Leo";
                        $constellationImage = "img/leo.png";
                    } else if (($monthObirth == 8 && $dayObrith >= 23) || ($monthObirth == 9 && $dayObrith <= 22)) {
                        $constellation = "Virgo";
                        $constellationImage = "img/virgo.png";
                    } else if (($monthObirth == 9 && $dayObrith >= 23) || ($monthObirth == 10 && $dayObrith <= 22)) {
                        $constellation = "Libra";
                        $constellationImage = "img/libra.png";
                    } else if (($monthObirth == 10 && $dayObrith >= 23) || ($monthObirth == 11 && $dayObrith <= 21)) {
                        $constellation = "Scorpio";
                        $constellationImage = "img/scorpio.png";
                    } else if (($monthObirth == 11 && $dayObrith >= 22) || ($monthObirth == 12 && $dayObrith <= 21)) {
                        $constellation = "Sagittarius";
                        $constellationImage = "img/sagittarius.png";
                    } else if (($monthObirth == 12 && $dayObrith >= 22) || ($monthObirth == 1 && $dayObrith <= 19)) {
                        $constellation = "Capricorn";
                        $constellationImage = "img/capricorn.png";
                    }

                    $placeOfBirth = substr($ic, 7, -5); //ic从0算起第7个，-5从后面算起
                    if ($placeOfBirth === "01" || $placeOfBirth === "21"  || $placeOfBirth === "22"  || $placeOfBirth === "23" || $placeOfBirth === "24") {
                        $placeName = "Johor";
                        $placeFlag = "img/johor.jpg";
                    } else if ($placeOfBirth === "02" || $placeOfBirth === "25" || $placeOfBirth === "26" || $placeOfBirth === "27") {
                        $placeName = "Kedah";
                        $placeFlag = "img/kedah.jpg";
                    } else if ($placeOfBirth === "03" || $placeOfBirth === "28" || $placeOfBirth === "29") {
                        $placeName = "Kelantan";
                        $placeFlag = "img/kelantan.jpg";
                    } else if ($placeOfBirth === "04" || $placeOfBirth === "30") {
                        $placeName = "Malacca";
                        $placeFlag = "img/malacca.jpg";
                    } else if ($placeOfBirth === "05" || $placeOfBirth === "31" || $placeOfBirth === "59") {
                        $placeName = "Negeri Sembilan";
                        $placeFlag = "img/sembilan.jpg";
                    } else if ($placeOfBirth === "06" || $placeOfBirth === "32" || $placeOfBirth === "33") {
                        $placeName = "Pahang";
                        $placeFlag = "img/pahang.jpg";
                    } else if ($placeOfBirth === "07" || $placeOfBirth === "34" || $placeOfBirth === "35") {
                        $placeName = "Penang";
                        $placeFlag = "img/penang.jpg";
                    } else if ($placeOfBirth === "08" || $placeOfBirth === "36" || $placeOfBirth === "37" || $placeOfBirth === "38" || $placeOfBirth === "39") {
                        $placeName = "Perak";
                        $placeFlag = "img/perak.jpg";
                    } else if ($placeOfBirth === "09" || $placeOfBirth === "40") {
                        $placeName = "Perlis";
                        $placeFlag = "img/perlis.jpg";
                    } else if ($placeOfBirth === "10" || $placeOfBirth === "41" || $placeOfBirth === "42" || $placeOfBirth === "43" || $placeOfBirth === "44") {
                        $placeName = "Sabah";
                        $placeFlag = "img/sabah.jpg";
                    } else if ($placeOfBirth === "11" || $placeOfBirth === "45" || $placeOfBirth === "46") {
                        $placeName = "Sarawak";
                        $placeFlag = "img/sarawak.jpg";
                    } else if ($placeOfBirth === "12" || $placeOfBirth === "47" || $placeOfBirth === "48" || $placeOfBirth === "49") {
                        $placeName = "Selangor";
                        $placeFlag = "img/selangor.jpg";
                    } else if ($placeOfBirth === "13" || $placeOfBirth === "50" || $placeOfBirth === "51" || $placeOfBirth === "52" || $placeOfBirth === "53") {
                        $placeName = "Terengganu";
                        $placeFlag = "img/terengganu.jpg";
                    } else if ($placeOfBirth === "14" || $placeOfBirth === "54" || $placeOfBirth === "55" || $placeOfBirth === "56" || $placeOfBirth === "57") {
                        $placeName = "Kuala Lumpur";
                        $placeFlag = "img/kl.jpg";
                    } else if ($placeOfBirth === "15" || $placeOfBirth === "58") {
                        $placeName = "Labuan";
                        $placeFlag = "img/labuan.jpg";
                    } else if ($placeOfBirth === "16") {
                        $placeName = "Putrajaya";
                        $placeFlag = "img/putrajaya.jpg";
                    } else {
                        $placeName = "Not Found";
                    }

                    echo "<p>Your ic number is: $ic</p>";
                    echo "Date of Birth: $dayObrith {$month[$monthObirth - 1]} $yearObirth<br>";
                    echo "Zodiac Sign: $zodiac <img src='img/" . strtolower($zodiac) . ".png' alt='$zodiac'><br>";
                    echo "Constellation: $constellation <img src='img/" . strtolower($constellation) . ".png' alt='$constellation'><br>";
                    echo "Place of Birth: $placeName <img src='$placeFlag' alt='$placeName'>";
                } else {
                    echo "<p class='text-danger mt-3'>Invalid date of birth.</p>";
                }
            } else {
                echo '<p>Invalid IC number. </p>';
            }
        }
        ?>
    </div>

</body>

</html>