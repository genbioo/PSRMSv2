<?php
session_start();
if(isset($_SESSION["userID"])) {
    session_unset(); 
    session_destroy();
    echo "<script type='text/javascript'>alert('Two logins detected! Please sign in again.'); 
    location='login_page.php';
    </script>";
} else {
    session_start();
    $_SESSION["userID"] = $_POST['userID'];
    $_SESSION['disaster_id'] = 1;
    header( "Location: dashboard.php" );
}
?>