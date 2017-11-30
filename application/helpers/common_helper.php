<?php
header("content-type:text/html;charset=utf-8");
/**
 * 获取微信操作对象
 * @staticvar array $wechat
 * @param type $type
 * @return WechatReceive
 */
function & load_wechat($type = '') {
 	static $wechat = array();
    $index = md5(strtolower($type));
    if (!isset($wechat[$index])) {
        $CI = & get_instance();
        $CI->db->reset_query();
        $CI->db->select('token,appid,appsecret,encodingaeskey,mch_id,partnerkey,ssl_cer,ssl_key,qrc_img');
        // $options = array(
        //     'token'           => '', // 填写你设定的key
        //     'appid'           => '', // 填写高级调用功能的app id, 请在微信开发模式后台查询
        //     'appsecret'       => '', // 填写高级调用功能的密钥
        //     'encodingaeskey'  => '', // 填写加密用的EncodingAESKey（可选，接口传输选择加密时必需）
        //     'mch_id'          => '', // 微信支付，商户ID（可选）
        //     'partnerkey'      => '', // 微信支付，密钥（可选）
        //     'ssl_cer'         => '', // 微信支付，双向证书（可选，操作退款或打款时必需）
        //     'ssl_key'         => '', // 微信支付，双向证书（可选，操作退款或打款时必需）
        //     'cachepath'       => '', // 设置SDK缓存目录（可选，默认位置在Wechat/Cache下，请保证写权限）
        // );
        // 读取SDK动态配置
        $config = $CI->db->get('wechat_config')->first_row('array');
        // 设置SDK缓存路径
        $config['cachepath'] = CACHEPATH . 'data/';
        $wechat[$index] = \Wechat\Loader::get_instance($type, $config);
    }
    return $wechat[$index];
}

