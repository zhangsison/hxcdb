<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wxoauth {
  private $appid;
  private $appsecret; 

 
  public function __construct($params = array()){

     $appid = isset($params['appid'])?$params['appid']:'';
    $appsecret = isset($params['appsecret'])?$params['appsecret']:'';
    

    if(empty($appid) || empty($appsecret)){
      die('init fail');
    }
    //appid and appsecret
    $this->appid = $appid;
    $this->appsecret = $appsecret;
    
   
  }
 
/*跳转获取code*/
public function code()
{

            $back_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            $state = 'wechat';
            $scope = 'snsapi_userinfo';
            $redirect_uri = urlencode($back_url);
            $oauth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->appid . '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect';  

          return $oauth_url;
}

 /**
   * access_token  需要传入code
   */
public function access_token($code)
  {
   
  $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' .$this->appid . '&secret=' . $this->appsecret . '&code=' . $code . '&grant_type=authorization_code';
    $ret_oa_json =$this-> curl_get_contents($url);
    $ret_oauth = json_decode($ret_oa_json,true);
    return $ret_oauth;                          
   
  }




public function refresh_token($refresh_token)
  {
   
  $url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=' .$this->appid . '&grant_type=refresh_token&refresh_token=' .$refresh_token.'  ';
    $ret_oa_json =$this-> curl_get_contents($url);
    $ret_oauth = json_decode($ret_oa_json,true);
    return $ret_oauth;                          
   
  }


  /**
   * 授权获取用户信息 
   */
  public function get_userinfo($access_token,$openid){

  $sns_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
            $ret_sns_json =$this-> curl_get_contents($sns_url);
            $ret_sns = json_decode($ret_sns_json,true);
    return $ret_sns;

  }














public function goheader($oauth_url){
    header('Expires: 0');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-store, no-cahe, must-revalidate');
    header('Cache-Control: post-chedk=0, pre-check=0', false);
    header('Pragma: no-cache');
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $oauth_url");
    exit;
}


public function curl_get_contents($url)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_TIMEOUT, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
  curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  $r = curl_exec($ch);
  curl_close($ch);
  return $r;
}































}