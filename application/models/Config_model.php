<?php
class Config_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

  
  public function configdata() {

      $query = $this->db->get('wechat_config');
      $data=$query->result_array();
      $params = array(
                                'token'=>$data[0]['token'], 
                                 'encodingaeskey'=>$data[0]['encodingaeskey'],
                                'appid'=>$data[0]['appid'], 
                                'appsecret'=>$data[0]['appsecret'], 
                                'access_token'=>$data[0]['access_token'], 
                                'access_token_expire'=>$data[0]['access_token_expire'], 
                                'jsapi_ticket'=>$data[0]['jsapi_ticket'], 
                                'jsapi_ticket'=>$data[0]['jsapi_ticket_expire']
                        );

    return $params;
  }


  public function token() {

      $query = $this->db->get('wechat_config');
      $data=$query->result_array();
      $params = array(
                                'token'=>$data[0]['token'], 
                                 'encodingaeskey'=>$data[0]['encodingaeskey'],
                                'appid'=>$data[0]['appid'], 
                                'appsecret'=>$data[0]['appsecret'], 
                                'access_token'=>$data[0]['access_token'], 
                                'access_token_expire'=>$data[0]['access_token_expire'], 
                                'jsapi_ticket'=>$data[0]['jsapi_ticket'], 
                                'jsapi_ticket'=>$data[0]['jsapi_ticket_expire']
                        );

if ($params['access_token_expire'] < time() or !$params['access_token_expire']) {
  $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$params['appid']."&secret=".$params['appsecret'];
   $res =$this->getJson($url);
    $access_token = $res['access_token'];
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
    $access_token = $params['access_token'];
  }

    return $access_token;
  }






public function caidan($data,$access_token){
$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
 $jsonmenu=$this->https_request($url, $data);

return $jsonmenu;
}





public function shanchu($access_token){
$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$access_token;
 $jsonmenu=$this->https_request($url);

return $jsonmenu;
}













public function getJson($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE); 
  curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE); 
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  $output = curl_exec($ch);
  curl_close($ch);
  return json_decode($output,true);
}


public function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}



}