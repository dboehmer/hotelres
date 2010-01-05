<?php
include_once("include/config.inc");

// start session to set user specific settings in $_SESSION
session_start();

// change to another language if user clicked on language link
// if no language selected yet, try to get language from config.inc
if ($_GET['language'])
	{
		$_SESSION['language'] = $_GET['language'];
	}
elseif (!$_SESSION['language'] && $LANGUAGE)
	{
		$_SESSION['language'] = $LANGUAGE;
	}

// include library files with setups and functions, alphabetically sorted
include_once("include/db.inc");
include_once("include/functions.inc");
include_once("include/i18n.inc");


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
		$msg .= t("Sie wurden erfolgreich ausgeloggt!");
	}

if (($username=$_POST['username']) && ($password=$_POST['password']))
	{
		@list($user_exists) = good_query_list("SELECT username FROM users WHERE username='$username' AND password=SHA1(CONCAT('$password', salt))");
		
		if ($user_exists)
			{
				$_SESSION['username']=$username;
				$_SESSION['login']=true;
			}
		else
			{
				logout();
				$msg .= t("Einloggen fehlgeschlagen! Falscher Benutzername oder falsches Passwort!");
			}
	}
// throw out user if idle for too long ($MAX_IDLE_TIME==0 -> ignore)
elseif ($_SESSION['login'] and $_SESSION['time_last_request'] and ((mktime()-$_SESSION['time_last_request'])>$MAX_IDLE_TIME)  and ($MAX_IDLE_TIME>0))
	{
		logout();
		$msg .= t("Sie haben die maximale Idle-Zeit von $MAX_IDLE_TIME Sekunden überschritten und wurden automatisch ausgeloggt!");
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
echo '<link rel="stylesheet" media="screen" type="text/css" href="css/screen.css">';

echo '<body>';

if ($_SESSION['login'])
	{
		echo '<div style="float:left;">'.t("Eingeloggt als ").$_SESSION['username'].' &middot; ';
		echo '<a href="'.url_add_parameter($_SESSION['REQUEST_URI'],"logout","true").'">'.t("Ausloggen").'</a></div>';
		
	}

// add div area with language links
echo '<div id="language">'.t("Sprache wählen").":";
$langs=array(
		"de" => "Deutsch",
		"en" => "English");
foreach ($langs as $lang => $language)
	{
		if ($lang == $_SESSION['language'])
			echo " $language";
		else
			echo ' <a href="'.url_add_parameter($_SERVER['REQUEST_URI'],"language",$lang).'">'.$language.'</a>';
	}
echo '</div>';

echo '<div style="clear:both"><a href="index.php"><img src="images/logo_small.png" style="float:left;margin:8pt;" /></a>';
echo '<h1>Hotelres Burj Al Arab</h1></div>';

// main navigation bar
echo '<div style="clear:both"><a href="index.php">Start</a>
	    <a href="booking.php">Reservierung</a>
	    <a href="schedule.php">Belegungsplan</a>
	    <a href="imprint.php">Impressum</a>
	    </div>';


// main headline on the website -- $PAGE_HEADLINE *must* be defined in the .php file!
echo "<h2>" . t($PAGE_HEADLINE) . "</h2></div>";


// user login form if not logged in yet
if (!$_SESSION['login'])
	{
		echo "<h1>".t("Bitte einloggen")."</h1>";
		
		// show message provided from login/logout scripts above
		if ($msg)
			echo "<p>$msg</p>";
		
		// show login form
		echo "<p>".t("Sie sind nicht eingeloggt. Um auf die Daten zugreifen zu können
		oder Änderungen vorzunehmen, müssen Sie Benutzernamen und Passwort eingeben.")."</p>";
		echo '<form action="'.$_SESSION['REQUEST_URI'].'" method="post"><table>';
		echo '<tr><th>'.t("Benutzername").':</th><td><input type="text" name="username"></td></tr>';
		echo '<tr><th>'.t("Passwort").':</th><td><input type="password" name="password"></td></tr>';
		echo '</table><input type="submit" value="'.t("Einloggen").'"></form>';
		include("include/footer.inc");
		exit;
	}

?>

