<!DOCTYPE html>
<html>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>

</body>

</html>
<?php

require_once __DIR__ . "/vendor/autoload.php";

use ImageKit\ImageKit;

$public_key = "public_w50/3waN1vN9TNAg1U1C/ahR6Ko=";
$your_private_key = "private_yMtf8/TQs6h+MVhMOSi+lyreJMU=";
$url_end_point = "https://" . $_SERVER['SERVER_NAME'] . "/imagekitio/";

$imageKit = new ImageKit(
    $public_key,
    $your_private_key,
    $url_end_point
);

if (isset($_POST["submit"])) {

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = $_FILES["fileToUpload"]["tmp_name"];
    if (!empty($check)) {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        $uploadFile = $imageKit->uploadFile([
            "file" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $target_file,
            "fileName" => "my_file_name.jpg"
        ]);
        $uploadOk = 1;
        unlink($target_file);
        // echo ("Upload URL" . json_encode($uploadFile));
        $jsonData = (array) $uploadFile;
        $status_ar = (array) $jsonData['responseMetadata'];
        $status_code =  $status_ar['statusCode'];
        if ($status_code  == 200) {
            echo "file uploaded to imagekit successfully";
        } else {
            echo "image upload failed";
        }
    } else {
        $uploadOk = 0;
    }
}
