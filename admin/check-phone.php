<?php
include("../db_conn.php");
session_start();
$phone = trim($_POST['phone']);
$userid = $_POST['id'];

if(empty($phone)){
    echo "Phone cannot be blank";
}else if(!preg_match('/^[0-9]{10}/', $phone) ) {  
    echo "Enter valid 10 digit phone number.";
}else{
    $query = "SELECT * FROM user WHERE phone='$phone' AND id!='$userid'";
    $result = $conn->query($query);
    if(mysqli_num_rows($result)>0){
        echo "Phone already exist..";
    }else{
        echo " ";
    }
}