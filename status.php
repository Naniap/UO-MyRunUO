<?php

include_once "SQL.php";

if (!isset($_GET['tp']))
	$tp = 0;
else
	$tp = $_GET['tp'];

if (!isset($_GET['tp']))
	$sw = "desc";
else
	$sw = "";

if (!isset($_GET["sortby"]))
	$sortBy = "name";
else
	$sortBy = $_GET["sortby"];
$s = $sortBy;
switch (strtolower($s)) {
	case "kills":
		$sortBy = "char_counts";
		break;
	case "karma":
		$sortBy = "char_karma";
		break;
	case "fame":
		$sortBy = "char_fame";
		break;
	default: // name
		$sortBy = "char_name";
}

$sql = SQL::getConnection();

// Status timestamp
$result = $sql->query("SELECT time_datetime FROM myrunuo_timestamps WHERE time_type='Status'");
$row = $result->fetch_assoc();
$timestamp = $row["time_datetime"];

$flip = $nflip = $cflip = $kflip = $fflip = 0;
if (!$flip) {
	if ($sortBy == "char_name")
		$nflip = 1;
	else if ($sortBy == "char_counts")
		$cflip = 1;
	else if ($sortBy == "char_karma")
		$kflip = 1;
	else if ($sortBy == "char_fame")
		$fflip = 1;
}
// Get total online player count
$result = $sql->query("SELECT COUNT(*) FROM myrunuo_status");
$row = $result->fetch_row();
$totalPlayers = $row[0];

// Get status and total online players (non-staff)
$result = $sql->query("
					SELECT myrunuo_status.char_id, char_karma, char_fame, char_name, char_nototitle, char_counts
                    FROM myrunuo_status
                    LEFT JOIN myrunuo_characters ON myrunuo_characters.char_id=myrunuo_status.char_id
                    WHERE char_name<>''
                    ORDER BY $sortBy $sw LIMIT $tp, " . SQL::STATUSPERPAGE);
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
<table cellspacing="0" cellpadding="0" width="section"> 
<tr> 
<td> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm">
<font face="Verdana" size="2">Online players: $totalPlayers<br></font>
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

if ($tp - SQL::STATUSPERPAGE >= 0) {
	$num = $tp - SQL::STATUSPERPAGE;
	echo "        <a href=\"status.php?tp=$num&sortby=$s\"><img src=\"images/items/back.jpg\" border=\"0\"></a>\n";
} else
	echo "        &nbsp; &nbsp;";

$page = intval($tp / SQL::STATUSPERPAGE) + 1;
$pages = ceil($totalPlayers / SQL::STATUSPERPAGE);
if ($pages > 1)
	echo " <font size=\"-1\" face=\"Verdana\">Page [$page/$pages]</font> ";

if ($tp + SQL::STATUSPERPAGE < $totalPlayers) {
	$num = $tp + SQL::STATUSPERPAGE;
	echo "        <a href=\"status.php?tp=$num&sortby=$s\"><img src=\"images/items/next.jpg\" border=\"0\"></a>\n";
}

echo <<<EOF
    </td>
  </tr>

EOF;

$num = 0;
if ($totalPlayers) {
	while ($row = mysql_fetch_row($result)) {
		$id = $row['char_id'];
		$karma = $row['char_karma'];
		$fame = $row['char_fame'];
		$charName = $row['char_name'];
		$title = $row['char_nototitle'];
		$kills = $row["char_counts"];

		if ($charName != "") {
			echo <<<EOF
  <tr>
    <td>
      <font face="Verdana" size="2"><a href="player.php?id=$id">$charName</a></font>
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
	<img src="./images/footer_a.jpg" alt="" /><img src="./images/footer_b.jpg" alt="" /><img src="./images/footer_c.jpg" alt="" /><img src="./images/footer_d.jpg" alt="" />
	</div> 
</div> 
 
</div> 
</body>
</center>
</html>

EOF;

?>