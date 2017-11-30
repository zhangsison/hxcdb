<?php
class Jsdk_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false ) {
                      redirect('welcome/index');
                 } 
      
    }



   public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);
  

    $signPackage = array(
      "appId"     => 'wxe3de10e7578c1566',
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 


  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
$data = $this->db->get('wechat_config')->result_array();
		$params = array(
                                                            
                                'jsapi_ticket'=>$data[0]['jsapi_ticket'], 
                                'jsapi_ticket_expire'=>$data[0]['jsapi_ticket_expire']
                        );
    if ($params['jsapi_ticket_expire'] < time()) {
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $jsapi_ticket = $ticket;
         $jsapi_ticket_expire= time() + 7000;
           $data = array(
                     'jsapi_ticket' => $jsapi_ticket,
                     'jsapi_ticket_expire' => $jsapi_ticket_expire
                  );
          $this->db->where('id', '1');
         $this->db->update('wechat_config', $data); 
      }
    } else {
      $ticket = $params['jsapi_ticket'];
    }

    return $ticket;
  }

  private function getAccessToken() {
  $data = $this->db->get('wechat_config')->result_array();
		$params = array(
                               
                                'appid'=>$data[0]['appid'], 
                                'appsecret'=>$data[0]['appsecret'], 
                                'access_token'=>$data[0]['access_token'], 
                                'access_token_expire'=>$data[0]['access_token_expire'], 
                                'jsapi_ticket'=>$data[0]['jsapi_ticket'], 
                                'jsapi_ticket_expire'=>$data[0]['jsapi_ticket_expire']
                        );
     
   if ($params['access_token_expire'] < time() or !$params['access_token_expire']) {
  $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$params['appid']."&secret=".$params['appsecret'];
   $res = json_decode($this->httpGet($url));
    $access_token = $res->access_token;
      if($access_token) {
            $access_token_expire= time() + 7000;
           $data = array(
                     'access_token' => $access_token,
                     'access_token_expire' => $access_token_expire
                  );
          $this->db->where('id', '1');
         $this->db->update('wechat_config', $data);      
       }

}else {
    $access_token = $this->params['access_token'];
  }

    return $access_token;
  }

  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }






}