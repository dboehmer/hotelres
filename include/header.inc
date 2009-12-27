<?php

// TODO do session handling stuff here

// TODO do datebase stuff here

echo '<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">';
echo "<title>$PAGE_TITLE</title>
</head>";

echo '<link rel="stylesheet" type="text/css" href="css/screen.css">';

echo '<body>';

echo '<div><a href="index.php">Start</a>
	    <a href="booking.php">Reservierung</a>
	    <a href="schedule.php">Belegungsplan</a>
	    <a href="imprint.php">Impressum</a>
	    </div>';

echo '<div><a href="index.php"><img src="images/logo_small.png" /></a>';
echo "<h1>$PAGE_HEADLINE</h1></div>";

?>

