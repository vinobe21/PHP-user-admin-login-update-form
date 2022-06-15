<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    session_start();
    include('db_conn.php');
    if(isset($_SESSION['user_email'])){
        header("location:updateProfile.php");
    }

    $firstName = $lastName = $email = $phone = $password = $conpass = $gender = $state = $city = $file = '';
    $hobby = [];
    $firstNameErr = $lastNameErr = $emailErr = $phoneErr = $passwordErr = $conpassErr = $genderErr = $stateErr = $cityErr = $hobbyErr = $fileErr = '';
    $hobbydata = "";
    
    if(isset($_POST['submit'])){
        $targetDir = "images/";
        $time = date("d-m-Y")."-".time();
        $fileName = basename($_FILES["file"]["name"]);
        $fileName = $time."-".$fileName ;
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        $valid = true;
        $allowTypes = array('jpg','png','jpeg');
        
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $firstName = trim($_POST['firstname']);
            $lastName =trim( $_POST['lastname']);
            $email = trim($_POST['email']);
            $phone =  trim($_POST['phone']);
            $password = trim($_POST['password']);
            $conpass = trim($_POST['conf_pass']);
            $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
            $state = $_POST['state'];
            $city = $_POST['city'];
            $hobby = isset($_POST['hobby']) ? $_POST['hobby'] : [] ;
            $file = $_FILES['file'];

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
                $passwordErr = "Enter valid password must be 6 char.";  
                $valid = false;
            }

            //confirm password
            if(empty($conpass)){
                $conpassErr = "Confirm password cannot be blank";
                $valid = false;
            }else if($password != $conpass){
                $conpassErr = "Password not match!..";
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
            if(empty($file)){
                $fileErr = "Select file.";
                $valid = false;
            }else if(!in_array($fileType, $allowTypes)){
                $fileErr = "Please Select valid file format";
                $valid = false;
            }
        }

    if($valid){
        $datasql = "SELECT email FROM user WHERE email='".$_POST['email']."'";
        $phonesql = "SELECT phone FROM user WHERE phone='".$_POST['phone']."'";
        $data = $conn->query($datasql);
        $phonedata = $conn->query($phonesql);
        if(mysqli_num_rows($data) != 0){
            $emailErr = "Email already exist..";
        }else if(mysqli_num_rows($phonedata) != 0){
           $phoneErr = "Phone number already exist..";
        }else{
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){  
                $hobbydata = (implode(',', $_POST['hobby']));
                $sql = "INSERT INTO user (firstname, lastname, email, phone, password, gender, state, city, hobby, file) VALUES ('$firstName', '$lastName', '$email', '$phone', '$password', '$gender','$state', '$city', '$hobbydata', '$fileName')";
                $result = $conn->query($sql);
                if ($result) {
                    header("location:login.php?Register=User Register Successfully..");
                }
            }else{
                echo '<div class="alert alert-danger" role="alert">File not upload</div>';
            }
        }
    }
    }
    ?>

    <div class="container">
        <h1>Register New User</h1>
        <form class="w-50" action="" method="POST" name="myForm" id="registerForm" enctype="multipart/form-data"
            onsubmit="return checkInputs();">
            <div class="form-group mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input id="firstname" type="text" value="<?php echo $firstName; ?>" name="firstname"
                    class="form-control" placeholder="first name">
                <?php echo '<span class="input_err" id="firstname_err">'. $firstNameErr. '</span>' ?>

            </div>
            <div class="form-group mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input id="lastname" type="text" value="<?php echo $lastName; ?>" name="lastname" class="form-control"
                    placeholder="last name">
                <?php echo '<span class="input_err" id="lastname_err">'. $lastNameErr. '</span>' ?>

            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" value="<?php echo $email; ?>" name="email" class="form-control"
                    placeholder="email" onblur="return checkEmail(this.value);">
                <?php echo '<span class="bg input_err" id="email_err">'. $emailErr. '</span>' ?>

            </div>
            <div class="form-group mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input id="phone" type="number" value="<?php echo $phone; ?>" name="phone" class="form-control"
                    onblur="return checkPhone(this.value);" placeholder="Phone number">
                <?php echo '<span class="bg input_err" id="phone_err">'. $phoneErr. '</span>' ?>

            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" value="<?php echo $password; ?>" name="password"
                    class="form-control" placeholder="type your password">
                <?php echo '<span class="input_err" id="password_err">'. $passwordErr. '</span>' ?>

            </div>
            <div class="form-group mb-3">
                <label for="conf_pass" class="form-label">Confirm Password</label>
                <input id="conf_pass" type="password" value="<?php echo $conpass; ?>" name="conf_pass"
                    class="form-control" placeholder="Retype your password">
                <?php echo '<span class="input_err" id="conf_pass_err">'. $conpassErr. '</span>' ?>

            </div>
            <div class="form-group mb-3">
                <label for="gender" class="form-label">Gender : </label>
                <input type="radio" name="gender" value="male" <?php if($gender =="male"){echo 'checked';} ?>>Male
                <input type="radio" name="gender" value="female" <?php if($gender =="female"){echo 'checked';} ?>>Female
                <input type="radio" name="gender" value="others" <?php if($gender =="others"){echo 'checked';} ?>>Others
                <?php echo '<span class="input_err" id="gender_err">'. $genderErr. '</span>' ?>

            </div>
            <div class="form-group mb-3">
                <label for="state" class="form-label">Choose Your State : </label>
                <select class="form-select" id="state" name="state">
                    <option hidden selected value="">Please select your State</option>
                    <?php 
                    $query = "SELECT * FROM state ORDER BY state_name ASC";
                    $result = $conn->query($query);
                    while ($row = mysqli_fetch_array($result)){
                            ?>
                    <option value='<?php echo $row['id']; ?>'
                        <?php echo (isset($_POST['state']) && $_POST['state'] == $row['id']) ? 'selected' : ''; ?>>
                        <?php echo $row['state_name']; ?>
                    </option>
                    <?php
                    }
                    ?>
                </select>
                <?php echo '<span class="input_err" id="state_err">'. $stateErr. '</span>' ?>
            </div>
            <div class="form-group mb-3">
                <label for="city" class="form-label">Choose Your City : </label>
                <select class="form-select" id="city" name="city">
                    <option hidden value=""> Select city</option>
                    <?php 
                    $query = "SELECT * FROM cities ORDER BY cityname ASC";
                    $result = $conn->query($query);
                    while($row = mysqli_fetch_array($result)){
                        
                        ?>
                    <option value='<?php echo $row['id']; ?>'
                        <?php echo (isset($_POST['city']) && $_POST['city'] == $row['id']) ? 'selected' : ''; ?>>
                        <?php echo $row['cityname']; ?>
                    </option>
                    <?php
                    }
                    ?>
                </select>
                <?php echo '<span class="input_err" id="city_err">'. $cityErr. '</span>' ?>
            </div>

            <div class="form-group mb-3">
                <label for="hobby" class="form-label">Hobbies : </label>
                <input type="checkbox" name="hobby[]" value="Reading"
                    <?php echo (in_array('Reading', $hobby)) ? 'checked' : '' ; ?>>Reading
                <input type="checkbox" name="hobby[]" value="Writing"
                    <?php echo (in_array('Writing', $hobby)) ? 'checked' : '' ; ?>> Writing
                <input type="checkbox" name="hobby[]" value="Painting"
                    <?php echo (in_array('Painting', $hobby)) ? 'checked' : '' ; ?>> Painting
                <input type="checkbox" name="hobby[]" value="Dancing"
                    <?php echo (in_array('Dancing', $hobby)) ? 'checked' : '' ; ?>> Dancing
                <?php echo '<span class="input_err" id="hobby_err">'. $hobbyErr. '</span>' ?>
            </div>


            <div class="form-group mb-3">
                <label for="file" class="form-label">Upload File : </label>
                <input id="file" type="file" name="file" value="<?php echo $file; ?>" />
                <?php echo '<span class="input_err" id="file_err">'. $fileErr. '</span>' ?>
            </div>
            <button type="submit" value="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
            <p style="display: inline-block;">I have an account <a href="login.php">Login Here!</a></p>
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

    function checkEmail(emailValue) {

        $.ajax({
            method: "POST",
            url: "reg-check-email.php",
            data: {
                email: emailValue
            },
            success: function(data) {
                $('#email_err').html(data);
            }
        });
    }

    function checkPhone(phoneValue) {
        $.ajax({
            method: "POST",
            url: "reg-check-phone.php",
            data: {
                phone: phoneValue
            },
            success: function(data) {
                $('#phone_err').html(data);
            }
        });
    }

    var form = document.getElementById('registerForm');
    var firstname = document.getElementById('firstname');
    var lastname = document.getElementById('lastname');
    var email = document.getElementById('email');
    var phone = document.getElementById('phone');
    var password = document.getElementById('password');
    var conf_pass = document.getElementById('conf_pass');
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
    var conf_pass_err = document.getElementById('conf_pass_err');
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
        var conf_passValue = conf_pass.value.trim();
        var stateValue = city.value;
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
            setErrorFor(password_err, 'Enter valid password must be 6 char.');
            flag = true;
        } else {
            setSuccessFor(password_err);
        }

        if (conf_passValue == '') {
            setErrorFor(conf_pass_err, 'confirm password cannot be blank');
            flag = true;
        } else if (passwordValue != conf_passValue) {
            setErrorFor(conf_pass_err, 'Password not match!..');
            flag = true;
        } else {
            setSuccessFor(conf_pass_err);
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