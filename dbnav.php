<?php
/* Last updated 30 Nov 2015
You need to pass the $currentid to this php function
*/

//find next record by ID
$prevquery= "SELECT * FROM inventory WHERE id < $currentid ORDER BY id DESC LIMIT 1"; 
$prevresult = mysql_query($prevquery) or die(mysql_error());
while($prevrow = mysql_fetch_array($prevresult))
{
$previd  = $prevrow['id']; //this delivers to you the previous row id, stores it in previd
}

$nextquery= "SELECT * FROM wp_posts WHERE id > $currentid ORDER BY id ASC LIMIT 1"; 
$nextresult = mysql_query($nextquery) or die(mysql_error());
while($nextrow = mysql_fetch_array($nextresult))
{
$nextid  = $nextrow['id'];  //this delivers to you the next row id, stores it in nextid
}
?>
