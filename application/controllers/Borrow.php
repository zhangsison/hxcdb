<?php

class Borrow extends CI_Controller {
 public function __construct(){
        parent::__construct();
                 $this->load->model('Oauth_model');
                  $appid=$this->Oauth_model->appid();          
                 $params = array('appid'=>$appid[0]['appid'], 'appsecret'=>$appid[0]['appsecret'], );            
                $this->load->library('jssdk',$params);
                  if($this->session->userdata('openid') == '') {
                   redirect('home/index');
               }
    }




       /*借充电宝*/
   public function index (){
             $jssdk =$this->jssdk->getSignPackage();
           $data['jssdk']=$jssdk;
          $this->load->view('borrow.html', $data);
        }
         /*还电宝*/
         public function huan (){         
             $jssdk =$this->jssdk->getSignPackage(); 
              $data['jssdk']=$jssdk; 
          $this->load->view('huan.html', $data);


        }
 
}
