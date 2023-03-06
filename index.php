<?php

error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

?>
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
    echo "https://" . $_SERVER['SERVER_NAME'] . "/" . $target_file;
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        $uploadFile = $imageKit->uploadFile([
            "file" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $target_file,
            "fileName" => "my_file_name.jpg"
        ]);
        $uploadOk = 1;
        unlink($target_file);
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Upload Image - URL
    // $uploadFile = $imageKit->uploadFile([
    //     "file" => $_FILES["fileToUpload"]["tmp_name"],
    //     "fileName" => "my_file_name.jpg"
    // ]);

    print_r(serialize($uploadFile));
    echo ('<br>');
    // echo ("Upload URL" . json_encode($uploadFile));
}
