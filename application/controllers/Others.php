<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Others extends CI_Controller {

public function __construct() {
                parent::__construct();          
                $this->load->model('Oauth_model');
                  $appid=$this->Oauth_model->appid();
                 $params = array('appid'=>$appid[0]['appid'], 'appsecret'=>$appid[0]['appsecret'], );            
                $this->load->library('jssdk',$params);
                if($this->session->userdata('openid') == '') {
                   redirect('home/index');
               }

            }
public function index(){
 
     
        $this->load->view('welcome_message');

        }

   public function question(){
      $jssdk =$this->jssdk->getSignPackage();
      $data['jssdk']=$jssdk;    
     $this->load->view('others/question.html',$data);
     }


       
           public function about (){
            $jssdk =$this->jssdk->getSignPackage();
             $data['jssdk']=$jssdk;
     
            $this->load->view('others/about.html',$data);
        }


}
