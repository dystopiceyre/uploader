<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('/home/oringhis/uploadConfig.php');
try {
    $this->_db = new PDO(DB_UP_DSN, DB_UP_USERNAME, DB_UP_PASSWORD);
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
</html>