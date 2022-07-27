<?php

$con = mysqli_connect("localhost", 'root', '', 'demo');
if (!$con) {
    die('Not connected : ' . mysqli_connect_error());
}

$id = $_GET['id'];

// update location with location_status if admin location_status.
$sqldata = mysqli_query($con, "
        select *
        from agenda where id_location = '$id'
        ");

$data =mysqli_fetch_all($sqldata,MYSQLI_ASSOC);


$rows = array();
while ($r = mysqli_fetch_assoc($sqldata)) {
    $rows[] = $r;
}
$indexed = array_map('array_values', $rows);
//  $array = array_filter($indexed);



echo json_encode($data);
if (!$rows) {
    return null;
}


// $mysqli = new mysqli("localhost", "root", "", "demo");

// if ($mysqli->connect_errno) {
//   echo "Failed to connect to MySQL: " . $mysqli->connect_error;
//   exit();
// }

// $sql = " select * from agenda where id_location = '$id'";
// $result = $mysqli->query($sql);

// // Fetch all
// $result->fetch_all(MYSQLI_ASSOC);


// // Free result set
// $result->free_result();
// echo $result;


// $mysqli -> close();