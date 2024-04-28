<?php


require_once 'connect.php';
try{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch(PDOException $e){
    throw new PDOException($e -> getMessage(), (int)$e->getCode());
}


session_start();
$id = $_SESSION['id'];


$tbl = ' ';
if(!empty($_FILES['file']['name'])){
    $targetdirectory = "assignmentuploads/";
    $targetfilee = $targetdirectory . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES['file']['tmp_name'], $targetfilee);
    $filenamee = $_FILES['file']['name'];
    $tbl = $_POST['tbl_name'];
    $classcode = $_POST['classcode'];
    $refile = $pdo -> query("INSERT INTO $tbl VALUES ('$id','$filenamee')");
    if($refile){
        echo "<script> 
        location.href = '/minorproject/new_dashboard/pages/class.php?i=$classcode';  
        </script>";
    }
}