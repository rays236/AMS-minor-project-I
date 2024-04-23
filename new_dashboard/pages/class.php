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
$re = "SELECT * FROM users WHERE id = '$id'";
$rr = $pdo -> query($re);
$ror = $rr -> fetch();
if ($ror['role'] == 'teacher'){
    $assignmenthandler = "    <form method='post' enctype='multipart/form-data'>
    <script src='https://cdn.ckeditor.com/4.22.1/basic/ckeditor.js'></script>

        <textarea name='editor1' id='editor1'></textarea>
                <script>
                        CKEDITOR.replace( 'editor1' );
                </script>
        <br>
        <input type = 'file' name = 'file' id='file'><br><br> 
        <input type='submit'>
</form>";
}
else {
    $assignmenthandler = ' ';
}

$qa = "SELECT * FROM $assign_tbl ORDER BY  assign_id DESC";
$ra = $pdo -> query($qa);
while($rowa = $ra ->fetch()){
    $assign = $rowa['content'];
    $assigned_on = $rowa['assigned_on'];
    $filename = $rowa['filenam'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $pictures = array('jpg', 'jpeg', 'png','gif');
    if ($ror['role'] == 'teacher'){
        if(in_array($extension, $pictures)){
            $assignmentlist .= "<div class = 'assign'>
            <div class='dropdown'>
            <button class='dropbtn'>&#8942;</button>
            <div class='dropdown-content'>
              <a href='#'>Option 1</a>
              <a href='#'>Option 2</a>
              <a href='#' id='deleteOption'>Delete</a> <!-- Added id='deleteOption' -->
            </div>
            </div><div class = 'assigned_on'>$assigned_on</div><br>$assign<div><a href='uploads/$filename' target = '_blank'><img src = 'uploads/$filename' width = '400px' height = 'auto'></a></div></div>";
        }
        elseif ($extension) {
            $assignmentlist .= "<div class = 'assign'>
            <div class='dropdown'>
            <button class='dropbtn'>&#8942;</button>
            <div class='dropdown-content'>
              <a href='#'>Option 1</a>
              <a href='#'>Option 2</a>
              <a href='#' id='deleteOption'>Delete</a> <!-- Added id='deleteOption' -->
            </div>
            </div><div class = 'assigned_on'>$assigned_on</div><br>$assign<div><a href = 'uploads/$filename' target = '_blank' ><i class='bx bx-file' ></i>$filename</a></div></div>";
        }
        else {
            $assignmentlist .= "<div class = 'assign'>
            <div class='dropdown'>
            <button class='dropbtn'>&#8942;</button>
            <div class='dropdown-content'>
              <a href='#'>Option 1</a>
              <a href='#'>Option 2</a>
              <a href='#' id='deleteOption'>Delete</a> <!-- Added id='deleteOption' -->
            </div>
            </div><div class = 'assigned_on'>$assigned_on</div><br>$assign</div>";
        }
    }
    else {
        if(in_array($extension, $pictures)){
            $assignmentlist .= "<div class = 'assign'><div class = 'assigned_on'>$assigned_on</div>>$assign<div><a href='uploads/$filename' target = '_blank'><img src = 'uploads/$filename' width = '400px' height = 'auto'></a></div></div>";
        }
        elseif ($extension) {
            $assignmentlist .= "<div class = 'assign'><div class = 'assigned_on'>$assigned_on</div>$assign<div><a href = 'uploads/$filename' target = '_blank' ><i class='bx bx-file' ></i>$filename</a></div></div>";
        }
        else {
            $assignmentlist .= "<div class = 'assign'><div class = 'assigned_on'>$assigned_on</div>$assign</div>";
        }
    }
     
}



// CREATE ASSIGNMENT FOR TEACHER AND VIEW ONLY FOR STUDENT if case
$test = '';
echo<<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    /* Style the dropdown button */
    .dropbtn {
        color: black;
        padding: 16px;
        font-size: 18px;
        border: none;
        cursor: pointer;
        background-color: transparent;
      }
      
      
      /* The container <div> - needed to position the dropdown content */
      .dropdown {
        position: relative;
        display: inline-block;
        float: right;
    
      }
      
      /* Dropdown Content (Hidden by Default) */
      .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
      }
      
      /* Links inside the dropdown */
      .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    
      }
      
      /* Change color of dropdown links on hover */
      .dropdown-content a:hover {
        background-color: #f1f1f1;
      }
      
      /* Show the dropdown menu on hover */
      .dropdown:hover .dropdown-content {
        display: block;
      }
      
    
      
aside {
  width: 20%;
  padding-left: 15px;
  margin-left: 15px;
  float: right;
  font-style: italic;
  background-color: lightgray;
}
.assigned_on{
    font-size: 0.75em;
}
.assign{
    margin: 10px 10px;
    background-color: lightgray;
    padding: 20px;
    border-radius: 10px;

}
.flex-container{
    width: 75%;
}
i{
    color:white;
    margin-left: 5px;

}
.navbar{
    top: 0;
    left: 0;
    height: 60px;
    width: 100%;
    position: fixed;
    background-color: #1d1b31;
    color: white;
    
}
.classname{
    margin-left: 20px;
    font-size: large;
    font-weight: bold;

}
.students{
    padding: 5px;
}
.assignmenthandler{
    margin-top: 70px;
}

</style>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>   
</head>
<body>
    
    <div class="navbar">
       <a href="/minorproject/new_dashboard/home.php"><i class='bx bx-arrow-back bx-md' ></i></a>
       <span class="classname">$classname $test</span>
    </div>
    <hr>
    <div class="assignmenthandler">
    $assignmenthandler
    </div>
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
$test = isset($_POST['file']);
if(isset($_POST['editor1'])  || !empty($_FILES["file"]["name"])){
    $content = $_POST['editor1'];
    $added_on = date('Y-m-d h:i:s');

    if(!empty($_FILES['file']['name'])){
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
        $filename = $_FILES["file"]["name"];
        $folder_path = $targetDir;

    }
    else {
        $targetDir = null;
        $targetFile = ' ';
        $filename = null;
        $folder_path = null;
    }
        //file name shouldn't contain quote(') sign in it

    $query = "INSERT INTO $assign_tbl(content, assigned_on, filenam, folder_path) VALUES ('$content','$added_on', '$filename','$folder_path')";
    $rs = $pdo -> query($query);
    if ($rs){
        echo "<script>window.location.reload()</script>";
    }
}
?>