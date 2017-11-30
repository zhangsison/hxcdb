<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token
{




 public function access_token() 
{
               

	echo "string";
	// if(($time - $dateline) >= 7200) 
	// {
	// 	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
	// 	$ret_json = curl_get_contents($url);
	// 	$ret = json_decode($ret_json);
	// 	if($ret->access_token)
	// 	{
	// 		$data = array('access_token' => $ret->access_token,'access_token_expire' => $time);
	// 		$this->db->where('id', '1');
 //            $this->db->update('wechat_config', $data);
	// 	}
	// }
	// elseif(empty($access_token)) 
	// {
	// 	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
	
	// 	$ret_json = curl_get_contents($url);
	// 	$ret = json_decode($ret_json);
	// 	if($ret->access_token)
	// 	{
	// 		$data = array('access_token' => $ret->access_token,'access_token_expire' => $time);
	// 		$this->db->where('id', '1');
 //            $this->db->update('wechat_config', $data);
	// 	}
	// }
}
//  public function new_access_token($db) 
// {
// 	            $query = $this->db->get('wechat_config');
//                    $data=$query->result_array();
//                 $ret = array(
//                         'token'=>$data[0]['token'], 
//                         'encodingaeskey'=>$data[0]['encodingaeskey'],
//                         'appid'=>$data[0]['appid'], 
//                         'appsecret'=>$data[0]['appsecret'], 
//                 );
// 	$appid = $ret['appid'];
// 	$appsecret = $ret['appsecret'];
// 	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
// 	$ret_json = curl_get_contents($url);
// 	$ret = json_decode($ret_json);
// 	if($ret->access_token)
// 	{
// 		$data = array('access_token' => $ret->access_token,'access_token_expire' => $time);
// 			$this->db->where('id', '1');
//             $this->db->update('wechat_config', $data);
// 	}
// 	return $ret->access_token;
// }
//  public function curl_get_contents($url) 
// {
// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL, $url);
// 	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:26.0) Gecko/20100101 Firefox/26.0");
// 	curl_setopt($ch, CURLOPT_REFERER,$url);
// 	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
// 	$r = curl_exec($ch);
// 	curl_close($ch);
// 	return $r;
// }

}