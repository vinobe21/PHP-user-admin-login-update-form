<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("location:welcome.php");
}else{
    header("location:login.php");
}

?>