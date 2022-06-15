<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
    </style>
</head>

<body>
    <?php
    session_start();
    include('../db_conn.php');

    $currentAdminEmail= $_SESSION['admin_email'];
    if(!isset($currentAdminEmail)){
        header("location:login.php");
    }
    
    if(isset($_GET['LoginSuccess']) == true){
        echo '<div class="alert alert-success" role="alert">'. $_GET['LoginSuccess'] .'</div>';
    }
    if(isset($_GET['Delete']) == true){
        echo '<div class="alert alert-success" role="alert">'. $_GET['Delete'] .'</div>';
    }
    if(isset($_GET['Update']) == true){
        echo '<div class="alert alert-success" role="alert">'. $_GET['Update'] .'</div>';
    }

    ?>
    <div class="container text-center">
        <h2>Admin Panel</h2>
        <h4>List of Users</h4>
        <a type="button" class="btn btn-primary mb-4" href="logout.php?logout">Logout</a>
        <a type="button" class="btn btn-primary mb-4" href="pagination.php">Pagination</a>
        <div class="col-md-12">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>User Id</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Hobbies</th>
                        <th>Profile Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            "sScrollX": '100%',
            "sScrollY": '300px',
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "data.php",
                type: "POST",
            }
        });
    });

    $(document).ready(function() {
        $(document).on('click', '.status', function() {
            var id = $(this).attr('id');
            var checkBox = document.getElementById(id);
            var status = (checkBox.checked) ? 1 : 0;
            var msg = (checkBox.checked) ? 'Active' : 'Disabled';
            $.post('status.php', {
                    id: id,
                    status: status
                },
                function(id, status, jqXHR) {
                    $(".show_status").html(id, status);
                });
        });
    });
    </script>
</body>

</html>