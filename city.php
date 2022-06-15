<?php 
if(isset($_POST['state_id'])){
    include('db_conn.php');
    $stateId = $_POST['state_id'];
    $sql = "SELECT * FROM cities WHERE state_id='".$stateId."' ORDER BY cityname ASC";
    $res = $conn->query($sql);
        while($row = mysqli_fetch_array($res)){
            ?>
<option value="" hidden selected>Select city</option>
<option value="<?php echo $row['id'] ?>"><?php echo $row['cityname'] ?></option>
<?php
    }
}
?>