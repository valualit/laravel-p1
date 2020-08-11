<?php

namespace App\Services;

class Seranking { 
	
	private $token = null;
		
	function send($urlPath,$type="GET",$data=array()){
		if($this->token==null||$this->token==false){
			echo "SeRanking not workink Token!";
			exit();
		}
		//$data['token']=$this->token;
		$url = 'https://api4.seranking.com'.$urlPath;
		$curl = curl_init($url);
		curl_setopt_array($curl, [
			CURLOPT_HTTPHEADER => ['Authorization: Token '.$this->token],
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST =>true,
			CURLOPT_CUSTOMREQUEST =>$type,
			CURLOPT_POSTFIELDS=>json_encode($data)
		]);
		$content = curl_exec($curl);
		$info = curl_getinfo($curl);
		//var_dump($info,$content); exit();
		if (!$content && !in_array($info['http_code'],array(200,204))) {
				echo "Ошибка выполнения запроса!";
		} else {
			$result = json_decode($content);
			return $result;
		}
	}
	
	function __construct($token=null){
		$this->token = $token;
	}
	
	public function setToken($token=null){
		$this->token = $token;
	}
	
}
