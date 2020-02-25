<?php
include_once("dbh.php");

$query = "(SELECT ParkID, parks.Name, Washrooms, StreetNumber, StreetName, GoogleMapDest,
  FacilityType FROM parks join parks_facilities using(ParkID)) 
  union (SELECT ParkID, parks.Name, Washrooms, StreetNumber, StreetName, GoogleMapDest, 
  null as FacilityType from parks where facilities='N') order by ParkID,FacilityType";
$result = mysqli_query($conn, $query);

$rows = array();
$prev = null;
while ($row = mysqli_fetch_assoc($result)){
    if($prev != $row['ParkID']){
      $comma = strpos($row['GoogleMapDest'], ',');
      
      $arr = array();
      $arr['id'] = $row['ParkID'];
      $arr['name'] = $row['Name'];
      $arr['washrooms'] = $row['Washrooms'];
      $arr['address'] = $row['StreetNumber']." ".$row['StreetName'];
      $arr['lat'] = substr($row['GoogleMapDest'], 0, $comma);
      $arr['lng'] = substr($row['GoogleMapDest'], $comma+1);
      $arr['facilities'] = array();
      $prev = $row['ParkID'];
      array_push($rows, $arr);
    }
    
    if(strlen($row['FacilityType'])>0)
      array_push($rows[count($rows)-1]['facilities'], $row['FacilityType']);
}

echo json_encode($rows);
