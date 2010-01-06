<?php

/*
 * we use i18n using the t() function
 * 
 * t("some built-in text") => translated text
 * 
 * language can be selected using 2nd arg, e.g. t("text", "de");
 * 
 * additionally you can define global variable $LANGUAGE with default setting
 * 
 * if nothing is set, built-in language is used
 */



// translate text to default language or specify language
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
				return "$text";
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
						return "$text";
					}
			}
	}


// translate text and substitute tokens in printf() syntax
function t_replace($text, $language) // following args for printf() not listed here!
	{
		$text = t($text, $language);
        $args = func_get_args();
        
        if (count($args)>2)
            {
                // ignore arguments 1 and 2 and let printf() do the rest
                array_shift($args);array_shift($args);
                return vsprintf($text, $args);
            }
        else
            {
                // no special args given, ordinary output (no diff to t())
                return $text;
            }
    }


?>
