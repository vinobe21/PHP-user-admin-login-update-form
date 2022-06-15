<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <style>
    .error {
        color: red;
        display: block;
    }
    </style>
</head>

<body>
    <?php
    session_start();
    include('db_conn.php');
    $currentUserEmail= $_SESSION['user_email'];
    if(!isset($currentUserEmail)){
        header("location:login.php");
    }
    if(isset($_GET['LoginSuccess']) == true){
        echo '<div class="alert alert-success" role="alert">'. $_GET['LoginSuccess'] .'</div>';
    }
    if(isset($_GET['Update']) == true){
        echo '<div class="alert alert-success" role="alert">'. $_GET['Update'] .'</div>';
    }

?>
    <?php
            
    $sql = "SELECT user.id, user.firstname, user.lastname, user.email, user.phone, user.gender, user.state, user.city, user.hobby, user.file, state.state_name, cities.cityname FROM `user` 
        INNER JOIN state on user.state=state.id 
        INNER JOIN cities on user.city=cities.id 
        WHERE email='".$currentUserEmail."'";
    $result = $conn->query($sql);
    
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){

            ?>
    <div class="container py-5">
        <div class="row text-end">
            <div class="col-md-12">
                <a type="button" class="btn btn-primary" href="updateProfile.php?id=<?php echo $row['id'] ?>">Update
                    Profile</a>
                <a type="button" class="btn btn-primary" href="logout.php?logout">Logout</a>
            </div>
        </div>
        <div class="row text-center">
            <h5>Welcome <?php echo $row['email'] ?></h5>

            <div class="row text-center">
                <table class="table table-striped w-50 m-auto">
                    <tbody>
                        <tr>
                            <td>First Name</td>
                            <td><?php echo $row['firstname']; ?></td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td><?php echo $row['lastname']; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?php echo $row['email']; ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td><?php echo $row['phone']; ?></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td><?php echo $row['gender']; ?></td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td><?php echo $row['state_name']; ?></td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td><?php echo $row['cityname']; ?></td>
                        </tr>
                        <tr>
                            <td>Hobbies</td>
                            <td><?php echo $row['hobby']; ?></td>
                        </tr>
                        <tr>
                            <td>Profile Image</td>
                            <td><img alt="profile" src="<?php echo 'images/'.$row['file'] ?>" width="100px"
                                    height="100px" style="object-fit: cover;" /></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <?php
                }
            }
            ?>

        </div>
    </div>
</body>

</html>