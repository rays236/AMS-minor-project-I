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

$classcode = $_POST['classcode'];
$student_id = $_POST['student_id'];
$remark = $_POST['remark'];
$table_name = $_POST['table_name'];
$sql = "INSERT INTO $table_name (remark) VALUES $remark WHERE student_id = '$student_id ";
$result = $pdo -> query($sql);
if($result){
    echo"
    <script>
    location.href='/minorproject/new_dashboard/pages/class.php?i=$classcode'>'
    </script>
    ";
}