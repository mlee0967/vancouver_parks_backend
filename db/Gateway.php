<?php
include "dbh.php";

class Gateway {
  private $conn;
  
  public function __construct(){
    $this->conn = mysqli_connect($GLOBALS["servername"], $GLOBALS["username"], 
      $GLOBALS["password"], $GLOBALS["database"]);
    if(mysqli_connect_errno()){
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
  }

  function __destruct(){
    mysqli_close($this->conn);
  }    

  public function getParks(){
    $query = "(select ParkID, parks.Name, Washrooms, StreetNumber, StreetName,
      GoogleMapDest, FacilityType FROM parks join parks_facilities using(ParkID)) 
      union (select ParkID, parks.Name, Washrooms, StreetNumber, StreetName, 
      GoogleMapDest, null as FacilityType from parks where facilities='N')
      order by ParkID,FacilityType";
    $result = mysqli_query($this->conn, $query);

    $rows = array();
    $prev = null;
    while ($row = mysqli_fetch_assoc($result)){
      if($prev != $row["ParkID"]){
        $comma = strpos($row["GoogleMapDest"], ",");

        $arr = array();
        $arr["id"] = $row["ParkID"];
        $arr["name"] = $row["Name"];
        $arr["washrooms"] = $row["Washrooms"];
        $arr["address"] = $row["StreetNumber"]." ".$row["StreetName"];
        $arr["lat"] = substr($row["GoogleMapDest"], 0, $comma);
        $arr["lng"] = substr($row["GoogleMapDest"], $comma+1);
        $arr["facilities"] = array();
        $prev = $row["ParkID"];
        array_push($rows, $arr);
      }

      if(strlen($row["FacilityType"])>0){
        array_push($rows[count($rows)-1]["facilities"], $row["FacilityType"]);
      }
    }

    return $rows;
  }

  public function getFacilityTypes(){
    $query = "select distinct FacilityType from parks_facilities order by FacilityType";
    $result = mysqli_query($this->conn, $query);

    $rows = array();
    $prev = null;
    while ($row = mysqli_fetch_assoc($result)){
      array_push($rows, $row["FacilityType"]);
    }
    array_push($rows, "Washrooms");

    return $rows;
  }

  public function getParkIDs($filters){
    $query = "select ParkID from parks ";
    for($i=0; $i<count($filters); ++$i){
      $filter = mysqli_real_escape_string($this->conn, $filters[$i]);
      if($i==0){
        $query .= "where ";
      }else{
        $query .= "and ";
      }

      if($filter=="Washrooms")
        $query .= "ParkID in (select ParkID from parks where Washrooms='Y') ";
      else
        $query .= "ParkID in (select ParkID from parks_facilities where FacilityType='$filter') ";
    }

    $result = mysqli_query($this->conn, $query);
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)){
      array_push($rows, $row["ParkID"]);
    }

    return $rows;
  }
}