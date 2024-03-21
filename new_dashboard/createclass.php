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


$classname = $subject = $section= $assignment_id = $std_tbl_id = '';

session_start();
$id = htmlspecialchars($_SESSION['id']);

$classcode = "c" . rand(100,9999);
$assignment_id = "a" . rand(100,9999);
$std_tbl_id = 's'.rand(100,9999);
if (isset($_POST['input1']))
    $classname = fix_string($_POST['input1']);
if (isset($_POST['input2']))
    $subject = fix_string($_POST['input2']);
if (isset($_POST['input3']))
    $section = fix_string($_POST['input3']);

$insclass = "INSERT INTO classes" .  " VALUES ('$classcode' ,'$classname', '$subject', '$id', '$section','$assignment_id','$std_tbl_id')";
$result = $pdo -> query($insclass);

if ($result){
    $createstudenttbl = "CREATE TABLE $std_tbl_id (student_id varchar(10) NOT NULL, student_name varchar(64) NOT NULL)";
    $createassigntbl = "CREATE TABLE $assignment_id(assign_id varchar(10) NOT NULL, assign_topic varchar(128) NOT NULL)";

    $creation1 = $pdo -> query($createassigntbl);
    $creation2 = $pdo -> query($createstudenttbl);
}

function fix_string($string){
    $string = stripslashes($string);
    return htmlentities($string);
}

echo<<<_END
<script>
document.location.href = 'home.php';
</script>
_END;