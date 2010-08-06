<?php
/*
 *      www/statistics.php
 *      
 *      Copyright 2010 Daniel Böhmer <daniel.boehmer@it2007.ba-leipzig.de> and
 *                     Patrick Nicolaus <patrick.nicolaus@it2007.ba-leipzig.de> and
 *					   Tarik Alchanaa<tarik.alchanaa@it2007.ba-leipzig.de>
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



$PAGE_TITLE='Statistik';
$PAGE_HEADLINE='Statistik';

include('include/header.inc');


if (isset($_GET['year']) && ctype_digit($_GET['year'])) {
    $year= (int) $_GET['year'];
    }
else {
    $year = date('Y');
}
?>

<form method="get">
	<table>
        <tr>
        
        <td><?php echo t("Jahr");?>:</td>
          <td><select name="year" size="1">
          	<?php 
		
			for($i=2010; $i <= 2015; $i++)
			{
            	echo "<option value=\"".$i."\"";
                
                if ($year==$i)
                    echo ' selected="selected"';
                
                echo ">".$i."</option>";
           	}
			?>
           
	<input type="submit" value="<?php echo t("Anzeigen");?>"> </td></tr>
	</table>
    
    <p>
    <?php echo '<a href="?year='.($year-1).'">&lt;&lt; '.($year-1).'</a> <a href="?year='.($year+1).'">'.($year+1).' &gt;&gt;</a>'; ?>
    </p>
    
  
</form>
<br />



<?php

function Plot($NumBars, $ValArray, $NameArray, $ColorArray, $PxPerUnit, $year) {
    
    print "<table><tr><td>";  

    for ($i = 0; $i < $NumBars; $i++) {
        print "<table><tr><td>";
        print $NameArray[$i];
        print "</td></tr></table>";
    }

    print "</td><td>";
                          
    for ($i = 0; $i < $NumBars; $i++) {
        print "<table><tr><td style=\"background-color:" . $ColorArray[$i]. "\" width=" . $ValArray[$i] * $PxPerUnit . ">";
        //for ($j = 1; $j < $ValArray[$i]; $j += $ScalePerUnit) {
            print "&nbsp;";
        //}
        print "</td><td>" . $ValArray[$i] . "</td></tr></table>";
    }  	       
    
    print "</td></tr></table>";
    
}                   


function GenerateRandomColor() {

    $HexCode = "";

    for ($i = 0; $i < 6; $i++) {   
        
        mt_srand((double)microtime() * 1000000); 
        $Num = mt_rand(1,15); 
        
        if ($Num >= 10) {
            $HexCode .= chr($Num + 55);
        } else {
            $HexCode .= strval($Num);
        }
        
    }
    
    return "#" . $HexCode;                     
    
}

for ($i=0; $i < 12; $i++) {
    $j = $i + 1;
    if ( $j==1 || $j==3 || $j==5 || $j==7 || $j==8 || $j==10 || $j==12 ) {
        $ende=31;
    }
    elseif ( $j==4 || $j==6 || $j==9 || $j==11 ) {
        $ende=30;
    }
    elseif ( $j==2 && $year%4==0) {
        $ende=29;
    } 
    elseif ( $j==2 && $year%4!=0) {
        $ende=28;
    } 
    
    
    $monat[$i] = good_query_value('SELECT sum(
        IF (begin>"'.own_date_format("%Y-%m-%d","01-".$j."-".$year,0).'" AND begin<"'.own_date_format("%Y-%m-%d",$ende."-".$j."-".$year,0).'" AND end>"'.own_date_format("%Y-%m-%d",$ende."-".$j."-".$year,0).'",'.$ende.' - day(begin),
        IF (end>"'.own_date_format("%Y-%m-%d","01-".$j."-".$year,0).'" AND end<"'.own_date_format("%Y-%m-%d",$ende."-".$j."-".$year,0).'" AND begin<"'.own_date_format("%Y-%m-%d","01-".$j."-".$year,0).'",day(end)-1,
        IF (begin<"'.own_date_format("%Y-%m-%d","01-".$j."-".$year,0).'" AND end>"'.own_date_format("%Y-%m-%d",$ende."-".$j."-".$year,0).'",'.$ende.',
        IF (begin>"'.own_date_format("%Y-%m-%d","01-".$j."-".$year,0).'" AND end<"'.own_date_format("%Y-%m-%d",$ende."-".$j."-".$year,0).'",end-begin,NULL)))) 				 
        )
        FROM bookings ') ;
    
	$count_bookings = good_query_value('SELECT COUNT(id) FROM bookings WHERE begin>"'.own_date_format("%Y-%m-%d","01-".$j."-".$year,0).'" AND end<"'.own_date_format("%Y-%m-%d",$ende."-".$j."-".$year,0).'" ');
	
    $temp1[$i] = $monat[$i]+$count_bookings; 
}

$temp2[0] = "Januar";	
$temp2[1] = "Februar";	
$temp2[2] = "März";	
$temp2[3] = "April";	
$temp2[4] = "Mai";
$temp2[5] = "Juni";	
$temp2[6] = "Juli";	
$temp2[7] = "August";	
$temp2[8] = "September";	
$temp2[9] = "Oktober";	
$temp2[10] = "November";	
$temp2[11] = "Dezember";	

    
for ($i = 0; $i < 12; $i++) {
    $temp3[$i] = GenerateRandomColor();
}
        
print "<table border=1 cellpadding=0 cellspacing=0 width=50% ><tr><td>";
Plot(12,$temp1,$temp2,$temp3,5,$year);                       
print "</td></tr></table></html>";


include("include/footer.inc");

?>