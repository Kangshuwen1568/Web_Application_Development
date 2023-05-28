<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exercise1</title>


    <style>
        .line1 {
            color: green;
            font-style: italic;
            font-weight: normal;
        }

        .line2 {
            color: blue;
            font-style: italic;
            font-weight: normal;
        }

        .line3 {
            color: red;
            font-weight: bold;
        }

        .line4 {
            font-style: italic;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    $number1 = rand(100, 200);
    $number2 = rand(100, 200);
    $total = $number1 + $number2;
    $multiple = $number1 * $number2;
    echo "<h1 class='line1'>line 1: $number1 </h1>";
    echo "<h1 class='line2'>line 2: $number2 </h1>";
    echo "<h1 class='line3'>line 3: $total </h1>";
    echo "<h1 class='line4'>line 4: $multiple </h1>";

    ?>
</body>

</html>