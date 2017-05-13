<?php
	require_once 'class.JavaScriptPacker.php';
	
	function JsPacker($id){
		// open in newtab
		$open_new_tab = "playerInstance.addButton('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADdcAAA3XAUIom3gAAAAHdElNRQfhAhwOMiXdKXT8AAAAoUlEQVQoz4WRvRGCUBAGF4fhVWAVJIaWYTlWQTHKTwsSGZnSgKGZyRqA+MDn+GV3u3M3c4cHB6OA+7jOqdjSE+dBDwR2AKgXvmKwmyamBIOt2nlNChNuDV4SgsFmxJAQLKzVxgBg6X4hTLge8bs5Cxae1dpiZvEKC0/q+YPXwlE9xXgU8rmqgCp7ft8secnPhA1/kjmw5faDltxZv3uRwcMLdtjIVcxHYWwAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTctMDItMjhUMTQ6NTA6MzcrMDE6MDATThFcAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE3LTAyLTI4VDE0OjUwOjM3KzAxOjAwYhOp4AAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAAASUVORK5CYII=','在新視窗中開啟',function(){window.open('https://drive.google.com/file/d/'+playerInstance.getPlaylistItem()['mediaid']+'/preview','_blank');},'preview');";
		// downlaod buttom
		$downlaod_buttom = "playerInstance.addButton('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADdcAAA3XAUIom3gAAAAHdElNRQfhAhwOKDF33lpaAAAAbElEQVQoz72PoQ2AMBQFrwSBbMIAKCZgGRJGQTMKO7AECZ5hHoa2If0Fx8l3Zx5EdChwpLXigx+CGtQzAODj6jUCsLsTUKNNFpuacNBKkjaTp86SXD8SW8ekrO/kTVs40MJUsKuba6ClKwQtXHK6ch70HrrzAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDE3LTAyLTI4VDE0OjQwOjQ5KzAxOjAwiDq82AAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxNy0wMi0yOFQxNDo0MDo0OSswMTowMPlnBGQAAAAZdEVYdFNvZnR3YXJlAHd3dy5pbmtzY2FwZS5vcmeb7jwaAAAAAElFTkSuQmCC','下載',function(){window.open('https://docs.google.com/uc?id='+playerInstance.getPlaylistItem()['mediaid']+'&export=download','_blank');},'download');";
		// memory usage
		$memory_usage = "console.log('記憶體用量: ".memory_get_usage()." (byte)');";
		// warning
		$warning = "console.warn('%cMAMA LET ME TOLD YOU!!','font-size:40px;color:red');console.warn('%cDON\'T BE EVIL!!','font-size:60px;color:red');";
		// main
		$videoContainer = "var playerInstance=jwplayer('videoContainer');playerInstance.setup(".setup($id).");".$open_new_tab.$downlaod_buttom.$memory_usage.$warning;
		$JSpacker = new JavaScriptPacker($videoContainer,62,true,false);
		$JSpacked = $JSpacker->pack();
		echo $JSpacked;
	}
	
	
	function setup($id){
		$result = request($id);
		$setup = array(
			//'playlist'=>array(
				'mediaid'=>$id,
				'title'=>$result['title'],
				'image'=>'https://drive.google.com/thumbnail?authuser=0&sz=w720&id='.$id,
				'sources'=>$result['sources'],
			//),
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
		$url = 'https://videoapi.io/api/getlink?key=06a622ce5607438ee71cac55045c490a&link=https://drive.google.com/file/d/'.$id.'/view&return=data';
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
			//$result_arr['sources'] = array_reverse($result_arr['sources']);	//reverse
			foreach($result_arr['sources'] as &$value){
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