<?php
	a($_SERVER['QUERY_STRING']);
	function a($id){
		$url = strrev($id);
		for($c=1;$c<=6;$c++){
			$url = strrev(base64_encode($url));
		}
		$url = strrev($url);
		header('Location: e.php?'.$url);
	}