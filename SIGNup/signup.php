<?php
require_once 'connect.php';

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch (PDOException $e){
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_POST['fname']))
    $fn = fix_string($_POST['fname']);
if (isset($_POST['password']))
    $password = fix_string($_POST['password']);
    $hash = password_hash($password, PASSWORD_DEFAULT);
if (isset($_POST['email']))
    $email =$_POST['email'];
if (isset($_POST['role']))
    $role = $_POST['role'];

$fail = validate_fname($fn);
$fail .= validate_password($password);

if ($fail == "") {
    if ($role == "student"){
        $id = rand(1,99) . "sstd";
        add_user($pdo, $id, $fn, $hash, $email, $role);
        echo<<<_END
        <script>
        document.location.href = 'login.php'
        </script>
        _END;
    }
    else {
        $id = rand(1,99) . "stch";
        add_user($pdo, $id, $fn, $hash, $email, $role);
        echo<<<_END
        <script>
        document.location.href = 'login.php'
        </script>
        _END;
    }
}
else   
    echo "Error due to: $fail";

function add_user($pdo,$id, $fn, $pw, $email, $role){
    $ismt = $pdo-> prepare ('INSERT INTO users VALUES(?,?,?,?,?)');

    $ismt -> bindParam(1, $fn, PDO::PARAM_STR, 32);
    $ismt -> bindParam(2, $email, PDO::PARAM_STR, 64);
    $ismt -> bindParam(3, $pw, PDO::PARAM_STR, 64);
    $ismt -> bindParam(4, $role, PDO::PARAM_STR, 64);
    $ismt -> bindParam(5, $id, PDO::PARAM_STR, 64);

    $ismt -> execute([$fn, $email, $pw, $role, $id]);

    $pdo = NULL;
}

function validate_fname($field){
    return ($field=='')?"No Name was entered<br>":"";
}

function validate_surname($field){
    return($field == '')?"No surname was entered<br>":"";
}

function validate_password($field){
    if($field == "")
        return "No password was entered<br>";
    else if (strlen($field)<6)
        return "Password must be at least 6 characters<br>";
    else if (!preg_match("/[a-z]/", $field) || !preg_match("/[A-Z]/", $field) || !preg_match("/[0-9]/", $field))
        return "Password require 1 each of a-z, A-Z and 0-9 <br>";
    else if (strlen($field) >12)
        return "Password must be less than 12 characters<br>";
    return "";
}

function fix_string($string){
    $string = stripslashes($string);
    return htmlentities($string);
}
