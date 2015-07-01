<?php

require("myrunuo.inc.php");

check_get($tp, "tp");
$tp = intval($tp);

check_get($flip, "flip");
if ($flip)
  $sw = "desc";
else
  $sw = "";

check_get($sortby, "sortby");
$s = $sortby;
switch (strtolower($s)) {
  case "kills":
    $sortby = "char_counts";
    break;
  case "karma":
    $sortby = "char_karma";
    break;
  case "fame":
    $sortby = "char_fame";
    break;
  default: // name
    $sortby = "char_name";
}

$link = sql_connect();
/*
$ts_ip = "uoreplay.com"; // Change to your server's IP external or domain name
$ts_port = "2593"; // Make sure this port is open on the router or firewall

$output = @fsockopen("$ts_ip", $ts_port, $errno, $errstr, 2);
//socket_set_timeout($output, 000002);

if (!$output) {
    $output1 = "<h1><FONT COLOR=#DD0000><B>The server is offline.</h1></B></FONT>";
} else {
    $output1 = "<h1><FONT COLOR=#00DD00><B>The server is online.</h1></B></FONT>";
}*/

// Status timestamp
$result = sql_query($link, "SELECT time_datetime FROM myrunuo_timestamps WHERE time_type='Status'");
if (!(list($timestamp) = mysql_fetch_row($result)))
  $timestamp = "";
mysql_free_result($result);

$nflip = $cflip = $kflip = $fflip = 0;
if (!$flip) {
  if ($sortby == "char_name")
    $nflip = 1;
  else if ($sortby == "char_counts")
    $cflip = 1;
  else if ($sortby == "char_karma")
    $kflip = 1;
  else if ($sortby == "char_fame")
    $fflip = 1;
}
// Get total online player count
$result = sql_query($link, "SELECT COUNT(*) FROM myrunuo_status");
if (!$result) {
  echo "Database error.<br>\n";
  exit;
}
list($totalplayers) = mysql_fetch_row($result);
mysql_free_result($result);

// Get status and total online players (non-staff)
$result = sql_query($link, "SELECT myrunuo_status.char_id,char_karma,char_fame,char_name,char_nototitle,char_counts,char_public
                    FROM myrunuo_status
                    LEFT JOIN myrunuo_characters ON myrunuo_characters.char_id=myrunuo_status.char_id
                    WHERE char_name<>''
                    ORDER BY $sortby $sw LIMIT $tp,$status_perpage");

echo <<<EOF
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<center>
<head>
  <title>Server Status</title>
  <meta http-equiv="Content-Type" content="text/html; CHARSET=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style.css"/> 
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body> 
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
<table cellspacing="0" cellpadding="0" width="section"> 
<tr> 
<td> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm">
<font face="Verdana" size="2">Online players: $totalplayers<br></font>
<table width="640">
  <tr bgcolor="#32605e">
     <td width="150">
       <a href="status.php?sortby=Name&flip=$nflip" style="color: white">Name</a>
     </td>
     <td><font color="white">Title</font></td>
     <td align="center" width="50">
       <a href="status.php?sortby=Kills&flip=$cflip" style="color: white">Kills</a>
     </td>
     <td align="center" width="50">
       <a href="status.php?sortby=Karma&flip=$kflip" style="color: white">Karma</a>
     </td>
     <td align="center" width="50">
       <a href="status.php?sortby=Fame&flip=$fflip" style="color: white">Fame</a>
     </td>
  </tr>
  <tr>
    <td colspan="5">

EOF;

if ($tp - $status_perpage >= 0) {
  $num = $tp - $status_perpage;
  echo "        <a href=\"status.php?tp=$num&sortby=$s\"><img src=\"images/items/back.jpg\" border=\"0\"></a>\n";
}
else
  echo "        &nbsp; &nbsp;";

$page = intval($tp / $status_perpage) + 1;
$pages = ceil($totalplayers / $status_perpage);
if ($pages > 1)
  echo " <font size=\"-1\" face=\"Verdana\">Page [$page/$pages]</font> ";

if ($tp + $status_perpage < $totalplayers) {
  $num = $tp + $status_perpage;
  echo "        <a href=\"status.php?tp=$num&sortby=$s\"><img src=\"images/items/next.jpg\" border=\"0\"></a>\n";
}

echo <<<EOF
    </td>
  </tr>

EOF;

$num = 0;
if ($totalplayers) {
  while ($row = mysql_fetch_row($result)) {
    $id = $row[0];
    $karma = $row[1];
    $fame = $row[2];
    $charname = $row[3];
    $title = $row[4];
    $kills = $row[5];

    if ($charname != "") {
      echo <<<EOF
  <tr>
    <td>
      <font face="Verdana" size="2"><a href="player.php?id=$id">$charname</a></font>
    </td>
    <td>
      <font face="Verdana" size="2">$title</font>
    </td>
    <td align="right">
      <font face="Verdana" size="2">$kills</font>
    </td>
    <td align="right">
      <font face="Verdana" size="2">$karma</font>
    </td>
    <td align="right">
      <font face="Verdana" size="2">$fame</font>
    </td>
  </tr>

EOF;
      $num++;
    }
  }
}

if (!$num) {
  echo <<<EOF
  <tr>
    <td colspan="5">
      <font face="Verdana" size="2">There are no players online.</font>
    </td>
  </tr>

EOF;
}

mysql_free_result($result);
mysql_close($link);

if ($timestamp != "")
  $dt = date("F j, Y, g:i a", strtotime($timestamp));
else
  $dt = date("F j, Y, g:i a");

echo <<<EOF
  <tr>
    <td colspan="5"><font size="1pt">&nbsp;</font></td>
  </tr>
  <tr bgcolor="#32605e">
    <td colspan="5">
      <font face="Verdana" color="#ffffff" size="-1">&nbsp;&nbsp;<b>Last Updated:</b> $dt</font>
    </td>
  </tr>
</table>
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
</center>
</html>

EOF;

?>