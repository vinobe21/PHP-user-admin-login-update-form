<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php 
    session_start();
    include('db_conn.php');
    if(!isset($_SESSION['user_email'])){
        header("location:login.php");
    }


    $currentUserEmail = $_SESSION['user_email'];
    $firstName = $lastName = $email = $phone = $password = $gender = $state = $city = $file = '';
    $hobby = [];
    $firstNameErr = $lastNameErr = $emailErr = $phoneErr = $passwordErr = $conpassErr = $genderErr = $stateErr = $cityErr = $hobbyErr = $fileErr = '';

    if(isset($_POST['update'])){
        $file = $_FILES['file'];
        if(!empty($file)){
            $targetDir = "images/";
            $time = date("d-m-Y")."-".time();
            $fileName = basename($_FILES["file"]["name"]);
            $fileName = $time."-".$fileName ;
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg');
        }
        
        $valid = true;

        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $firstName = trim($_POST['firstname']);
            $lastName =trim( $_POST['lastname']);
            $email = trim($_POST['email']);
            $phone =  trim($_POST['phone']);
            $password = trim($_POST['password']);
            $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
            $state = $_POST['state'];
            $city = $_POST['city'];
            $hobby = isset($_POST['hobby']) ? $_POST['hobby'] : [] ;
            

            //first name validation
            if(empty($firstName)){
                $firstNameErr = "firstname cannot be blank"; 
                $valid = false;
            }else if (!preg_match ("/^[A-Za-z]+$/", $firstName) ) {  
                $firstNameErr = "Only alphabets are allowed."; 
                $valid = false;
            }  

            //last name validation
            if(empty($lastName)){
                $lastNameErr = "lastname cannot be blank"; 
                $valid = false;
            }else if(!preg_match ("/^[A-Za-z]+$/", $lastName) ) {  
                $lastNameErr = "Only alphabets are allowed."; 
                $valid = false; 
            }
            
            //email validation
            if(empty($email)){
                $emailErr = "Email cannot be blank"; 
                $valid = false;
            }else if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email) ) {  
                $emailErr = "Enter valid Email Id."; 
                $valid = false;
            }

            //phone validation
            if(empty($phone)){
                $phoneErr = "Phone cannot be blank";  
                $valid = false;
            }else if (!preg_match('/^[0-9]{10}/', $phone) ) {  
                $phoneErr = "Enter valid 10 digit phone number.";  
                $valid = false;
            } 

            //password validation
            if (empty($password)) {  
                $passwordErr = "password cannot be blank";  
                $valid = false;
            }else if (!preg_match('/^[A-Za-z0-9!@#$%^&*()_]{6,20}$/', $password) ) {  
                $passwordErr = "Enter valid password must be one number, one special sign, 6 char.";  
                $valid = false;
            }

            //gender checkbox validation
            if(empty($gender)){
                $genderErr = "Select Gender.";
                $valid = false;
            }
            
            //hobbies checkbox validation
            if(empty($hobby)){
                $hobbyErr = "Select Hobbies.";
                $valid = false;
            }

            //state validation
            if(empty($state)){
                $stateErr = "Select state.";
                $valid = false;
            }
            
            //city validation
            if(empty($city)){
                $cityErr = "Select City.";
                $valid = false;
            }
            
            //upload file 
             if(!empty($file) && !in_array($fileType, $allowTypes)){
                $fileErr = "Please Select valid file format";
                $valid = false;
            }
            
        }
        if($valid){
            $hobbydata = (implode(',', $_POST['hobby']));
            if(!empty($file) && move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                $id = $_GET['id'];
                $delSql = "SELECT file FROM user WHERE id='".$id."'";
                $deleteSql = $conn->query($delSql);
                $deleteFile = mysqli_fetch_array($deleteSql);
                $oldFile = $targetDir.$deleteFile['file'];
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
                $sql = "UPDATE user SET firstname='".$firstName."',lastname='".$lastName."',email='".$email."',phone='".$phone."',password='".$password."',gender='".$gender."',state='".$state."',city='".$city."',hobby='".$hobbydata."',file='".$fileName."' WHERE id='".$id."' ";
                }else{
                    $sql = "UPDATE user SET firstname='".$firstName."',lastname='".$lastName."',email='".$email."',phone='".$phone."',password='".$password."',gender='".$gender."',state='".$state."',city='".$city."',hobby='".$hobbydata."' WHERE id='".$id."' ";
                }
                $result = $conn->query($sql);
                if ($result) {
                    header("location:welcome.php?Update=User Update Successfully..");
                }else{
                    echo '<div class="alert alert-danger" role="alert">Not update..</div>';
                }
            }else{
                echo '<div class="alert alert-danger" role="alert">Fill all details</div>';
            }
        
        }
    ?>
    <div class="container">
        <h1>Update Your Profile</h1>
        <div class="row">
            <div class="col-md-8 text-end">
                <a type="button" class="btn btn-primary" href="logout.php?logout">Logout</a>
            </div>
        </div>
        <form class="w-50" action="" method="POST" id="updateForm" enctype="multipart/form-data"
            onsubmit="return checkInputs();">
            <?php
                $id = $_GET['id'];
                // $sql = "SELECT * FROM user WHERE id='".$id."'";
                $sql = "SELECT user.id, user.firstname, user.lastname, user.email, user.phone, user.gender, user.gender, user.state, user.city, user.hobby, user.file, cities.id, cities.cityname, state.id, state.state_name FROM user 
                        INNER JOIN state ON user.state=state.id 
                        INNER JOIN cities ON user.city=cities.id 
                        WHERE user.id='$id'";
                $result = $conn->query($sql);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        $checked_arr = explode(",",$row['hobby']);
                        $sta_id = $row['id'];
                        ?>
            <div class="form-group mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input id="firstname" type="text" name="firstname" class="form-control" placeholder="first name"
                    value="<?php echo $row['firstname']; ?>">
                <?php echo '<span class="input_err" id="firstname_err">'. $firstNameErr. '</span>' ?>
            </div>
            <div class="form-group mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input id="lastname" type="text" name="lastname" class="form-control" placeholder="last name"
                    value="<?php echo $row['lastname']; ?>">
                <?php echo '<span class="input_err" id="lastname_err">'. $lastNameErr. '</span>' ?>
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" class="form-control" placeholder="email"
                    value="<?php echo $row['email']; ?>"
                    onblur="return checkEmail(<?php echo $_GET['id'];?>,this.value);">
                <?php echo '<span class="bg input_err" id="email_err">'. $emailErr. '</span>' ?>
            </div>
            <div class="form-group mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input id="phone" type="number" name="phone" class="form-control" placeholder="Phone number"
                    value="<?php echo $row['phone'] ?>"
                    onblur="return checkPhone(<?php echo $_GET['id'];?>,this.value);">
                <?php echo '<span class="bg input_err" id="phone_err">'. $phoneErr. '</span>' ?>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">New Password</label>
                <input id="password" type="password" name="password" class="form-control"
                    placeholder="Enter your new password">
                <?php echo '<span class="input_err" id="password_err">'. $passwordErr. '</span>' ?>
            </div>
            <div class="form-group mb-3">
                <label for="gender" class="form-label">Gender : </label>
                <input id="gender" type="radio" name="gender" value="male"
                    <?php if($row['gender'] =="male"){echo 'checked';}  ?>>Male
                <input id="gender" type="radio" name="gender" value="female"
                    <?php if($row['gender'] =="female"){echo 'checked';} ?>>Female
                <input id="gender" type="radio" name="gender" value="others"
                    <?php if($row['gender'] =="others"){echo 'checked';}?>>Others
                <?php echo '<span class="input_err" id="gender_err">'. $genderErr. '</span>' ?>
            </div>

            <div class="form-group mb-3">
                <label for="state" class="form-label">Choose Your State : </label>
                <select name="state" id="state" class="form-control">
                    <?php
                        $state_query=mysqli_query($conn, "SELECT * FROM state");
                        while($roww=mysqli_fetch_array($state_query))
                        { ?>
                    <option name="state" value="<?php echo $roww['id']?>"
                        <?php echo ($roww['id'] == $sta_id or isset($_POST['state']) && $_POST['state'] == $roww['id']) ? 'selected' : ''; ?>>
                        <?php echo $roww["state_name"]?>
                    </option>
                    <?php  } ?>
                </select>
                <?php echo '<span class="input_err" id="state_err">'. $cityErr. '</span>' ?>
            </div>
            <div class="form-group mb-3">
                <label for="city" class="form-label">Choose Your City : </label>
                <select class="form-select" id="city" name="city">
                    <?php
                    $city_sql = "SELECT user.city, cities.cityname, cities.id FROM user 
                    INNER JOIN cities ON user.city=cities.id WHERE user.city='".$row['city']."'";
                    $city_conn = $conn->query($city_sql);
                    while($city_row = mysqli_fetch_array($city_conn)){
                        ?>
                    <option value=<?php echo $city_row['city']; ?>><?php echo $city_row['cityname']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php echo '<span class="input_err" id="city_err">'. $cityErr. '</span>' ?>
            </div>

            <div class="form-group mb-3">
                <label for="hobby" class="form-label">Hobbies : </label>
                <input id="hobby" type="checkbox" name="hobby[]" value="reading"
                    <?php echo (in_array('reading', $checked_arr) or in_array('reading', $hobby)) ? 'checked' : '' ; ?>>Reading
                <input id="hobby" type="checkbox" name="hobby[]" value="writing"
                    <?php echo (in_array('writing', $checked_arr) or in_array('writing', $hobby)) ? 'checked' : '' ; ?>>writing
                <input id="hobby" type="checkbox" name="hobby[]" value="painting"
                    <?php echo (in_array('painting', $checked_arr) or in_array('painting', $hobby)) ? 'checked' : '' ;  ?>>Painting
                <input id="hobby" type="checkbox" name="hobby[]" value="dancing"
                    <?php echo (in_array('dancing', $checked_arr) or in_array('dancing', $hobby)) ? 'checked' : '' ; ?>>Danceing
                <?php echo '<span class="input_err" id="hobby_err">'. $hobbyErr. '</span>' ?>
            </div>
            <div class="form-group mb-3">
                <label for="file" class="form-label">Upload File : </label>
                <input id="file" type="file" name="file" value="<?php $row['file'] ?>" />
                <img alt="profile" src="<?php echo 'images/'.$row['file'] ?>" width="100px" height="100px"
                    style="object-fit: cover;" />
                <?php echo '<span class="input_err" id="file_err">'. $fileErr. '</span>' ?>
            </div>
            <button id="submit" type="submit" value="update" name="update" class="btn btn-primary">Update</button>
            <a href="welcome.php" type="button" class="btn btn-danger">Cancel</a>
            <?php  
                    }
                }
                
            ?>
        </form>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $("#state").change(function() {
            var state_id = this.value;
            $.ajax({
                url: "city.php",
                type: "POST",
                data: {
                    state_id: state_id
                },
                cache: false,
                success: function(result) {
                    $("#city").html(result);
                }
            });
        });
    });

    function checkEmail(id, emailValue) {
        $.ajax({
            method: "POST",
            url: "check-email.php",
            data: {
                id: id,
                email: emailValue,
            },
            success: function(data) {
                $('#email_err').html(data);
            }
        });
    }

    function checkPhone(id, phoneValue) {
        $.ajax({
            method: "POST",
            url: "check-phone.php",
            data: {
                id: id,
                phone: phoneValue,
            },
            success: function(data) {
                $('#phone_err').html(data);
            }
        });
    }

    var form = document.getElementById('updateForm');
    var firstname = document.getElementById('firstname');
    var lastname = document.getElementById('lastname');
    var email = document.getElementById('email');
    var phone = document.getElementById('phone');
    var password = document.getElementById('password');
    var gender = document.getElementsByName('gender');
    var state = document.getElementById('state');
    var city = document.getElementById('city');
    var hobby = document.getElementsByName('hobby[]');
    var file = document.getElementById('file');

    var firstname_err = document.getElementById('firstname_err');
    var lastname_err = document.getElementById('lastname_err');
    var email_err = document.getElementById('email_err');
    var phone_err = document.getElementById('phone_err');
    var password_err = document.getElementById('password_err');
    var gender_err = document.getElementById('gender_err');
    var state_err = document.getElementById('state_err');
    var city_err = document.getElementById('city_err');
    var hobby_err = document.getElementById('hobby_err');
    var file_err = document.getElementById('file_err');


    function checkInputs() {
        var firstnameValue = firstname.value.trim();
        var lastnameValue = lastname.value.trim();
        var emailValue = email.value.trim();
        var phoneValue = phone.value.trim();
        var passwordValue = password.value.trim();
        var stateValue = state.value;
        var cityValue = city.value;
        var fileValue = file.value;
        var flag = false;


        if (firstnameValue == '') {
            setErrorFor(firstname_err, 'firstname cannot be blank');
            flag = true;
        } else if (!isFirstName(firstnameValue)) {
            setErrorFor(firstname_err, 'Only alphabets are allowed.');
            flag = true;
        } else {
            setSuccessFor(firstname_err);
        }

        if (lastnameValue == '') {
            setErrorFor(lastname_err, 'lastname cannot be blank');
            flag = true;
        } else if (!isLastName(lastnameValue)) {
            setErrorFor(lastname_err, 'Only alphabets are allowed.');
            flag = true;
        } else {
            setSuccessFor(lastname_err);
        }

        if (emailValue == '') {
            setErrorFor(email_err, 'Email cannot be blank');
            flag = true;
        } else {
            setSuccessFor(email_err);
        }

        if (phoneValue == '') {
            setErrorFor(phone_err, 'phone cannot be blank');
            flag = true;
        } else {
            setSuccessFor(phone_err);
        }

        if (passwordValue == '') {
            setErrorFor(password_err, 'password cannot be blank');
            flag = true;
        } else if (!isPassword(passwordValue)) {
            setErrorFor(password_err, 'Enter valid password must be one number, one special sign, 8 char.');
            flag = true;
        } else {
            setSuccessFor(password_err);
        }

        var gen = false;
        for (var i = 0; i < gender.length; i++) {
            if (gender[i].checked) {
                gen = true;
                break;
            }
        }
        if (!gen) {
            setErrorFor(gender_err, 'Select gender');
            flag = true;
        } else {
            setSuccessFor(gender_err);
        }

        if (stateValue == '') {
            setErrorFor(state_err, 'Select state');
            flag = true;
        } else {
            setSuccessFor(state_err);
        }

        if (cityValue == '') {
            setErrorFor(city_err, 'Select city');
            flag = true;
        } else {
            setSuccessFor(city_err);
        }

        var hob = false;
        for (var i = 0; i < hobby.length; i++) {
            if (hobby[i].checked == true) {
                hob = true;
                break;
            }
        }
        if (hob == false) {
            setErrorFor(hobby_err, 'Select Hobbies');
            flag = true;
        } else {
            setSuccessFor(hobby_err);
        }

        // var re = /(\.jpg|\.jpeg|\.png)$/i;
        // if (fileValue == '') {
        //     setErrorFor(file_err, 'Select file');
        //     flag = true;
        // } else if (!re.exec(fileValue)) {
        //     setErrorFor(file_err, 'Please Select valid file format');
        //     flag = true;
        // } else {
        //     setSuccessFor(file_err);
        // }

        if (flag == true) {
            return false;
        } else {
            return true;
        }

    }

    function isFirstName(firstname) {
        return /^[A-Za-z]+$/.test(firstname);
    }

    function isLastName(lastname) {
        return /^[A-Za-z]+$/.test(lastname);
    }

    function isPhone(phone) {
        return /^[0-9]{10}/.test(phone);
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