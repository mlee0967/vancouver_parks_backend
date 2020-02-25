<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("dbh.php");

$data = json_decode((file_get_contents('php://input')));
$query = "(select distinct ParkID from parks_facilities)";
$arr = $data->{'filters'};
foreach($arr as $filter){
  if($filter=="Washrooms")
    $query = $query." intersect (select ParkID from parks where Washrooms='Y')";
  else
    $query = $query." intersect (select ParkID from parks_facilities where FacilityType='$filter')";
} 
$result = mysqli_query($conn, $query);

$rows = array();
$prev = null;
while ($row = mysqli_fetch_assoc($result)){
  array_push($rows, $row['ParkID']);
}

echo json_encode($rows);