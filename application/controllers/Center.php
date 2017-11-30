<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Center extends CI_Controller {


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

    /*个人中心*/
   public function index (){
 
      $get_openid=$this->session->userdata('openid');      
      if ($get_openid) {
      $data=$this->Oauth_model->wxuser_openid($get_openid);
      }else{
      $data=$this->Oauth_model->getopenid();
      }

      $jssdk =$this->jssdk->getSignPackage();

      $data['jssdk']=$jssdk;

        $this->load->view('account/index.html',$data);

        }

      /*个人中心-押金充值*/
      public function czyj(){
      $jssdk =$this->jssdk->getSignPackage();
      $data['jssdk']=$jssdk;
      $this->load->view('account/czyj.html',$data);
      }

    
      /*个人中心-充值金额*/

      public function recharge(){

      $this->load->view('account/recharge.html');
      }

      /*个人中心-体现页面*/
      public function withdrawal(){

      $this->load->view('account/withdrawal.html');
      }

      /*个人中心-优惠券*/
      public function coupon(){

      $this->load->view('account/coupon.html');
      }
        /*个人中心-交易明细*/
      public function fundsflow(){

      $this->load->view('account/fundsflow.html');
      }

            /*个人中心-我的订单*/
      public function order(){

      $this->load->view('account/order.html');
      }


}
