<?php

// new 'image' field
if (!empty($_FILES["image"]["name"])) {   // if image is not empty, try to upload the image
    $image = sha1_file($_FILES["image"]["tmp_name"]) . "-" . basename($_FILES["image"]["name"]);
    $image = htmlspecialchars(strip_tags($image));

    // upload to file to folder
    $target_directory = "uploads/";
    $target_file = $target_directory . $image;
    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

    // error message is empty
    $file_upload_error_messages = "";

    // make sure that file is a real image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // submitted file is an image

        // validate for square size image
        $imageWidth = $check[0];  // width of the uploaded image
        $imageHeight = $check[1]; // height of the uploaded image

        if ($imageWidth !== $imageHeight) {
            $file_upload_error_messages .= "<div>Only square size images are allowed.</div>";
        }

        // Check maximum width and height
        if ($imageWidth > 600 || $imageHeight > 600) {
            $file_upload_error_messages .= "<div>Submitted images must not exceed the 600px width and 600px height limits.</div>";
        }
    } else {
        $file_upload_error_messages .= "<div>Submitted file is not an image.</div>";
    }

    // make sure certain file types are allowed
    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($file_type, $allowed_file_types)) {
        $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
    }

    // make sure file does not exist
    if (file_exists($target_file)) {
        $file_upload_error_messages = "<div>Image already exists. Try to change file name.</div>";
    }

    // make sure submitted file is not too large, can't be larger than 1 MB
    if ($_FILES['image']['size'] > (512000)) {
        $file_upload_error_messages .= "<div>Image must be less than 512 KB in size.</div>";
    }

    // make sure the 'uploads' folder exists
    // if not, create it
    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true);
    }

    // if $file_upload_error_messages is still empty
    if (empty($file_upload_error_messages)) {
        // it means there are no errors, so try to upload the file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // it means photo was uploaded
            //echo "Image successfully uploaded to: " . $target_file;
        } else {
            echo "<div class='alert alert-danger'>";
            echo "<div>Unable to upload photo.</div>";
            echo "<div>Update the record to upload photo.</div>";
            echo "</div>";
        }
    }

    // if $file_upload_error_messages is NOT empty
    else {
        // it means there are some errors, so show them to user
        echo "<div class='alert alert-danger'>";
        echo "<div>{$file_upload_error_messages}</div>";
        echo "<div>Update the record to upload photo.</div>";
        echo "</div>";
    }
} else {
    // if no image uploaded, use default image based on session
    if ($_SESSION['image'] == "product") {
        $image = "product_image_coming_soon.jpg";
    } else {
        $image = "user.png";
    }
}
