<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" enctype='multipart/form-data'>
    <input type='submit'>
    <input type="file" name="file" id="file">
    </form>
</body>
</html>

<?php
require_once 'connect.php';

if(isset($_POST['file'])){

    if($_POST['file' != null]){
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    }
    else {
        $targetDir = null;
        $targetFile = null;
    }
    

    $content = $_POST['editor1'];
    $added_on = date('Y-m-d h:i:s');

    if ($content!=null || move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)){
        if($_POST['file' != null]){
            $filename = $_FILES["file"]["name"];
            $folder_path = $targetDir;
        }
        else{
            $filename = null;
            $folder_path = null;
        }

        $query = "INSERT INTO $assign_tbl(content, assigned_on, filenam, folder_path) VALUES ('$content','$added_on', '$filename','$folder_path')";
        $rs = $pdo -> query($query);
        if($result){
            header("Refresh:0");
        }
    }
}