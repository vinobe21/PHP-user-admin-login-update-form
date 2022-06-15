<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>


</head>

<body>
    <?php
    include('../db_conn.php');

    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    $nth_users = $result->num_rows;
    $nth_users_per_page = 4;

    $nth_page = ceil($nth_users/$nth_users_per_page);
    $page = 1;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    $start_limit = ($page-1) * $nth_users_per_page;

    $query = "SELECT user.id, user.firstname, user.lastname, user.email, user.phone, user.gender, user.state, user.city, user.hobby, user.file, state.state_name, cities.cityname FROM `user` 
        INNER JOIN state on user.state=state.id 
        INNER JOIN cities on user.city=cities.id LIMIT $start_limit, $nth_users_per_page";
    $res = $conn->query($query);
    $rows = mysqli_num_rows($res);
    ?>
    <div class="container">
        <table class="table table-bordered">
            <tr>
                <th>User Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>State</th>
                <th>City</th>
                <th>Hobbies</th>
                <th>Profile</th>
            </tr>
            <?php 
            if($rows > 0){
                while($row = mysqli_fetch_array($res)){
                    ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['state_name']; ?></td>
                <td><?php echo $row['cityname']; ?></td>
                <td><?php echo $row['hobby']; ?></td>
                <td><img alt="profile" src="<?php echo '../images/'.$row['file'] ?>" width="100px" height="100px"
                        style="object-fit: cover;" /></td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-end">

                <?php
            for($i=1; $i<=$nth_page; $i++){
                $pagename = basename($_SERVER['PHP_SELF']);
                if($page = $i){
                    echo "<a type='button' class='me-2 btn btn-secondary active' href='{$pagename}?page={$i}'>{$i}</a>";
                }else{
                    echo "<a type='button' class='me-2 btn btn-secondary' href='{$pagename}?page={$i}'>{$i}</a>";
                }
            }
            ?>
            </div>
        </div>
    </div>
</body>

</html>