<?php

/*微信接入*/
class Weixin extends CI_Controller {

public function __construct() {
                parent::__construct();
                 $this->load->database();
                 $query = $this->db->get('wechat_config');
                   $data=$query->result_array();
           
                        $params = array(
                                'token'=>$data[0]['token'], 
                                // 'encodingaeskey'=>$data[0]['encodingaeskey'],
                                'appid'=>$data[0]['appid'], 
                                'appsecret'=>$data[0]['appsecret'], 
                        );
                 //这个$params必须在构造函数传参，因为类库在构造函数中$this->appid = isset($params['appid'])?$params['appid']:'';
                $this->load->library('wechat',$params);
                 $this->load->model('Api_model');
                  $this->load->library('session');
                 
            }


   public function index (){
                $this->wechat->valid();
                $type=$this->wechat->getRev()->getRevType();
                switch($type) {
                        case Wechat::MSGTYPE_TEXT:
                               $this->words();
                                exit;
                                break;
                        case Wechat::MSGTYPE_EVENT:
                            
                                 $this->shijian();
                                exit;
                                break;
                        case Wechat::MSGTYPE_IMAGE:
                                $this->wechat->text("hello, I'm 图片哈哈充电")->reply();
                                exit;
                                break;

                        default:
                                $this->wechat->text("我是未知哈哈充电")->reply();
                              }

                           }
 



 /*关键词回复*/
   public function words(){
             
                  $this->wechat->text("我是未知哈哈充电")->reply();
       
      
     }

 /*事件*/

   public function shijian(){

                //openid    $openid=$this->wechat->getRevFrom();
                 $data=$this->wechat->getRevEvent();
                 if ($data['event']=='subscribe') {
                     $this->wechat->text("subscribe")->reply();

                     $openid=$this->wechat->getRevFrom();
                     $guanzhu = array("openid" => $openid, "type"=> true);                    
                     $fanhui=$this->Api_model->subscribe_api(json_encode($guanzhu));
                    $this->db->where('openid', $openid);
                    $data_subscribe = array('subscribe' => '1');
                   $this->db->update('wxuser', $data_subscribe);
          
                 }elseif ($data['event']=='unsubscribe') {
                     $this->wechat->text("unsubscribe")->reply();

                     $openid=$this->wechat->getRevFrom();
                     $guanzhu = array("openid" => $openid, "type"=> false);                    
                     $fanhui=$this->Api_model->subscribe_api(json_encode($guanzhu));                      
                      $this->db->where('openid', $openid);
                    $data_subscribe = array('subscribe' => '0');
                   $this->db->update('wxuser', $data_subscribe);
                   unset($_SESSION['openid']);
                      // $rs = file_put_contents('go_pdm_log.txt', var_export($fanhui, ture), FILE_APPEND);
                 }
 
                 
     }



 

}
