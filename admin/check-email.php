<?php
error_reporting(E_ERROR | E_PARSE);
include("../db_conn.php");
session_start();
$email = trim($_POST['email']);
$userid = $_POST['id'];

if(empty($email)){
    echo "Email cannot be blank";
}else if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email) ) {  
    echo "Enter valid Email Id.";
}else{
    $query = "SELECT * FROM user WHERE email='$email' AND id!='$userid'";
    $result = $conn -> query($query);
    if(mysqli_num_rows($result)>0){
        echo "Email already exist..";
    }else{
        echo " ";
    }
}