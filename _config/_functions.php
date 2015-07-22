<?php

	function excerpt($text)
	{	

		if(strpos($text,'{% excerpt %}') !== false)
			$excerpt =  str_replace("{% excerpt %}","",strstr($text,'{% end excerpt %}',true));
		else
		{
			$start = "<p>";
			$end = "</p>";
			$text = " ".$text;
		    $ini = strpos($text,$start);
		    if ($ini == 0) return "";
		    //$ini += strlen($start);
		    $len = strpos($text,$end,$ini) - $ini + strlen($end);
		    $excerpt = substr($text,$ini,$len);
		}
			

		if(strlen(trim($excerpt)) < 1)
			return false;
		else
			return $excerpt;
	}



	function Redirect($url, $permanent = false)
	{
	    if (headers_sent() === false)
	    {
	    	header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
	    }

	    exit();
	}

	function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

?>