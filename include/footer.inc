<?php

echo '<div id="footer"><p>&copy 2009 &ndash; 2010 by Daniel B&ouml;hmer, Patrick Nicolaus; IT2007</p></div>';

echo '</body>
</html>';


// save current timestamp for checking timeout at next request
$_SESSION['time_last_request'] = mktime();


?>
