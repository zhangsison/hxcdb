<?php


class Home  extends CI_Controller {

  public function __construct(){
        parent::__construct();
                  $this->load->model('Oauth_model');
                   $appid=$this->Oauth_model->appid();
                        $params = array(                              
                                'appid'=>$appid[0]['appid'], 
                                'appsecret'=>$appid[0]['appsecret'], 
                        );
                 //这个$params必须在构造函数传参，因为类库在构造函数中$this->appid = isset($params['appid'])?$params['appid']:'';
                $this->load->library('jssdk',$params);
                $this->load->model('Api_model');
               }

public function index(){


     $client=$this->uri->segment(3);

    
     
       $get_openid=$this->session->userdata('openid');
      
         if ($client) {
           echo "这是机器号".$client."机器位置获取经纬度";
         $this->Api_model->lend_api($client);

         }



      if ($get_openid) {
          $data=$this->Oauth_model->wxuser_openid($get_openid);
      }else{
        $data=$this->Oauth_model->getopenid();
      }

        $jssdk =$this->jssdk->getSignPackage();


             $data['jssdk']=$jssdk;
             $this->load->view('map/index.html', $data);

        }
 







}
