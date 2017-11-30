<?php

class Menu extends CI_Controller {


public function __construct() {
                parent::__construct();
               $this->load->database();
                $this->load->model('Config_model');

            }

   public function caidan(){
           
            $access_token=$this->Config_model->token();

     
$jsonmenu = '{
      "button":[
      {
            "name":"借还",
           "sub_button":[
            {
               "type":"view",
                "name":"借充电宝",
                "url":"http://mpp.sohunjug.com/borrow"
            },
            {
              "type":"view",
                "name":"还充电宝",
                "url":"http://mpp.sohunjug.com/borrow/huan"
            }]
      

       }, 
        {	
          "type":"view",
                "name":"附近宝宝",
                "url":"http://mpp.sohunjug.com/home"
      },
       {
           "name":"更多",
           "sub_button":[
            {
              "type":"view",
                "name":"个人中心",
                "url":"http://mpp.sohunjug.com/center"
            },
            {
               "type":"view",
                "name":"押金/余额",
                "url":"http://mpp.sohunjug.com/center/withdrawal"
            },
            {
               "type":"view",
                "name":"常见问题",
                "url":"http://mpp.sohunjug.com"
            },
            {
               "type":"view",
                "name":"代理商合作",
                "url":"http://mpp.sohunjug.com"
            },
            {
               "type":"view",
                "name":"商家合作",
                "url":"http://mpp.sohunjug.com"
            }]
       

       }]
 }';
        
$token=$this->Config_model->caidan($jsonmenu,$access_token);

var_dump($token);

        }



 
}
