<!DOCTYPE html>
<html>

<head>
    <title>Date Format</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .color {
            color: rgb(189, 134, 90);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="fs-1">
            <?php
            $date = date('M d, Y (l)');
            $Month = "<span class='color'>" . date('M') . "</span>";
            $Date = substr($date, 3);
            echo "<strong>$Month$Date</strong>";

            //24hour(H)/12hour(h)
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $currenttime = date('H:i:s');
            echo "<p>$currenttime</p>";
            ?>
        </div>
    </div>
</body>

</html>