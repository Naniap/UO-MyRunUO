<?php

include_once "SQL.php";

// Guild page / war page to display
check_get($guildPage, "gp");
$guildPage = intval($guildPage);
check_get($warPage, "wp");
$warPage = intval($warPage);

check_get($sortBy, "sortby");
if ($sortBy == "" || $sortBy == "guild_name")
	$sort1 = "myrunuo_guilds.guild_name";
else
	$sort1 = $sortBy . " DESC";

check_get($sortBy1, "sortby1");
if ($sortBy1 == "" || $sortBy1 == "guild_name")
	$sort2 = "myrunuo_guilds.guild_name";
else
	$sort2 = $sortBy1 . " DESC";

$sql = SQL::getConnection();

// Total guilds count
$result = $sql->query("SELECT COUNT(*) FROM myrunuo_guilds");
$row = $result->fetch_assoc();
$totalGuilds = $row["COUNT(*)"];

// Total guilds at war
$result = $sql->query("SELECT DISTINCT count(*) FROM myrunuo_guilds_wars GROUP BY guild_1");
$row = $result->fetch_assoc();
$totalWars  = $row["COUNT(*)"];

// Chaos guilds total count
$result = $sql->query("SELECT COUNT(*) FROM myrunuo_guilds WHERE guild_type = 'Chaos'");
$row = $result->fetch_assoc();
$chaosGuilds  = $row["COUNT(*)"];

// Order guilds total count
$result = $sql->query("SELECT COUNT(*) FROM myrunuo_guilds WHERE guild_type = 'Order'");
$row = $result->fetch_assoc();
$orderGuilds  = $row["COUNT(*)"];

// Guild timestamp
$result = $sql->query("SELECT time_datetime FROM myrunuo_timestamps WHERE time_type = 'Guild'");
$row = $result->fetch_assoc();
$timestamp = $row["time_datetime"];

echo <<<EOF
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<center>
<head>
  <title>Shard Guilds</title>
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
			<li class="navigation"><a href="bounties.php?sortBy=Bounty&flip=1">Bounties</a></li>
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
<br>
<font face="Verdana, Comic Sans MS" size="4"><strong>SHARD GUILDS</strong></font>
<br>
<table cellspacing="0" cellpadding="0" width="580" border="0">
  <tbody>
    <tr>
      <td align="left" valign="top">
        <font face="Verdana" size="-1">
        <img height="60" src="images/caps/t.gif" width="40" align="left" border="0"> his page shows the overall top guilds in mutually declared wars and Membership.<br><br><br><br><br>
        </font>
      </td>
    </tr>
    <tr>
      <td align="left" bgcolor="#32605e">
        <font face="Verdana" color="#ffffff" size="-1">
        &nbsp;&nbsp;<b>Total Guilds:</b> $totalGuilds<b>&nbsp;&nbsp;Total Chaos Guilds:</b> $chaosGuilds &nbsp;&nbsp;<b>Total Order Guilds:</b> $orderGuilds
        </font>
      </td>
    </tr>
    <tr> 
      <td>
        <table cellpadding="2" width="580" border="0">
          <tbody>
            <tr> 
              <td colspan="3">

EOF;

if ($guildPage - SQL::GUILDSPERPAGE >= 0) {
	$num = $guildPage - SQL::GUILDSPERPAGE;
	echo "        <a href=\"guilds.php?gp=$num&wp=$warPage&sortBy=$sortBy&sortBy1=$sortBy1\"><img src=\"images/items/back.jpg\" border=\"0\"></a>\n";
} else
	echo "        &nbsp; &nbsp;";

$page = intval($guildPage / SQL::GUILDSPERPAGE) + 1;
$pages = ceil($totalGuilds / SQL::GUILDSPERPAGE);
if ($pages > 1)
	echo " <font size=\"-1\" face=\"Verdana\">Page [$page/$pages]</font> ";

if ($guildPage + SQL::GUILDSPERPAGE < $totalGuilds) {
	$num = $guildPage + SQL::GUILDSPERPAGE;
	echo "        <a href=\"guilds.php?gp=$num&wp=$warPage&sortBy=$sortBy&sortBy1=$sortBy1\"><img src=\"images/items/next.jpg\" border=\"0\"></a>\n";
}

echo <<<EOF
              </td>
            </tr>
            <tr> 
              <td align="left" colspan="3">
                <img height="25" src="images/items/vetmem.gif" width="243" border="0">
              </td>
            </tr>
            <tr> 
              <td width="10">&nbsp;</td>
              <td>
                <font face="Verdana" size="2">
                <a href="guilds.php?sortBy=guild_name&sortBy1=$sortBy1" style="color: black"><strong>Guild Name</strong></a>
                </font>
              </td>
              <td align="right" width="50">
                <font face="Verdana" size="2">
                <a href="guilds.php?sortBy=countofchar_guild&sortBy1=$sortBy1" style="color: black"><strong>Members</strong></a>
                </font>
              </td>
              <td align="right" width="50">
                <font face="Verdana" size="2">
                <a href="guilds.php?sortBy=countofchar_counts&sortBy1=$sortBy1" style="color: black"><strong>Kills</strong></a>
                </font>
              </td>
            </tr>

EOF;

