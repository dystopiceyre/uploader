<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('/home/oringhis/uploadConfig.php');
try {
    $db = new PDO(DB_UP_DSN, DB_UP_USERNAME, DB_UP_PASSWORD);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$dirName = "uploads/";
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>File Uploader</title>
</head>
<body>
<div class="container">
    <h1>File Uploader</h1>
    <h3>Select a file to upload</h3>
    <h5>Valid types include .jpg and .gif</h5>
    <form action="#" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>
</div>
</body>
<?php

    //if a file has been submitted
    if (isset($_FILES['fileToUpload'])) {
        $file = $_FILES['fileToUpload'];
        //define valid file types
        $validTypes = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');
        //ensures file is w/in size constraint
        if ($_SERVER['CONTENT_LENGTH'] > 3000000) {
            echo "<p class='error'>File is too large. Maximum file size is 3MB.</p>";
        } //check file type
        else if (in_array($file['type'], $validTypes)) {
            if ($file['error'] > 0) {
                echo "<p class='error'>Return Code: {$file['error']}</p>";
            }
            //check for duplicate
            if (file_exists($dirName . $file['name'])) {
                echo "<p class='error'>Error uploading: ";
                echo $file['name'] . " already exists.</p>";
            } else {
                //move file to upload directory
                move_uploaded_file($file['tmp_name'], $dirName . $file['name']);
                echo "<p class='success'>Uploaded {$file['name']} successfully!";
                //store the file name into the database
                $sql = "INSERT INTO uploads(filename) VALUES ('{$file['name']}')";
                $db->exec($sql);
            }
        } //Invalid type
        else {
            echo "<p class='error'>Invalid file type. Allowed types: gif, png, jpg</p>";
        }
    }

    //show images

    //open directory
    $dir = opendir($dirName);
    //get file names
    $sql = "SELECT * FROM uploads";
    $result = $db->query($sql);
    //display images
    if (sizeof($result) >= 1) {
        foreach ($result as $row) {
            $img = $row['filename'];
            echo "<img src='$dirName$img' alt=''>";
        }
    }
?>
</html>