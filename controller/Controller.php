<?php
require '../db/Gateway.php';

class Controller {
    private $method;
    private $request;
    private $data;

    public function __construct($method, $request, $data){
      $this->method = $method;
      $this->request = $request;
      $this->data = $data;
      $this->gateway = new Gateway();
    }

    public function processRequest(){
      switch ($this->method) {
        case 'GET':
          if($this->request=="parks") {
            $response = $this->gateway->getParks();
          }else if($this->request=="facility_types"){
            $response = $this->gateway->getFacilityTypes();
          }else{
            $this->notFoundResponse();
          };
          break;
        case 'POST':
          if($this->request=="park_ids" && 
             property_exists($this->data, 'filters')){
            $response = $this->gateway->getParkIDs($this->data->{'filters'});
          }else{
            $this->notFoundResponse();
          }
          break;
        default:
          $this->notFoundResponse();
      }
      header('HTTP/1.1 200 OK');
      echo json_encode($response);
    }
    
    private function notFoundResponse(){
        header('HTTP/1.1 404 Not Found');
        die();
    }
}