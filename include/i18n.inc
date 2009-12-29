<?php

/*
 * we use i18n using the t() function
 * 
 * t("some english text") => translated text
 * 
 * language can be selected using 2nd arg, e.g. t("text", "de");
 * 
 * additionally you can define global variable $LANGUAGE with same content
 * 
 * if nothing is set, built-in language is used
 */


function t($text, $language=false)
	{
		if (!$language)
			{
				if ($_SESSION['language'])
					// lang globally set -> use this on
					$language=$_SESSION['language'];
				else
					// lang set nowhere -> use built-in
					$language="built-in";
			}
		
		if ($language == "built-in" or $language == "de")
			{
				return "built-in:$text";
			}
		else
			{
				// TODO find some translation system here
				if (false)
					{
						return "$language:SOMETHING";
					}
				else
					{
						return "fallback:$text";
					}
			}
	}


?>
