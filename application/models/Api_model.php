<?php
class Api_model extends CI_Model {

  public function __construct() {
     $this->openid = $this->session->userdata('openid');

  }

/*通过openid换取token*/
  public function subscribe_api() {
  $url='http://sohunjug.com:8002/register';
  $data= array("openid" => $this->openid); 
  $dat =$this->http_post_json($url, json_encode($data));	
   return $dat;
  }


/*通过机器码换取借出*/

  public function lend_api($client) {

 $subscribe_api=json_decode($this->subscribe_api(),true);


$data = array("client" => $client); 
$token=$subscribe_api['token'];

$url='http://sohunjug.com:8002/api/lend';
$dat =$this->http_post_token($url,json_encode($data),$token);
   return $dat;
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


  private function https_request($url,$data){
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



 private function http_post_token($url, $data,$token){
   $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_HEADER, 0);
  curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
                'Content-Type: application/json; charset=utf-8',
                'x-access-token:' . $token,
                'Content-Length:' . strlen($data))
        );
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $res = curl_exec($curl);
  return  $res;
}


private function http_post_json($url, $data){
   
   $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_HEADER, 0);
  curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length:' . strlen($data))
        );
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $res = curl_exec($curl);
  return  $res;
}














}