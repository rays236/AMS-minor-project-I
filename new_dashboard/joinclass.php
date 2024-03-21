<?php

require_once 'connect.php';

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch(PDOException $e){
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

session_start();
$id = htmlspecialchars($_SESSION['id']);

$classcode ='';
$qc = "SELECT * FROM users WHERE id = '$id'";
$rs = $pdo ->query($qc);
if($rs){
    while($rw = $rs -> fetch()){
        $fname = $rw['fname'];
        $email = $rw['email'];
    }
}
else{
    echo "Error fetching data";
}


if (isset($_POST['classcode']))
    $classcode = fix_string($_POST['classcode']);

$fetcher = "SELECT * From classes WHERE classcode = '$classcode'";
$result = $pdo -> query($fetcher);
if ($result){
    while ($row = $result -> fetch()) {
        $student_tbl_name = $row['std_tbl_id'];
    
        $instbl = "INSERT INTO $student_tbl_name VALUES ('$id','$fname')";
        $result02 = $pdo -> query($instbl);
        echo "Successfully joined the class: " . $row['classname']; 
        echo<<<_END
        <script>
        document.location.href = 'home.php';
        </script>
        _END;
        
    }
}

function fix_string($string){
    $string = stripslashes($string);
    return htmlentities($string);
}