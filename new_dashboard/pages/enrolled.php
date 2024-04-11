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

$card = '';

if(isset($_SESSION['id'])){
  $id = htmlspecialchars($_SESSION['id']);

  $query = "SELECT * FROM users WHERE id = '$id'";
  $result = $pdo -> query($query);
  $row = $result->fetch();

  $role = $row['role'];

  if($role == 'teacher'){
    $qt = "SELECT * FROM classes WHERE teacher = '$id'";
    $rt = $pdo -> query($qt);
    while($rows = $rt ->fetch()){
      $classname = $rows['classname'];
      $classcode = $rows['classcode'];
      $section = $rows['section'];
      $subject = $rows['subject'];

      $card .=   "<div class='card'>
<div class='card-img'></div>
<div class='card-info'>
  <p class='text-title'>$classname </p>
  <p class='text-body'>$subject</p>
</div>
<div class='card-footer'>
<span class='text-title'>$classcode</span>
<div class='card-button'>
<i class='bx bxs-arrow-to-right'></i>
</div>
</div></div>";
    }
  }
  else {
    $sq = "SELECT * FROM classes";
    $sr = $pdo->query($sq);

    while($ross = $sr ->fetch()){
      $tbl_name = $ross['std_tbl_id'];
      $ssq = "SELECT student_id FROM $tbl_name";
      $ssr = $pdo ->query($ssq);

      $classname = $ross['classname'];
      $classcode = $ross['classcode'];
      $section = $ross['section'];
      $subject = $ross['subject'];

      while($rowss =$ssr ->fetch()){
        if($id == $rowss['student_id']){

          $card .=   "<div class='card'>
<div class='card-img'></div>
<div class='card-info'>
  <p class='text-title'>$classname </p>
  <p class='text-body'>$subject</p>
</div>
<div class='card-footer'>
<span class='text-title'>$classcode</span>
<div class='card-button'>
<i class='bx bxs-arrow-to-right'></i>
</div>
</div></div>";
        }
      }


    }
  }
}


echo<<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .card {
 width: 190px;
 height: 254px;
 padding: .8em;
 background: #f5f5f5;
 position: relative;
 overflow: visible;
 box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.card-img {
 background-color: #ffcaa6;
 height: 40%;
 width: 100%;
 border-radius: .5rem;
 transition: .3s ease;
}

.card-info {
 padding-top: 10%;
}

svg {
 width: 20px;
 height: 20px;
}

.card-footer {
 width: 100%;
 display: flex;
 justify-content: space-between;
 align-items: center;
 padding-top: 10px;
 border-top: 1px solid #ddd;
}

/*Text*/
.text-title {
 font-weight: 900;
 font-size: 1.2em;
 line-height: 1.5;
}

.text-body {
 font-size: .9em;
 padding-bottom: 10px;
}

/*Button*/
.card-button {
 border: 1px solid #252525;
 display: flex;
 padding: .3em;
 cursor: pointer;
 border-radius: 50px;
 transition: .3s ease-in-out;
}

/*Hover*/
.card-img:hover {
 transform: translateY(-25%);
 box-shadow: rgba(226, 196, 63, 0.25) 0px 13px 47px -5px, rgba(180, 71, 71, 0.3) 0px 8px 16px -8px;
}

.card-button:hover {
 border: 1px solid #ffcaa6;
 background-color: #ffcaa6;
}

    </style>
</head>
<body>
    $card
</body>
</html>
_END;
