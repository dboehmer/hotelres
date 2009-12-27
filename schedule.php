<?php

$PAGE_TITLE='Belegungsplan';
$PAGE_HEADLINE='Belegungsplan';

include('include/header.inc');

?>


<h2>Sample</h2>



<?php

echo '<table><tr><th>Tag</th>';
for ($i=1; $i<=7; $i++)
    {
    echo "<th>$i.12.2009</th>";
    }


echo '</tr><tr><th>Belegung</th>';
for ($i=1; $i<=7; $i++)
    {
    echo "<td>" . ($i*3) . "%</td>";
    }

echo '</tr></table>';

include('include/footer.inc');

?>
