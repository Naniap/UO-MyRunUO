<?php

require("myrunuo.inc.php");

    $link = sql_connect();     
    
      $result = sql_query($link, "SELECT update_time
FROM information_schema.tables
WHERE TABLE_SCHEMA = 'myrunuo2' AND TABLE_NAME = 'myrunuo_statistics' AND update_time > (NOW() - INTERVAL 5 MINUTE);");
      if (!(list($tableuptime) = mysql_fetch_row($result)))
      mysql_free_result($result);
      $currentDate = strtotime($tableuptime);
      $futureDate = $currentDate+(70*5);
      $formatDate = date("Y-m-d H:i:s", $futureDate);
      if (date("Y-m-d H:i:s") > $formatDate)
        $uptime = "The server is currently down.";
	$result = sql_query($link, "SELECT time_datetime FROM myrunuo_timestamps WHERE time_type='Status'");
	if (!(list($timestamp) = mysql_fetch_row($result)))
  	$timestamp = "";
	mysql_free_result($result);

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
<script type="text/javascript">

function showHide(div){
  
  if(document.getElementById(div).style.display == 'none'){
    document.getElementById(div).style.display = 'block';
  }else{
    document.getElementById(div).style.display = 'none'; 
  }
}

</script>
<div align="center"> 
 
<div id="banner"><img src="../images/banner.jpg"></div> 
<div id="container"> 
<div id="main"> 
	<div id="sideNavi"> 
	  <div class="remote"> 
<ul> 
	<li class="navigation"><a href="index.php">Statistics</a> 
		<ul> 
			<!--<li class="navigation"><a href="/factions/">Factions</a></li> -->
                     <li class="navigation"><a href="status.php">Online Players</a></li>
			<li class="navigation"><a href="players.php">Players</a></li> 
			<li class="navigation"><a href="guilds.php">Guilds</a></li> 
			<li class="navigation"><a href="dueling.php">Dueling</a></li>
			<li class="navigation"><a href="bounties.php?sortby=Bounty&flip=1">Bounties</a></li>
			<li class="navigation"><a href="bulletinboard.php">Bulletin Posts</a></li>
			<!--<li class="navigation"><a href="http://videos.uogamers.com/">Videos</a></li>
			<li class="navigation"><a href="http://poker.uogamers.com/">Poker</a></li> --> 
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
		<td class="section-mm">
EOF;
      $counter = 0;
      $result = sql_query($link, "SELECT poster, subject, time, postlines, thread, replythread FROM myrunuo_bulletinmessages"); //Retrieves information on Items
	 while ((list($poster,$subject,$time,$postlines,$thread,$replythread) = mysql_fetch_row($result)))
      {
     if ($time != "")
  $dt2 = date("F j, Y, g:i a", strtotime($time));
else
  $dt2 = date("F j, Y, g:i a");
echo<<<EOF

<h2>
<a href="#" onclick="showHide('eventbody-$counter');">$subject by $poster ($dt2)</a></h2>
<div id="eventbody-$counter" style="display:none;">$postlines</div>


 
EOF;
$counter++;
}
      mysql_free_result($result);
mysql_close($link);

echo<<<EOF
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