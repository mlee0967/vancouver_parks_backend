<?php
include_once("dbh.php");

$query = "select distinct FacilityType from parks_facilities order by FacilityType";
$result = mysqli_query($conn, $query);

$rows = array();
$prev = null;
while ($row = mysqli_fetch_assoc($result)){
  array_push($rows, $row['FacilityType']);
}
array_push($rows, "Washrooms");

echo json_encode($rows);
