<?php
include('../db_conn.php');

    $id = $_POST['id'];
    $status = ($_POST['status'] == 1) ? 1 : 0;
    $sql = "UPDATE user SET status='$status' WHERE id='$id' ";
    $result = $conn->query($sql);
?>