<?php
    include('../db_conn.php');

    if(isset($_GET['id'])){
        $did = $_GET['id'];
        $dquery = "DELETE FROM user WHERE id='$did'";
        $result = $conn->query($dquery);
        if($result){
            header('location:home.php');
        }
    }
    
?>