// Guilds / members
$result = $sql->query("
					SELECT guild_id, guild_name, COUNT(char_guild) AS countofchar_guild, SUM(char_counts) AS countofchar_counts
                    FROM myrunuo_guilds INNER JOIN myrunuo_characters ON guild_id = char_guild
                    GROUP BY guild_name ORDER by $sort1 LIMIT $guildPage, " . SQL::GUILDSPERPAGE);

if ($result->num_rows >= 1) {
	$num = $guildPage * SQL::GUILDSPERPAGE + 1;
	while ($row = $result->fetch_assoc()) {
		$guildId = intval($row["guild_id"]);
		$guildName = $row["guild_name"];
		$members = intval($row["countofchar_guild"]);
		$kills = intval($row["countofchar_counts"]);
		echo <<<EOF
            <tr> 
              <td align="right" width="10">
                <font face="Verdana" size="-1">$num</font></td>
              <td align="left" width="470">
                <font face="Verdana" size="-1"><a href="guild.php?id=$guildId">$guildName</a></font>
              </td>
              <td align="right" width="50">
                <font face="Verdana" size="-1">$members</font>
              </td>
              <td align="right" width="50">
                <font face="Verdana" size="-1">$kills</font>
              </td>
            </tr>

EOF;
		$num++;
	}
} else {
	echo <<<EOF
            <tr> 
              <td colspan="3">
                <font face="Verdana" size="-1">No matching guilds found.</font>
              </td>
            </tr>

EOF;
}

echo <<<EOF
          </tbody>
        </table>
      </td>
    </tr>
    <tr> 
      <td>
        <table cellpadding="2" width="580" border="0">
          <tbody>
            <tr> 
              <td colspan="3">

EOF;

if ($warPage - SQL::GUILDSPERPAGE > 0) {
	$num = $warPage - SQL::GUILDSPERPAGE;
	echo "                <a href=\"guilds.php?wp=$num&gp=$guildPage&sortBy=$sortBy&sortBy1=$sortBy1\"><img src=\"images/items/back.jpg\" border=\"0\"></a>\n";
} else
	echo "                &nbsp;&nbsp;";

$page = intval($warPage / SQL::GUILDSPERPAGE) + 1;
$pages = ceil($totalWars / SQL::GUILDSPERPAGE);
if ($pages > 1)
	echo " <font size=\"-1\" face=\"Verdana\">Page [$page/$pages]</font> ";

if ($warPage + SQL::GUILDSPERPAGE < $totalWars) {
	$num = $warPage + SQL::GUILDSPERPAGE;
	echo "                <a href=\"guilds.php?wp=$num&gp=$guildPage&sortBy=$sortBy&sortBy1=$sortBy1\"><img src=\"images/items/next.jpg\" border=\"0\"></a>\n";
}

echo <<<EOF
              </td>
            </tr>
            <tr> 
              <td align="left" colspan="4">
                <img height="25" src="images/items/warfare.gif" width="243" border="0">
              </td>
            </tr>
            <tr> 
              <td width="10">&nbsp;</td>
              <td width="520">
                <font face="Verdana" size="-1">
                <a href="guilds.php?sortBy1=guild_name&sortBy=$sortBy" style="color: black"><strong>Guild Name</strong></a></font>
              </td>
              <td align="right" width="50">
                <font face="Verdana" size="-1"><a href="guilds.php?sortBy1=countofguild_1&sortBy=$sortBy" style="color: black"><strong>Enemies</strong></a></font>
              </td>
            </tr>

EOF;

// War guilds / enemies
$result = $sql->query("SELECT guild_id, guild_name, COUNT(guild_1) AS countofguild_1
                    FROM myrunuo_guilds INNER JOIN myrunuo_guilds_wars ON guild_id = guild_1 OR guild_id = guild_2
                    GROUP BY guild_id,guild_name ORDER by $sort2 LIMIT $warPage, " . SQL::GUILDSPERPAGE);
$num = $result->num_rows;

if ($num) {
	$num = $warPage * SQL::GUILDSPERPAGE + 1;
	while ($row = $result->fetch_assoc()) {
		$guildId = intval($row["guild_id"]);
		$guildName = $row["guild_name"];
		$enemies = intval($row["countofguild_1"]);

		echo <<<EOF
            <tr> 
              <td align="right" width="10">
                <font face="Verdana" size="-1">$num</font>
              </td>
              <td align="left" width="520">
                <font face="Verdana" size="-1"><a href="guild.php?id=$guildId">$guildName</a></font>
              </td>
              <td align="right" width="50">
                <font face="Verdana" size="-1">$enemies</font>
              </td>
            </tr>

EOF;
		$num++;
	}
} else {
	echo <<<EOF
           <tr> 
              <td colspan="4"><font face="Verdana" size="-1">No matching guilds found.</font></td>
            </tr>

EOF;
}

if ($timestamp != "")
	$dt = date("F j, Y, g:i a", strtotime($timestamp));
else
	$dt = date("F j, Y, g:i a");

echo <<<EOF
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="4"><br></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#32605e" colspan="4">
        <font face="Verdana" color="#ffffff" size="-1">&nbsp;&nbsp;<b>Last Updated:</b> $dt</font>
      </td>
    </tr>
  </tbody>
</table>
</font> 
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