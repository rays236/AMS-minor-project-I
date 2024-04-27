<?php
require_once 'connect.php';

try{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch(PDOException $e){
    throw new PDOException($e -> getMessage(), (int)$e->getCode());
}

$class_tbl = $_GET['class_tbl'];

$result = $pdo -> query("INSERT INTO archived_classes SELECT * FROM classes WHERE classcode = '$class_tbl'");
$del = $pdo -> query("DELETE FROM classes WHERE classcode = '$class_tbl'");
if($result){
    echo"
    <script>
    location.href='/minorproject/new_dashboard/home.php'
    </script>
    ";
}