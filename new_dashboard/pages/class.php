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
$archive = "<div class='dropdown'>
<a href='/minorproject/new_dashboard/pages/archivee.php?class_tbl=$classcode' class='dropbtn confirmation' id = 'archive'><i class='bx bx-archive-in bx-md'></i></a>
</div>";
}
else {
    $assignmenthandler = ' ';
    $archive = '';
}

$qa = "SELECT * FROM $assign_tbl ORDER BY  assigned_on DESC";
$ra = $pdo -> query($qa);
while($rowa = $ra ->fetch()){
    $assign = $rowa['content'];
    $assigned_on = $rowa['assigned_on'];
    $filename = $rowa['filenam'];
    $assign_id = $rowa['assign_id'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $pictures = array('jpg', 'jpeg', 'png','gif');

    $tbl = $assign_tbl.$assign_id;
    
    if ($ror['role'] == 'teacher'){
        if(in_array($extension, $pictures)){
            $assignmentlist .= "
            <div class = 'assign'>
            <div class='dropdown'>
            <button class='dropbtn'>&#8942;</button>
            <div class='dropdown-content'>
            <a href='#' class = 'duckLink' data-name='$tbl' >Assignments</a>
              <a href='/minorproject/new_dashboard/pages/delete.php?assign_id=$assign_id&assign_tbl=$assign_tbl&class_tbl=$classcode' class = 'confirmation'>Delete</a>
            </div>
          </div>           
            <div class = 'assigned_on'>$assigned_on</div><br>$assign<div><a href='uploads/$filename' target = '_blank'><img src = 'uploads/$filename' width = '400px' height = 'auto'></a></div></div>
            ";
        }
        elseif ($extension) {
            $assignmentlist .= "<div class = 'assign'>
            <div class='dropdown'>
            <button class='dropbtn'>&#8942;</button>
            <div class='dropdown-content'>
            <a href='#' class = 'duckLink' data-name='$tbl' >Assignments</a>
              <a href='/minorproject/new_dashboard/pages/delete.php?assign_id=$assign_id&assign_tbl=$assign_tbl&class_tbl=$classcode' class = 'confirmation'>Delete</a>
            </div>
          </div>      
          <div class = 'assigned_on'>$assigned_on</div><br>$assign<div><a href = 'uploads/$filename' target = '_blank' ><i class='bx bx-file' ></i>$filename</a></div></div>";
        }
        else {
            $assignmentlist .= "<div class = 'assign'>
            <div class='dropdown'>
            <button class='dropbtn'>&#8942;</button>
            <div class='dropdown-content'>
              <a href='#' class = 'duckLink' data-name='$tbl'>Assignments</a>
              <a href='/minorproject/new_dashboard/pages/delete.php?assign_id=$assign_id&assign_tbl=$assign_tbl&class_tbl=$classcode' class = 'confirmation'>Delete</a>
            </div>
          </div>                   
            <div class = 'assigned_on'>$assigned_on</div><br>$assign</div>";
        }
    }
    else {
        $rem = $pdo -> query("SELECT * FROM $tbl WHERE student_id = '$id'");
        if($reem = $rem -> fetch()){
          $comment0 = $reem['filenamm'];
          $comment1 = $reem['remark'];
        }
        else {
          $comment0 = 'Assignment yet to be submitted';
          $comment1 = 'N/A ';
        }
        if(in_array($extension, $pictures)){
            $assignmentlist .= "<div class = 'assign'>
            <div class='dropdown'>
            <button class='dropbtn'>&#8942;</button>
            <div class='dropdown-content'>
              <a href='#' class = 'productLink' data-name ='$tbl' >Submit Assignment</a>
            </div>
          </div> 
            <div class = 'assigned_on'>$assigned_on</div>$assign<div><a href='uploads/$filename' target = '_blank'><img src = 'uploads/$filename' width = '400px' height = 'auto'></a></div><br><hr><div>ASSIGNMENT : <a href = 'assignmentuploads/$comment0'>$comment0</a> | Remark : $comment1</div></div>";
        }
        elseif ($extension) {
            $assignmentlist .= "<div class = 'assign'>
            <div class='dropdown'>
            <button class='dropbtn'>&#8942;</button>
            <div class='dropdown-content'>
              <a href='#' class = 'productLink' data-name ='$tbl'>Submit Assignment</a>
            </div>
          </div> 
            <div class = 'assigned_on'>$assigned_on</div>$assign<div><a href = 'uploads/$filename' target = '_blank' ><i class='bx bx-file' ></i>$filename</a></div><br><hr><div>ASSIGNMENT : <a href = 'assignmentuploads/$comment0'>$comment0</a> | Remark : $comment1</div></div>";
        }
        else {
            $assignmentlist .= "<div class = 'assign'>
            <div class='dropdown'>
            <button class='dropbtn'>&#8942;</button>
            <div class='dropdown-content'>
              <a href='#' class = 'productLink' data-name ='$tbl'>Submit Assignment</a>
            </div>
          </div> 
          <div class = 'assigned_on'>$assigned_on</div>$assign<hr><div>ASSIGNMENT : <a href = 'assignmentuploads/$comment0'>$comment0</a> | Remark : $comment1</div></div>";
        }
    }
     
}
$assignsubmission =  '';
$count = 0;
if(isset($_POST['jsVariable'])){
  $ttble_name = $_POST['jsVariable'];
  $gh = $pdo -> query("SELECT * FROM $ttble_name");
  while ($rgh = $gh-> fetch()){
    $sstd_id =$rgh['student_id'] ;

    $filenamm =$rgh['filenamm'] ;
    $hh = $rgh['remark'];
    $student_name = $pdo->query("SELECT * FROM users WHERE id = '$sstd_id'");
    $res = $student_name -> fetch();
    $std_name = $res['fname'];

    $name = 'name'.$count;

    $remark = 'remark'.$count;

    $count += 1;
    $assignsubmission .= "<tr> <th scope = 'row'>$sstd_id </th><td>$std_name</td><td><a href='assignmentuploads/$filenamm'>$filenamm</a></td><td><input type = 'hidden' name = '$name' value = '$sstd_id'><input type='text' name = '$remark'><input type = 'hidden' name = 'table_name' value = '$ttble_name'></td><td>$hh</td></tr>";
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
    .dropbtn {
        background-color: transparent;
        color: black;
        padding: 16px;
        font-size: 16px;
        border: none;
      }
      
      .dropdown {
        position: relative;
        display: inline-block;
        float: right;
        margin: 10px;
      }
      
      .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
      }
      
      .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
      }
      
      .dropdown-content a:hover {background-color: #ddd;}
      
      .dropdown:hover .dropdown-content {display: block;}
      
    
      
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
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
  }

  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }
  .newmodal {
    display: block;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
  }

  .newmodal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  .cclose {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .cclose:hover,
  .cclose:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  table {
    border-collapse: collapse;
    border: 2px solid rgb(140 140 140);
    font-family: sans-serif;
    font-size: 0.8rem;
    letter-spacing: 1px;
  }
  
  caption {
    caption-side: bottom;
    padding: 10px;
    font-weight: bold;
  }
  
  thead,
  tfoot {
    background-color: rgb(228 240 245);
  }
  
  th,
  td {
    border: 1px solid rgb(160 160 160);
    padding: 8px 10px;
  }
  
  td:last-of-type {
    text-align: center;
  }
  
  tbody > tr:nth-of-type(even) {
    background-color: rgb(237 238 242);
  }
  
  tfoot th {
    text-align: right;
  }
  
  tfoot td {
    font-weight: bold;
  }
</style>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>   
</head>
<body>
    
    <div class="navbar">
       <a href="/minorproject/new_dashboard/home.php"><i class='bx bx-arrow-back bx-md' ></i></a>
       <span class="classname">$classname $test</span>
       $archive
    </div>
    <hr>
    <div class="assignmenthandler">
    $assignmenthandler 
    </div>
    <hr>

    <form id="myForm" method="POST" style="display: none;">
        <input type="hidden" id="hiddenInput" name="jsVariable">
    </form>


    <div id= 'mynewModal' class = 'newmodal'>
      <div class = 'newmodal-content'>
        <span class = 'cclose'>&times;</span>
        <form action = 'grading.php' method = 'post'>
        <input type = 'hidden' name = 'classcode' value = '$classcode'>
        
        <input type = 'hidden' name = 'count' value = '$count'>
        <table>
        <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Student Name</th>
           <th scope="col">Submission</th>
           <th scope="col">Remark</th>
           <th scope="col"> Given remark</th>
        </tr>
        </thead>
        <tbody>
        $assignsubmission
        <tr ><td colspan = '4'><input type = 'submit'></td></tr>
        </tbody></table>
        </form>
      </div>
    </div>

    <div id = 'myModal' class = 'modal'>
        <div class = 'modal-content'>
            <span class = 'close'>&times;</span>

            <form action = "assignsubmit.php" method = 'post' enctype = 'multipart/form-data'>
                <input type = 'hidden' name = 'tbl_name' id='tbl_name'>
                <input type = 'hidden' name = 'classcode' value = '$classcode'>
                <input type = 'file' name = 'file'>
                <input type = 'submit'>
            </form>

        </div>
    </div>


    <br>
    <aside>
        <h3>Students</h3>
        <hr>
        $studentslist
        
    </aside>
    <div class="flex-container">
        $assignmentlist
        </div>
<script src = 'ascript.js'></script>
</body>
</html>
_END;
if(!empty($_POST['editor1'])  || !empty($_FILES["file"]["name"])){
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
    $aid = 'aid' . rand(10,1000);
    $query = "INSERT INTO $assign_tbl(assign_id, content, assigned_on, filenam, folder_path) VALUES ('$aid','$content','$added_on', '$filename','$folder_path')";
    $rs = $pdo -> query($query);
    if ($rs){

        $newtable = $assign_tbl.$aid;
        $ssq = "CREATE TABLE $newtable(student_id varchar(11), filenamm LONGTEXT, remark varchar(128))";
        $rrq = $pdo -> query($ssq);

        echo "<script>window.location.reload()</script>";
    }
}

if(isset($_POST['assign_id'])){
    $assign_id = $_POST['assign_id'];
    $row = $pdo -> query("DELETE FROM $assign_tbl WHERE assign_id = '$assign_id' ");
}


?>