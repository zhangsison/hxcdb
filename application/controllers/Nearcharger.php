<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nearcharger extends CI_Controller {

   public function index (){
            
                 $this->load->view('map/nearCharger.html');
        }


           public function location (){
            
                 $this->load->view('map/location.html');
        }
 
 public function place(){
            
                 $this->load->view('map/place.html');
        }


}
