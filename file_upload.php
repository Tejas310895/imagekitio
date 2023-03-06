<!DOCTYPE html>
<html>
<?php echo $_SERVER['SERVER_NAME']; ?>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>

</body>

</html>

<?php
if (isset($_POST["submit"])) {

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = $_FILES["fileToUpload"]["tmp_name"];
    if (!empty($check)) {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        $uploadOk = 1;
        echo $target_file;
        // unlink($target_file);
    } else {
        $uploadOk = 0;
    }
}
?>