<?php
class Oauth_model extends CI_Model {



  public function __construct() {
  	            $this->load->database();
                   $this->load->helper('url');  
                 $query = $this->db->get('wechat_config');
                   $data=$query->result_array();
                        $params = array(
                               
                                'appid'=>$data[0]['appid'], 
                                'appsecret'=>$data[0]['appsecret'], 
                               
                        );
                 //这个$params必须在构造函数传参，因为类库在构造函数中$this->appid = isset($params['appid'])?$params['appid']:'';
                 $this->load->library('wxoauth',$params);
                  $this->load->helper('cookie');
                 $this->load->library('session');
                 
  }

    

/*获取个人信息*/

  public function getopenid()
    {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
             $code =$this->wxoauth->code();
             $this->wxoauth->goheader($code);
            exit();
        } else {
           
            $code = $_GET['code'];
            $datas = $this->wxoauth->access_token($code);
            $aouth = array(
                           'access_token'  => $datas['access_token'],
                           'refresh_token'  => $datas['refresh_token'],
                           'openid'  => $datas['openid']

                       );
            $this->load->helper('cookie');
            set_cookie("refresh_token",$datas['refresh_token'],2500000);
           $this->session->set_userdata($aouth);

            $access_token=$datas['access_token'];
            $openid=$datas['openid'];
                         
           	$uers = $this->wxoauth->get_userinfo($access_token,$openid);
            $nickname=$this->jsonName($uers['nickname']);
           	$data = array(

               'openid' => $uers['openid'] ,
               'nickname' =>$nickname,
               'sex' => $uers['sex'] ,
               'province' => $uers['province'] ,
               'city' => $uers['city'] ,
               'country' => $uers['country'] ,
               'headimgurl' => $uers['headimgurl'] 
            );
           $openid=$uers['openid'];
           $query = $this->db->query("select * from wxuser WHERE openid='$openid';")->result_array();

            if (!$query) {
            	 $this->db->insert('wxuser', $data);
            }
           

            return $uers;
        }
    }




/*过滤微信名称*/
public function jsonName($str) {
    if($str){
        $tmpStr = json_encode($str);
        $tmpStr2 = preg_replace("#(\\\ud[0-9a-f]{3})#ie","",$tmpStr);
        $return = json_decode($tmpStr2);
        if(!$return){
            return jsonName($return);
        }
    }else{
        $return = '微信用户-'.time();
    }    
    return $return;
}
 


/*判断微信浏览器*/
public function is_weixin(){ 
  if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
      return true;
  } 
  return false;
}

/*查询appid*/
public function appid(){ 
    $data = $this->db->query("select appid,appsecret from wechat_config WHERE id='1';")->result_array();
  return $data;
}




/*查询wxuser_openid*/
public function wxuser_openid($openid){ 
   $data = $this->db->query("select openid,nickname,headimgurl from wxuser WHERE openid='$openid';")->result_array();
  return $data[0];
}








}