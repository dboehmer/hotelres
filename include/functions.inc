<?php

function url_add_parameter($url, $parameter, $value)
	{
		// Pick the correct separator to use
		$separator = "?";
		if (strpos($url,"?")!==false)
		  $separator = "&";
		 
		// Find the location for the new parameter
		$insertPosition = strlen($url); 
		if (strpos($url,"#")!==false)
		  $insertPosition = strpos($url,"#");
		 
		// Build the new url
		$newUrl = substr_replace($url,"$separator$parameter=$value",$insertPosition,0);
		
		return($newUrl);
	}


?>
