<?php
include('../db_conn.php');



$columns = array(
        0 => 'id',
        1 => 'firstname',
        2 => 'lastname',
        3 => 'email',
        4 => 'phone',
        6 => 'gender',
        7 => 'state_name',
        8 => 'cityname',
        9 => 'hobby',
        10 => 'file',
    );

    $sql = "SELECT * from user";
    $query = $conn->query($sql);

    $allData = mysqli_num_rows($query);
    $filterData = $allData;

    $sql =" SELECT user.id, user.firstname, user.lastname, user.email, user.phone, user.gender, 
        state.state_name, cities.cityname, user.hobby, user.file, user.status FROM `user` 
        INNER JOIN state on user.state=state.id 
        INNER JOIN cities on user.city=cities.id ";
 
    if(!empty($_REQUEST['search']['value']) ) {   
        $sql .= " WHERE ( firstname LIKE '%".$_REQUEST['search']['value']."%' ";    
        $sql .= " OR lastname LIKE '%".$_REQUEST['search']['value']."%' ";
        $sql .= " OR email LIKE '%".$_REQUEST['search']['value']."%' ";
        $sql .= " OR phone LIKE '%".$_REQUEST['search']['value']."%' ";
        $sql .= " OR gender LIKE '%".$_REQUEST['search']['value']."%' ";
        $sql .= " OR state_name LIKE '%".$_REQUEST['search']['value']."%' ";
        $sql .= " OR cityname LIKE '%".$_REQUEST['search']['value']."%' ";
        $sql .= " OR hobby LIKE '%".$_REQUEST['search']['value']."%' ";
        $sql .= " OR file LIKE '%".$_REQUEST['search']['value']."%' )";
    }
    $query = $conn->query($sql);
    $allData = mysqli_num_rows($query);
    $sql .=  " ORDER BY ". $columns[$_REQUEST['order'][0]['column']]."   ".$_REQUEST['order'][0]['dir']."  LIMIT ".$_REQUEST['start']." ,".$_REQUEST['length']." ";
    $query = $conn->query($sql);
    $final = array();

	while( $row = mysqli_fetch_array($query) ) { 
        $status = ($row['status']) ? "checked" : " ";
        $data=array();
		$data[] = $row[0];
		$data[] = $row[1];
		$data[] = $row[2];
		$data[] = $row[3];
		$data[] = $row[4];
		$data[] = $row[5];
		$data[] = $row[6];
		$data[] = $row[7];
		$data[] = $row[8];
		$data[] = '<img alt="" src="../images/'.$row['file'].'" width="100px" height="100px" style="object-fit: cover;" />';
        $data[] = '<div class="form-group">
                        <div class="custom-control custom-switch">
                        <label class="switch">
                        <input type="checkbox" id="'.$row['id'].'" '.$status.' name="status" class="status">
                        <div class="slider round">
                        </div>
                        </label>
                            <span class="show_status">
                            </span>
                        </div>
                    </div>';
		$data[] = '<a href="update.php?id='.$row['id'].'" type="button" class="btn btn-primary btn-sm m-2">Edit</a>
                    <a href="delete.php?id='.$row['id'].'" type="button" class="btn btn-danger btn-sm m-2" 
                    onclick="return confirm(\'Are you sure you want to delete this product ?\')" >Delete</a>';
        $final[] = $data;
	}	

	$json_data = array(
		"draw"            => intval( $_REQUEST['draw'] ),   
		"recordsTotal"    => intval( $allData ),  
		"recordsFiltered" => intval($filterData),
		"data"            => $final
	);

	echo json_encode($json_data);

?>