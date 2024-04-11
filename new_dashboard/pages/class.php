<?php

require_once 'connect.php';
try{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch(PDOException $e){
    throw new PDOException($e -> getMessage(), (int)$e->getCode());
}

ini_set("display_errors","1");
ini_set("display_startup_errors","1");
error_reporting(E_ALL);

session_start();
$id = $_SESSION['id'];

if(isset($_GET['i'])){
    $classcode = $_GET['i'];
}

$studentslist = $assignmentlist =' ';

$q = "SELECT * FROM classes WHERE classcode = '$classcode'";
$r = $pdo->query($q);
$result = $r -> fetch();
$assign_tbl = $result['assignment_id'];
$student_tbl = $result['std_tbl_id'];
$classname = $result['classname'];

$qs = "SELECT * FROM $student_tbl";
$rs = $pdo -> query($qs);
while($rows = $rs -> fetch()){
    $std = $rows['student_name'];
    $studentslist .="<div class='students'> $std</div>";

}

$qa = "SELECT * FROM $assign_tbl";
$ra = $pdo -> query($qa);
while($rowa = $ra ->fetch()){
    $assign = $rowa['assign_topic'];
    $assignmentlist .= "<div class = 'assign'>$assign</div>";
}

// CREATE ASSIGNMENT FOR TEACHER AND VIEW ONLY FOR STUDENT if case

echo<<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
aside {
  width: 20%;
  padding-left: 15px;
  margin-left: 15px;
  float: right;
  font-style: italic;
  background-color: lightgray;
}
.assign{
    margin-right: 30px;
    background-color: lightgray;
    padding: 20px;
    border-radius: 10px;

}
.flex-container{
    width: 75%;
}
.navbar{
    height: 40px;
}
.classname{
    margin-left: 20px;
    font-size: large;
    font-weight: bold;
}
.students{
    padding: 5px;
}
</style>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
    <div class="navbar">
       <a href="/minorproject/new_dashboard/home.php"><i class='bx bx-left-arrow bx-md'></i></a>
       <span class="classname">$classname</span>
    </div>
    <hr>
    <aside>
        <h3>Students</h3>
        <hr>
        $studentslist
        
    </aside>
    <div class="flex-container">
        $assignmentlist
        </div>

</body>
</html>
_END;