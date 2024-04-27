<?php
require_once 'connect.php';

try{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch(PDOException $e){
    throw new PDOException($e -> getMessage(), (int)$e->getCode());
}

$assign_id = $_GET['assign_id'];
$assign_tbl = $_GET['assign_tbl'];
$class_tbl = $_GET['class_tbl'];

$result = $pdo -> query("DELETE FROM $assign_tbl WHERE assign_id = $assign_id");
if($result){
    echo"
    <script>
    location.href='/minorproject/new_dashboard/pages/class.php?i=$class_tbl'
    </script>
    ";
}

