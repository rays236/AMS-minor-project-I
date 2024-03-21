
<?php
//replace continue.php with home.php in SIGNup
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
$dynamic = $dynamicnav = $name = $classenrolled= " ";
if(isset($_SESSION['id'])){
    $id = htmlspecialchars($_SESSION['id']);

    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = $pdo -> query($query);
    $row = $result->fetch();

    $name = $row['fname'];
    $email = $row['email'];
    $role = $row['role'];

    if($role == 'teacher'){
        $dynamic = "create_class.html";
        $dynamicnav = "Create Class";
        $mycard = '<dialog data-modal class="mycard"><form action="createclass.php" method="post"><div class="title">Class Details</div><p class="message">Enter details for your class.</p><div class="inputs"><input id="input1" name="input1" type="text" maxlength="12 placeholder = "Class Name"><br><input id="input2" name = "input2" type="text" maxlength="12" placeholder = "Subject"><br><input id="input3" name = "input3" type="text" maxlength="12" placeholder = "Section"></div><button type="submit" class="action">Create Class</button><button type="submit" class="action" formmethod="dialog">Cancel</button></form></dialog>';

        $qt = "SELECT * From classes";
        $rt = $pdo -> query($qt);
        while($rwt = $rt ->fetch()){
            $tid = $rwt['teacher'];
            $classname = $rwt['classname'];
            if($id == $tid ){
                $classenrolled .= "<li><a href='#'> $classname </a></li>";
            }
        }
    }
    else{
        $dynamic = "join_class.html";
        $dynamicnav = "Join Class";
        $mycard = '<dialog data-modal class="mycard"><form action="joinclass.php" method="post"><div class="title">Class Code</div><p class="message">Enter the code provided by your lecturer.</p><div class="inputs"><input id="input1" name="classcode" type="text" maxlength="5"></div><button type="submit" class="action">Join Class</button><button type="submit" class="action" formmethod="dialog">Cancel</button></form></dialog>';

        $qs = "SELECT * FROM classes";
        $rs = $pdo->query($qs);
        while($rws = $rs -> fetch()){
            $std_tbl_id = $rws['std_tbl_id'];
            $classname = $rws['classname'];

            $qs2 = "SELECT * FROM $std_tbl_id";
            $rs2 = $pdo -> query($qs2);
            while($rws2 = $rs2 -> fetch()){
                if($id == $rws2['student_id']){
                    $classenrolled .= "<li><a href='#'> $classname </a></li>";
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
    <title>Drop Down Sidebar Menu</title>
    <!-- Boxicons CSS -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="modal.css">
</head>
<body>
    <div class="sidebar"> 
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus'></i>
            <span class="logo_name">CodingLab</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="home.php">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Dashboard</a></li>
                </ul>
            </li>
            <li>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-layer-plus'></i>
                        <span class="link_name">Enrolled</span>
                    </a>
                    <i class='bx bx-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Enrolled</a></li>
                    $classenrolled
                </ul>
            </li>
            <li>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-archive'></i>
                        <span class="link_name">Archived</span>
                    </a>
                    <i class='bx bx-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Archived</a></li>
                    <li><a href="#">Archived Class 1</a></li>
                    <li><a href="#">Archived Class 2</a></li>
                    <li><a href="#">Archived Class 3</a></li>
                </ul>
            </li>
            <li data-open-modal>
                <a>
                    <i class='bx bx-list-plus' ></i>
                    <span class="link_name">$dynamicnav</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name">$dynamicnav</a></li>
                </ul>
            </li> 
            $mycard
            <li>
                <a href="#">
                    <i class='bx bx-cog' ></i>
                    <span class="link_name">Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Settings</a></li>
                </ul>
            </li>
            <li>
            <div class="profile-details">
             <div class="profile-content">
                    <img src="image/profile.png" alt="profile">
             </div>
            
            <div class="name-job">
                <div class="profile_name">$name</div>
                <div class="job">$role</div>
            </div>
            <a href="../SIGNup/logout.php"><i class='bx bx-log-out' ></i></a>
            </div>
        </li>
    </ul>
    </div>
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Drop Down Sidebar</span>
    </div>
</section>
<script>
    let arrow = document.querySelectorAll(".arrow");
   
    for(var i=0; i< arrow.length; i++){
         arrow[i].addEventListener("click", (e)=>{
        let arrowParent = e.target.parentElement.parentElement;
        console.log(arrowParent);
        arrowParent.classList.toggle("showMenu");
        });
    }

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    sidebarBtn.addEventListener("click",()=>{
        sidebar.classList.toggle("close");
    });

    const openButton = document.querySelector("[data-open-modal]")
        const modal = document.querySelector("[data-modal]")

        openButton.addEventListener("click", () => {
            modal.showModal()
        })

        modal.addEventListener("click", e => {
            const dialogDimensions = modal.getBoundingClientRect()
            if (
                e.clientX < dialogDimensions.left ||
                e.clientX > dialogDimensions.right ||
                e.clientY < dialogDimensions.top ||
                e.clientY > dialogDimensions.bottom

            ) {
                modal.close()
            }
        })
</script>
</body>
</html>
_END;
}
else echo"Please <a href = '../SIGNup/login.php'>Click here</a> to log in.";

?>