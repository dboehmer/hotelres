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

// add div area with language links
echo '<div id="language">';
$langs=array(
		"de" => "Deutsch",
		"en" => "English");
foreach ($langs as $lang => $language)
	{
		if ($lang == $_SESSION['language'])
			echo "$language ";
		else
			echo '<a href="'.url_add_parameter($_SERVER['REQUEST_URI'],"language",$lang).'">'.$language.'</a> ';
	}
echo '</div>';

echo '<div><a href="index.php"><img src="images/logo_small.png" /></a>';

// main navigation bar
echo '<div><a href="index.php">Start</a>
	    <a href="booking.php">Reservierung</a>
	    <a href="schedule.php">Belegungsplan</a>
	    <a href="imprint.php">Impressum</a>
	    </div>';


// main headline on the website -- $PAGE_HEADLINE *must* be defined in the .php file!
echo "<h1>" . t($PAGE_HEADLINE) . "</h1></div>";

?>

