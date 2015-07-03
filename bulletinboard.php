<?php

include_once "SQL.php";

$sql = SQL::getConnection();
$result = $sql->query("
	SELECT update_time
	FROM information_schema.tables
	WHERE TABLE_SCHEMA = 'myrunuo' AND TABLE_NAME = 'myrunuo_statistics' AND update_time > (NOW() - INTERVAL 5 MINUTE);");

$row = $result->fetch_assoc();
$tableUptime = $row['update_time'];
$currentDate = strtotime($tableUptime);
$futureDate = $currentDate + (70 * 5);
$formatDate = date("Y-m-d H:i:s", $futureDate);
if (date("Y-m-d H:i:s") > $formatDate)
	$uptime = "The server is currently down.";
$result = $sql->query("SELECT time_datetime FROM myrunuo_timestamps WHERE time_type='Status'");
$row = $result->fetch_assoc();
$timestamp = $row['time_datetime'];
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
	<div class="specialText"><img src="./images/nav_footer.jpg" alt="" /></div>
	</div> 
		
	<div id="content"> 
		<table width="752" cellpadding="0" cellspacing="0"> 
		 <tr> 
		   <td width="173" valign="top" align="right"> 
		<br /><img src="./images/griff_left.jpg" alt="" />
		  </td> 
		  <td width="404" id="headlines"> 
		 <br /> 
		  </td> 
		  <td width="173" valign="top"> 
		<br /><img src="./images/griff_right_div.jpg" alt="" />
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
$result = $sql->query("SELECT poster, subject, time, postlines FROM myrunuo_bulletinmessages");
while ($row = $result->fetch_assoc()) {
	$poster = $row['poster'];
	$subject = $row['subject'];
	$time = $row['time'];
	$postLines = $row['postlines'];
	if ($time != "")
		$dt2 = date("F j, Y, g:i a", strtotime($time));
	else
		$dt2 = date("F j, Y, g:i a");
	echo <<<EOF

<h2>
<a href="#" onclick="showHide('eventbody-$counter');">$subject by $poster ($dt2)</a></h2>
<div id="eventbody-$counter" style="display:none;">$postLines</div>
 
EOF;
	$counter++;
}

echo <<<EOF
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
	<img src="./images/footer_a.jpg" alt="" /><img src="./images/footer_b.jpg" alt="" /><img src="./images/footer_c.jpg" alt="" /><img src="./images/footer_d.jpg" alt="" />
	</div> 
</div> 
 
</div> 
</body> 
</html> 

EOF;
?>