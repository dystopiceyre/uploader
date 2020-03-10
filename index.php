<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('/home/oringhis/uploadConfig.php');
try {
    $db = new PDO(DB_UP_DSN, DB_UP_USERNAME, DB_UP_PASSWORD);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$dir = "uploads/";
?>
<html>
<h1>File Uploader</h1>
<h3>Select a file to upload</h3>
<h5>Valid types include .jpg and .gif</h5>
<form action="#" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
</form>
<?php

//if a file has been submitted
if (isset($_FILES['fileToUpload'])) {
    $file = $_FILES['fileToUpload'];
    //move file to upload directory
    move_uploaded_file($file['tmp_name'], $dir.$file['name']);
    echo "<p class='success'>Uploaded {$file['name']} successfully!";
    //store the file name into the database
    $sql = "INSERT INTO uploads(filename) VALUES ('{$file['name']}')";
    $db->exec($sql);
}
?>
</html>