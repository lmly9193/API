<?php
	require_once 'class.JavaScriptPacker.php';
	
	function d($url){
		$url = strrev($url);
		for($c=1;$c<=6;$c++){
			$url = base64_decode(strrev($url));
		}
		$id = strrev($url);
		JsPacker($id);
	}
	
	function JsPacker($id){
		// warning
		$dev = "console.log('%c[警告] 你正在使用開發人員專用介面，操作不當可能會令你暴露在危險之中！\\n記憶體用量: ".memory_get_usage()." (byte)','color:red');";
		// main
		$videoContainer = "var playerInstance=jwplayer('videoContainer');playerInstance.setup(".setup($id).");".$dev;
		$JSpacker = new JavaScriptPacker($videoContainer,62,true,false);
		$JSpacked = $JSpacker->pack();
		echo $JSpacked;
	}
	
	function setup($id){
		$result = request($id);
		$setup = array(
			'image'=>'https://drive.google.com/thumbnail?authuser=0&sz=w720&id='.$id,
			'sources'=>$result,
			'height'=>'100%',
			'width'=>'100%',
			'skin'=>array(
				'name'=>'tube',
				'active'=>'red',
				'inactive'=>'white'
			)
		);
		$setup = json_encode($setup,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		return $setup;	//return
	}
	
	function request($id){
		$url = 'https://videoapi.io/api/getlink?key=06a622ce5607438ee71cac55045c490a&link=https://drive.google.com/file/d/'.$id.'/view';
		$head = array('Connection: keep-alive','Keep-Alive: 300','Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7','Accept-Language: en-us,en;q=0.5');
		$ch = @curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch,CURLOPT_ENCODING,'gzip');
		curl_setopt($ch,CURLOPT_HTTPHEADER,$head);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_TIMEOUT,15);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,15);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
		$result = curl_exec($ch);
		curl_close($ch);
		
		$result_arr = json_decode($result,true);
		if(empty($result_arr)){
			return $result_arr;	//return
		}else{
			$result_arr = json_decode($result,true);	//decode json
			//$result_arr = array_reverse($result_arr);	//reverse
			foreach($result_arr as &$value){
				//delete api//
				$parse_query = parse_url($value['file'],PHP_URL_QUERY);
				parse_str($parse_query,$value['file']);
				unset($value['file']['api']);
				$query = http_build_query($value['file']);
				$value['file'] = urldecode('https://redirector.googlevideo.com/videoplayback?'.$query);
				
				// default 720p
				if($value['label'] == 720){
					$value['default'] = 'true';
				}else{
					$value['default'] = 'false';
				}
			}
			return $result_arr;	//return
		}
	}