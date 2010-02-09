<?php
/*
 *      include/header.inc
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

// start session to set user specific settings in $_SESSION
session_start();

// include files with important variables, alphabetically sorted
include_once("include/config.inc");
include_once("include/consts.inc");

// include library files with setups and functions, alphabetically sorted
include_once("include/db.inc");
include_once("include/functions.inc");
include_once("include/i18n.inc");
include_once("include/statusmsgs.inc");

// establish database connection
good_connect($MYSQL_SERVER, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DATABASE);


// user management
function logout()
	{
		unset($_SESSION['login'], $_SESSION['username']);
	}

if ($_GET['logout'])
	{
		logout();
		messages_add("<p>".t("Sie wurden erfolgreich ausgeloggt!")."</p>");
	}

if (($_POST['action']=="login") && ($username=$_POST['username']) && ($password=$_POST['password']))
	{
		$user = good_query_assoc("SELECT id, username, rights FROM users WHERE username='$username' AND password=SHA1(CONCAT('$password', salt))");
		
		if ($user['username']==$username)
			{
                $_SESSION['id']=$user['id'];
				$_SESSION['username']=$username;
                $_SESSION['rights']=$user['rights'];
				$_SESSION['login']=true;
			}
		else
			{
				logout();
				messages_add("<p>".t("Einloggen fehlgeschlagen! Falscher Benutzername oder falsches Passwort!")."</p>", "error");
			}
	}
// throw out user if idle for too long ($MAX_IDLE_TIME==0 -> ignore)
elseif ($_SESSION['login'] and $_SESSION['time_last_request'] and ((mktime()-$_SESSION['time_last_request'])>$MAX_IDLE_TIME)  and ($MAX_IDLE_TIME>0))
	{
		logout();
		messages_add("<p>".t("Sie haben die maximale Idle-Zeit von $MAX_IDLE_TIME Sekunden überschritten und wurden automatisch ausgeloggt!")."</p>", "warn");
	}


// XHTML header
echo '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">';
echo "<title>" . t($PAGE_TITLE) . "</title>
</head>";

// include stylesheet for layout being nice & shiny
echo '<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">';
echo '<link rel="stylesheet" media="screen" type="text/css" href="css/screen.css">';

echo '<body>';

if ($_SESSION['login'])
	{
		echo '<div style="float:left;">'.t("Eingeloggt als ").$_SESSION['username'].' &middot; ';
		echo '<a href="'.url_add_parameter($_SESSION['REQUEST_URI'],"logout","true").'">'.t("Ausloggen").'</a></div>';
		
	}

// add div area with language links
echo '<div id="language">'.t("Sprache wählen").":";
foreach ($AVAILBLE_LANGUAGES as $language => $locales)
	{
		if ($language == $_SESSION['language'])
		{
			echo " $language";
		}
		else
		{
			echo ' <a href="'.url_add_parameter($_SERVER['REQUEST_URI'],"language",$language).'">'.$language.'</a>';
		}
	}
echo '</div>';

echo '<div style="clear:both;"><a href="http://www.github.com/dboehmer/hotelres/"><img src="images/logo_small.png" style="margin:8pt;float:left;" /></a>';
echo '<h1><a href="index.php">Hotelres '.$HOTEL_NAME.'</a></h1></div>';

// main navigation bar
echo '<div style="clear:both"><a href="index.php">Start</a>
	    <a href="booking.php">Reservierung</a>
	    <a href="schedule.php">Belegungsplan</a>
        <a href="usermgmt.php">Benutzerverwaltung</a>
		<a href="room.php">Zimmerverwaltung</a>
	    <a href="imprint.php">Impressum</a>
	    </div>';


// main headline on the website -- $PAGE_HEADLINE *must* be defined in the .php file!
echo "<h2>" . t($PAGE_HEADLINE) . "</h2></div>";


// show any information posted from code above
messages_show();


// user login form if not logged in yet
if (!$_SESSION['login'])
	{
		// show login form
		echo "<h1>".t("Bitte einloggen")."</h1>";
		
		echo "<p>".t("Sie sind nicht eingeloggt. Um auf die Daten zugreifen zu können
		oder Änderungen vorzunehmen, müssen Sie Benutzernamen und Passwort eingeben.")."</p>";
		echo '<form action="'.$_SESSION['REQUEST_URI'].'" method="post">
            <input type="hidden" name="action" value="login"><table>';
		echo '<tr><th>'.t("Benutzername").':</th><td><input type="text" name="username"></td></tr>';
		echo '<tr><th>'.t("Passwort").':</th><td><input type="password" name="password"></td></tr>';
		echo '</table><input type="submit" value="'.t("Einloggen").'"></form>';
		include("include/footer.inc");
		exit;
	}

?>

