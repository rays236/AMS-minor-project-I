<?php

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

require_once 'connect.php';

try{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch(PDOException $e){
    throw new PDOException($e ->getMessage(), (int)$e->getCode());
}

if(isset($_POST['email']) && isset($_POST['password'])){
    $un_temp = sanitize($pdo, $_POST['email']);
    $pw_temp = sanitize($pdo, $_POST['password']);
    $query = " SELECT * FROM users WHERE email = $un_temp";
    $result = $pdo -> query($query);

    if (!$result->rowCount()) die("User not found");
    $row = $result->fetch();
    $fn  = $row['fname'];
    $pw  = $row['password'];
    $email = $row['email'];
    $id = $row['id'];
    if (password_verify(str_replace("'", "", $pw_temp), $pw)){
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['email'] = $email;

        echo<<<_END
        <script>
        document.location.href = '../new_dashboard/home.php' 
        </script>
        _END; 
    exit;
        //echo htmlspecialchars("Hi $fn, you are now logged in as '$fn'");
    }
    else die("Invalid email/password combination");
}
else
{
header('WWW-Authenticate: Basic realm="Restricted Area"'); header('HTTP/1.1 401 Unauthorized');
die ("Please enter your username and password");
}
function sanitize($pdo, $str) {
    $str = htmlentities($str);
return $pdo->quote($str); }
?>

