<?php
/**
 * 基于互易无限api的短信类
 * 时间：2016年6月29日11:15:13
 * author：soul
 */

Class MessageSend{

	const API_URL = 'http://106.ihuyi.com/webservice/sms.php?method=Submit';

	private $account;
	private $password;

	function __construct($account_new,$password_new){
		$this->account = $account_new;
		$this->password = md5($password_new);
	}

	public function send($content=null,$mobile=null){
		$response = false;
		if(!empty($content)&&!empty($mobile)){
		$post_data = "account=".$this->account."&password=".$this->password."&mobile=".$mobile."&content=".rawurlencode($content);
    	$get = self::Post($post_data,self::API_URL);
    	$response = self::xml_to_array($get);
    	}
    	return $response;
	}

	/**
	 * CURL请求初始化函数
	 * @param [type] $curlPost [description]
	 * @param [type] $url      [description]
	 */
	public static function Post($curlPost,$url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
	}

	/**
	 * 将API反馈到的XML数据转换为数组
	 * @param  [type] $xml [description]
	 * @return [type]      [description]
	 */
	public static function xml_to_array($xml){
	    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
	    if(preg_match_all($reg, $xml, $matches)){
	        $count = count($matches[0]);
	        for($i = 0; $i < $count; $i++){
	        $subxml= $matches[2][$i];
	        $key = $matches[1][$i];
	            if(preg_match( $reg, $subxml )){
	                $arr[$key] = self::xml_to_array( $subxml );
	            }else{
	                $arr[$key] = $subxml;
	            }
	        }
	    }
	    return $arr;
	}
}


?>