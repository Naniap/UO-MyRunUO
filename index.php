<?php

require("myrunuo.inc.php");

$link = sql_connect();
$result = sql_query($link, "SELECT COUNT(*) FROM myrunuo_characters"); // adds number of players
list($numchars) = mysql_fetch_row($result);
$numchars = intval($numchars);
mysql_free_result($result);
if ($numchars == 1)
	$players = "character";
else
	$players = "characters";

$result = sql_query($link, "SELECT COUNT(*) FROM myrunuo_guilds"); // adds number of guilds
list($numguilds) = mysql_fetch_row($result);
$numguilds = intval($numguilds);
mysql_free_result($result);
//proper punctuation
if ($numguilds == 1)
	$guild = "guild";
else
	$guild = "guilds";

$result = sql_query($link, "SELECT items,mobiles,uptime,accounts FROM myrunuo_statistics"); //Retrieves information on Items
if (!(list($items, $mobiles, $uptime, $accounts) = mysql_fetch_row($result)))
	mysql_free_result($result);

$result = sql_query($link, "SELECT update_time
FROM information_schema.tables
WHERE TABLE_SCHEMA = 'myrunuo' AND TABLE_NAME = 'myrunuo_statistics' AND update_time > (NOW() - INTERVAL 5 MINUTE);");
if (!(list($tableuptime) = mysql_fetch_row($result)))
	mysql_free_result($result);
$currentDate = strtotime($tableuptime);
$futureDate = $currentDate + (70 * 5);
$formatDate = date("Y-m-d H:i:s", $futureDate);
if (date("Y-m-d H:i:s") > $formatDate)
	$uptime = "The server is currently down.";
$result = sql_query($link, "SELECT time_datetime FROM myrunuo_timestamps WHERE time_type='Status'");
if (!(list($timestamp) = mysql_fetch_row($result)))
	$timestamp = "";
mysql_free_result($result);
mysql_close($link);
if ($timestamp != "")
	$dt = date("F j, Y, g:i a", strtotime($timestamp));
else
	$dt = date("F j, Y, g:i a");

echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>My UOReplay</title> 
<link rel="stylesheet" type="text/css" href="style.css"/> 
<link href="styles.css" rel="stylesheet" type="text/css" /> 
</head> 
 
<body> 
<div align="center"> 
 
<div id="banner"><img src="./images/banner.jpg"></div>
<div id="container"> 
<div id="main"> 
	<div id="sideNavi"> 
	  <div class="remote"> 
<ul> 
	<li class="navigation"><a href="index.php">Statistics</a> 
		<ul> 
			<li class="navigation"><a href="status.php">Online Players</a></li>
			<li class="navigation"><a href="players.php">Players</a></li> 
			<li class="navigation"><a href="guilds.php">Guilds</a></li> 
			<li class="navigation"><a href="dueling.php">Dueling</a></li>
			<li class="navigation"><a href="bounties.php?sortby=Bounty&flip=1">Bounties</a></li>
			<li class="navigation"><a href="bulletinboard.php">Bulletin Posts</a></li>
		</ul> 
		</ul> 
	</li> 
</ul> 
	  </div> 
	<div class="specialText"><img src="http://my.uoreplay.com/images/nav_footer.jpg" alt="" /></div> 
	</div> 
		
	<div id="content"> 
		<table width="752" cellpadding="0" cellspacing="0"> 
		 <tr> 
		   <td width="173" valign="top" align="right"> 
		<br /><img src="http://my.uoreplay.com/images/griff_left.jpg" alt="" /> 
		  </td> 
		  <td width="404" id="headlines"> 
		 <br /> 
		  </td> 
		  <td width="173" valign="top"> 
		<br /><img src="http://my.uoreplay.com/images/griff_right_div.jpg" alt="" /> 
		  </td> 
		 </tr> 
		</table> 
	</div> 
 
	 <div class="content"> 
<table cellspacing="2" cellpadding="2" width="100%"> 
<tr> 
<td> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm"><h2>UO: Replay</h2> 
<p>Currently tracking $numchars $players and $numguilds $guild. There are currently $accounts accounts, $items items, and $mobiles mobiles spawned in the world.<br>The current uptime is: $uptime </p>  
<font face="Verdana" color="#000000" size="-1"><b>Last Updated:</b> $dt</font>
	
</td> 
		<td class="section-mr"></td>
	</tr> 
	<tr><td class="section-bl"></td><td class="section-bm"></td><td class="section-br"></td></tr> 

</table></td> 

</tr> 

</table> 

</div> 

</div> 
	  
</div> 
 
<div align="center"> 
	<div id="footer"> 
	<img src="http://my.uoreplay.com/images/footer_a.jpg" alt="" /><img src="http://my.uoreplay.com/images/footer_b.jpg" alt="" /><img src="http://my.uoreplay.com/images/footer_c.jpg" alt="" /><img src="http://my.uoreplay.com/images/footer_d.jpg" alt="" /> 
	</div> 
</div> 
 
</div> 
</body> 
</html> 

EOF;
?>