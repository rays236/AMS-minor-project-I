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
$email = $_SESSION['email'];
$hw = '';


$stmt = "SELECT * FROM users WHERE email = '$email'";
$tmt = $pdo -> query($stmt);
$row = $tmt ->fetch();
$role = $row['role'];
if ($role == 'student'){
    $sql = "SELECT * FROM classes";
$result = $pdo -> query($sql);
while($row = $result -> fetch()){

    $std_tbl = $row['std_tbl_id'];
    $assign_tbl = $row['assignment_id'];
    $classname = $row['classname'];
    $ssql = "SELECT * FROM $std_tbl";
    $rresult = $pdo -> query($ssql);

    while($rrow = $rresult -> fetch()){
        $sid = $rrow['student_id'];
        if($id == $sid){

            $xsql = "SELECT * FROM $assign_tbl ORDER BY assigned_on DESC";
            $xresult = $pdo -> query($xsql);
            while ($xrow = $xresult -> fetch()){

                $assign = $xrow['content'];
                $assigned_on = $xrow['assigned_on'];
                $filename = $xrow['filenam'];
                $assign_id = $xrow['assign_id'];
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                 $pictures = array('jpg', 'jpeg', 'png','gif');

                 if(in_array($extension, $pictures)){
                    $hw .= "
                    <div class = 'assign'>        
                    <div class = 'assigned_on'>$assigned_on</div><br>$assign<div><a href='minorproject/new_dashboard/pages/uploads/$filename' target = '_blank'><img src = 'new_dashboard/pages/uploads/$filename' width = '400px' height = 'auto'></a></div></div>
                    ";
                }
                elseif ($extension) {
                    $hw .= "<div class = 'assign'>     
                  <div class = 'assigned_on'>$assigned_on</div><br>$assign<div><a href = 'minorproject/new_dashboard/pages/uploads/$filename' target = '_blank' ><i class='bx bx-file' ></i>$filename</a></div></div>";
                }
                else {
                    $hw .= "<div class = 'assign'>               
                    <div class = 'assigned_on'>$assigned_on</div><br>$assign</div>";
                }
            }
            

        }
    }
}
} else {
    $sql = "SELECT * FROM classes WHERE teacher = '$id'";
    $result = $pdo -> query($sql);
    while($row = $result -> fetch()){
        $assign_tbl = $row['assignment_id'];
        $xsql = "SELECT * FROM $assign_tbl ORDER BY assigned_on DESC";
            $xresult = $pdo -> query($xsql);
            while ($xrow = $xresult -> fetch()){

                $assign = $xrow['content'];
                $assigned_on = $xrow['assigned_on'];
                $filename = $xrow['filenam'];
                $assign_id = $xrow['assign_id'];
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                 $pictures = array('jpg', 'jpeg', 'png','gif');

                 if(in_array($extension, $pictures)){
                    $hw .= "
                    <div class = 'assign'>        
                    <div class = 'assigned_on'>$assigned_on</div><br>$assign<div><a href='new_dashboard/pages/uploads/$filename' target = '_blank'><img src = 'uploads/$filename' width = '400px' height = 'auto'></a></div></div>
                    ";
                }
                elseif ($extension) {
                    $hw .= "<div class = 'assign'>     
                  <div class = 'assigned_on'>$assigned_on</div><br>$assign<div><a href = 'new_dashboard/pages/ploads/$filename' target = '_blank' ><i class='bx bx-file' ></i>$filename</a></div></div>";
                }
                else {
                    $hw .= "<div class = 'assign'>               
                    <div class = 'assigned_on'>$assigned_on</div><br>$assign</div>";
                }
            }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .assigned_on{
    font-size: 0.75em;
}
.assign{
    margin: 20px 20px;
    background-color: lightgray;
    padding: 40px;
    border-radius: 10px;

}

.container {
    width: 75%;
    margin-left: 20px;
}
    </style>
</head>
<body>
<div class="container">
        <?php echo $hw ?>
        </div>
</body>
</html>