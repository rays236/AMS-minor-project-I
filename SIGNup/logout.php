<?php
session_start();
if (isset($_SESSION['id'])){
    $id = $_SESSION['id'];

    destroy_session_and_data();

    echo<<<_END
    <script>
    document.location.href = 'login.php' 
    </script>
_END;
}
else {
    echo<<<_END
    <script>
    document.location.href = 'login.php' 
    </script>
    _END;
}

function destroy_session_and_data(){
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
}

