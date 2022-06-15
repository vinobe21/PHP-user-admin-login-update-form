<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div class="container">
        <?php
        session_start();
        include('db_conn.php');
        if(isset($_SESSION['user_email'])){
            header("location:welcome.php");
        }
        $email = $password = '';
        $emailErr = $passwordErr = '';
        $error = '';
        
        if(isset($_GET['Register']) == true){
            echo '<div class="alert alert-success" role="alert">'. $_GET['Register'] .'</div>';
        }
        if(isset($_GET['Invalid']) == true){
            echo '<div class="alert alert-danger" role="alert">'. $_GET['Invalid'] .'</div>';
        }
        if(isset($_GET['NotFound']) == true){
            echo '<div class="alert alert-danger" role="alert">'. $_GET['NotFound'] .'</div>';
        }

        if(isset($_POST['login_submit'])){
            $valid = true;
    
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
    
                //email validation
                if(empty($email)){
                    $emailErr = "Email cannot be blank"; 
                    $valid = false;
                }else if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email) ) {  
                    $emailErr = "Enter valid Email Id."; 
                    $valid = false;
                }
    
                //password validation
                if (empty($password)) {  
                    $passwordErr = "password cannot be blank";  
                    $valid = false;
                }else if (!preg_match('/^[A-Za-z0-9!@#$%^&*()_]{6,20}$/', $password) ) {  
                    $passwordErr = "Enter valid password must be 6 char.";  
                    $valid = false;
                }
            }
            
            if($valid){
                $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
                $row = mysqli_query($conn,$query);
                $count = mysqli_num_rows($row);
                if($count > 0){
                    $rows = mysqli_fetch_object($row);
                    if($rows->status == '1'){
                        $_SESSION['user_id'] = $rows->id;
                        $_SESSION['user_name'] = $rows->name;
                        $_SESSION['user_email'] = $rows->email;
                        header("location:welcome.php?LoginSuccess=Login Successfully");
                    }else{
                        $error = "You don't have permission to login, Please contact admin";
                    }
                }else{
                    $error = "Your Login email or Password is invalid";
                }
            }
        }
        ?>
        <h1>User Login</h1>
        <form class="w-50" action="" method="POST" id="loginForm" onsubmit="return checkInputs();">
            <div style="text-align: center; font-size:16px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" value="<?php echo $email; ?>" name="email" class="form-control"
                    placeholder="email">
                <?php echo '<span class="input_err" id="email_err">'. $emailErr. '</span>' ?>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" value="<?php echo $password; ?>" name="password"
                    class="form-control" placeholder="type your password">
                <?php echo '<span class="input_err" id="password_err">'. $passwordErr. '</span>' ?>
            </div>
            <button type="submit" value="submit" id="submit" name="login_submit" class="btn btn-primary">Login</button>
            <a href="register.php" type="button" class="btn btn-primary">Register</a>
            <a href="admin/login.php" type="button" class="btn btn-primary">Admin Login</a>
        </form>
    </div>


    <script type="text/javascript">
    var form = document.getElementById('loginForm');
    var email = document.getElementById('email');
    var password = document.getElementById('password');

    var email_err = document.getElementById('email_err');
    var password_err = document.getElementById('password_err');

    function checkInputs() {
        var emailValue = email.value.trim();
        var passwordValue = password.value.trim();
        var flag = false;

        if (emailValue == '') {
            setErrorFor(email_err, 'Email cannot be blank');
            flag = true;
        } else if (!isEmail(emailValue)) {
            setErrorFor(email_err, 'Enter valid Email Id.');
            flag = true;
        } else {
            setSuccessFor(email_err);
        }

        if (passwordValue == '') {
            setErrorFor(password_err, 'password cannot be blank');
            flag = true;
        } else if (!isPassword(passwordValue)) {
            setErrorFor(password_err, 'Enter valid password must be 6 char.');
            flag = true;
        } else {
            setSuccessFor(password_err);
        }

        if (flag == true) {
            return false;
        } else {
            return true;
        }
    }

    function isEmail(email) {
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            .test(email);
    }

    function isPassword(password) {
        return /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/.test(password);
    }

    function setErrorFor(input, message) {
        input.innerText = message;
        input.classList.remove('success');
        input.classList.add('error');
        // input.parentElement.className = 'form-group error';
    }

    function setSuccessFor(input) {
        // input.parentElement.className = 'form-group success mb-3';
        input.classList.remove('error');
        input.classList.add('success');
    }
    </script>

</body>


</html>