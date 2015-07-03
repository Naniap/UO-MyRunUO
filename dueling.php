<?php

include_once "SQL.php";

if (isset($_GET["tp"]))
	$currentPage = $_GET["tp"];
else
	$currentPage = 0;

if (isset($_GET["flip"]))
	$sw = "desc";
else
	$sw = "";
$flip = !isset($_GET["sortby"]);
if ($flip)
	$sortBy = "rank";
else
	$sortBy = $_GET["sortby"];

switch (strtolower($sortBy)) {
	case "name":
		$sortBy = "char_name";
		break;
	case "rank":
		$sortBy = "rank";
		break;
	case "level":
		$sortBy = "level";
		break;
	case "wins":
		$sortBy = "wins";
		break;
	case "losses":
		$sortBy = "losses";
		break;
	case "guild":
		$sortBy = "char_guild";
		break;
	default: // name
		$sortBy = "rank";
}

$sql = SQL::getConnection();

// Status timestamp
$result = $sql->query("SELECT time_datetime FROM myrunuo_timestamps WHERE time_type='Char'");
$row = $result->fetch_assoc();
$timestamp = $row["time_datetime"];

$nflip = $cflip = $kflip = $fflip = $lflip = $gflip = 0;
if (!$flip) {
	if ($sortBy == "char_name")
		$nflip = 1;
	else if ($sortBy == "rank")
		$cflip = 1;
	else if ($sortBy == "level")
		$kflip = 1;
	else if ($sortBy == "wins")
		$fflip = 1;
	else if ($sortBy == "losses")
		$lflip = 1;
	else if ($sortBy == "guild")
		$gflip = 1;
}
// Get total online player count
$result = $sql->query("SELECT COUNT(*) FROM myrunuo_characters");
$row = $result->fetch_assoc();
$totalPlayers = $row["COUNT(*)"];

// Get status and total online players (non-staff)
$result = $sql->query("
			SELECT char_name, rank, level, wins, losses, char_id, char_guild, myrunuo_guilds.guild_abbreviation
			FROM myrunuo_characters
			LEFT JOIN myrunuo_guilds ON myrunuo_characters.char_guild = myrunuo_guilds.guild_id
			ORDER BY $sortBy $sw LIMIT $currentPage, " . SQL::STATUSPERPAGE);

echo <<<EOF
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<center>
<head>
  <title>Dueling statistics</title>
  <meta http-equiv="Content-Type" content="text/html; CHARSET=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style.css"/>  
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body> 
<div align="center"> 
 
<div id="banner"><img src="./images/banner.jpg" alt="" /></div>
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
			<li class="navigation"><a href="bulletinboard.php">Bulletin Posts</a></li>		</ul>
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
<!-- <font face="Verdana" size="2">Online players: $totalPlayers<br></font> -->
<!--<table width="640">
  <tr bgcolor="#32605e">
     <td align="center" width="50">
       <a href="dueling.php?sortby=Rank&flip=$cflip" style="color: white">Rank</a>
     </td>
     <td width="250">
       <a href="dueling.php?sortby=Name&flip=$nflip" style="color: white">Name</a>
     </td>
     <td align="center" width="50">
       <a href="dueling.php?sortby=Level&flip=$kflip" style="color: white">Level</a>
     </td>
     <td align="center" width="50">
       <a href="dueling.php?sortby=Wins&flip=$fflip" style="color: white">Wins</a>
     </td>
     <td align="center" width="50">
       <a href="dueling.php?sortby=Losses&flip=$lflip" style="color: white">Losses</a>
     </td>
  </tr>
  <tr>
    <td colspan="5">-->

<div style="margin-top: 1em;"><fieldset>
<legend>Duelists</legend>
<table cellpadding="3" cellspacing="1" width="640">
	<tr>
		<td class="header" align="center"><a href="dueling.php?sortby=Rank&flip=$cflip">Rank</a></td>
		<td class="header" align="center"><a href="dueling.php?sortby=Level&flip=$kflip">Level</a></td>
		<td class="header" align="center"><a href="dueling.php?sortby=Guild&flip=$gflip">Guild</a></td>
		<td class="header" align="left" style="width: 100%;"><a href="dueling.php?sortby=Name&flip=$nflip">Player</a></td>
		<td class="header" align="center"> <a href="dueling.php?sortby=Wins&flip=$fflip">Wins</a></td>
		<td class="header" align="center"><a href="dueling.php?sortby=Losses&flip=$lflip">Losses</a></td>
	</tr>	

EOF;

if ($currentPage - SQL::STATUSPERPAGE >= 0) {
	$num = $currentPage - SQL::STATUSPERPAGE;
	echo "        <a href=\"dueling.php?tp=$num&sortby=$s\"><img src=\"images/items/back.jpg\" border=\"0\"></a>\n";
} else
	//echo "        &nbsp; &nbsp;";

	$page = intval($currentPage / SQL::STATUSPERPAGE) + 1;
$pages = ceil($totalPlayers / SQL::STATUSPERPAGE);
if ($pages > 1)
	echo " <font size=\"-1\" face=\"Verdana\">Page [$page/$pages]</font> ";

if ($currentPage + SQL::STATUSPERPAGE < $totalPlayers) {
	$num = $currentPage + SQL::STATUSPERPAGE;
	echo "        <a href=\"dueling.php?tp=$num&sortby=$s\"><img src=\"images/items/next.jpg\" border=\"0\"></a>\n";
}

echo <<<EOF
    </td>
  </tr>

EOF;

$num = 0;
function addOrdinalNumberSuffix($num) {
	if (!in_array(($num % 100), array(11, 12, 13))) {
		switch ($num % 10) {
			// Handle 1st, 2nd, 3rd
			case 1:
				return $num . 'st';
			case 2:
				return $num . 'nd';
			case 3:
				return $num . 'rd';
		}
	}
	return $num . 'th';
}
// Get status and total online players (non-staff)
$result = $sql->query("
			SELECT char_name, rank, level, wins, losses, char_id, char_guild, myrunuo_guilds.guild_abbreviation
			FROM myrunuo_characters
			LEFT JOIN myrunuo_guilds ON myrunuo_characters.char_guild = myrunuo_guilds.guild_id
			ORDER BY $sortBy $sw LIMIT $currentPage, " . SQL::STATUSPERPAGE);

if ($totalPlayers) {
	while ($row = $result->fetch_assoc()) {
		$charName = $row["char_name"];
		$rank = $row["rank"];
		$level = $row["level"];
		$wins = $row["wins"];
		$losses = $row["losses"];
		$charId = $row["char_id"];
		$guildId = $row["char_guild"];
		$guildName = $row["guild_abbreviation"];


		if ($guildId >= 1 && $guildName == "")
			$guildName = "[none]";
		else if ($guildId >= 1)
			$guildName = "[" . $guildName . "]";

		$ordinalRank = addOrdinalNumberSuffix($rank);

		if ($charName != "") {
			echo <<<EOF
  <tr>
    <td>
      <font face="Verdana" size="2">$ordinalRank</font>
    </td>
    <td>
      <font face="Verdana" size="2"><center>$level</center></font>
    </td>
    <td align="right">
      <font face="Verdana" size="2"><center><a href="guild.php?id=$guildId">$guildName</a></center></font>
    </td>
    <td align="left">
      <font face="Verdana" size="2"><a href="player.php?id=$charId">$charName</a></font>
    </td>
    <td align="right">
      <font face="Verdana" size="2"><center>$wins</center></font>
    </td>
    <td align="right">
      <font face="Verdana" size="2"><center>$losses</center></font>
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