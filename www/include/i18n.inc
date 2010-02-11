<?php
/*
 *      include/i18n.inc
 *      
 *      Copyright 2010 Daniel Böhmer <daniel.boehmer@it2007.ba-leipzig.de> and
 *                     Patrick Nicolaus <patrick.nicolaus@it2007.ba-leipzig.de>
 *      
 *      This file is part of Hotelres.
 * 
 *      Hotelres is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      Hotelres is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */


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



// INITIALIZATION CODE RUN A STARTUP

// change to another language if user clicked on language link
// if no language selected yet, try to get language from config
if ($_GET['language'])
    {
        $_SESSION['language'] = $_GET['language'];
    }
elseif (!$_SESSION['language'] && $DEFAULT_LANGUAGE)
    {
        $_SESSION['language'] = $LANGUAGE;
    }

setlocale(LC_ALL, $AVAILABLE_LANGUAGES[$LANGUAGE]);



// USEFUL FUNCTIONS

// translate text to default language or specify language
function t($text, $language=false)
	{
        global $BUILTIN_LANGUAGE, $DEBUG;
        
		if (!$language)
			{
				if ($_SESSION['language'])
					// lang globally set -> use this one
					$language=$_SESSION['language'];
				else
					// lang set nowhere -> use built-in
					$language=$BUILTIN_LANGUAGE;
			}
        
		if ($language == $BUILTIN_LANGUAGE)
			{
				if ($DEBUG)
                    return "built-in:$text";
                else
                    return $text;
			}
		else
			{
				// TODO find some translation system here
				if ($translation[$language][$text])
					{
                        if ($DEBUG)
                            return "$language:".$translation[$language][$text];
                        else
                            return $translation[$language][$text];
					}
                else
					{
                        if ($DEBUG)
                            return "fallback:$text";
                        else
                            return $text;
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
