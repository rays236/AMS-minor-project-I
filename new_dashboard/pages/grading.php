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

$count = $_POST['count'];
// $student_id = $_POST['student_id'];
// $remark = $_POST['remark'];
$table_name = $_POST['table_name'];

$x = 0;

 while($x < $count ){
    $name = 'name'.$x;
    $std_id = $_POST[$name];

    $remark = 'remark'.$x;
    $rm = $_POST[$remark];

    $result = $pdo -> query("UPDATE $table_name SET remark = '$rm' WHERE student_id = '$std_id' ");
    $x +=1;
 }
 

    echo"
    <script>
     location.href='/minorproject/new_dashboard/pages/class.php?i=$classcode'
    </script>
    ";