<?php

include_once "SQL.php";

check_get($id, "id");
$id = intval($id);

$sql = SQL::getConnection();

// Get guild data
$result = $sql->query("SELECT * FROM myrunuo_guilds WHERE guild_id = $id LIMIT 1");
if ($row = $result->fetch_assoc()) {
	while (list($key, $val) = each($row))
		${$key} = $val;

	$guild_wars = intval($guild_wars);
	$guild_members = intval($guild_members);
	$guild_master = intval($guild_master);

	$capguild = strtolower(substr($guild_name, 0, 1)) . ".gif";
	$full_name = $guild_name;
	$guild_name = substr($guild_name, 1);

	if ($guild_website != "") {
		if (strncasecmp($guild_name, "http://", 7))
			$guild_website = "http://" . $guild_website;
		$guild_website = "<a href=\"$guild_website\" target=\"_blank\">$guild_website</a>";
	} else
		$guild_website = "None";

	if ($guild_charter == "")
		$guild_charter = "No guild charter has been specified.";
} else {
	echo "Invalid guild ID.<br>\n";

	die();
}

$result = $sql->query("SELECT char_name FROM myrunuo_characters WHERE char_id = $guild_master LIMIT 1");
if($row = $result->fetch_assoc())
	$guildMaster = $row['char_name'];
else
	$guildMaster = "None";

// Guild timestamp
$result = $sql->query("SELECT time_datetime FROM myrunuo_timestamps WHERE time_type = 'Guild'");
$row = $result->fetch_assoc();
$timestamp = $row["time_datetime"];

echo <<<EOF
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">


<head>
  <title>$full_name Guild Page</title>
  <meta http-equiv="Content-Type" content="text/html; CHARSET=iso-8859-1">
  <link rel="stylesheet" type="text/css" href="style.css"/> 
  <link href="styles.css" rel="stylesheet" type="text/css" /> 
  <script language="JavaScript">
    nav1on = new Image(63, 214);
    nav1on.src = "images/items/av_on.gif";

    nav1off = new Image(63, 214);
    nav1off.src = "images/items/av_off.gif";

    function img_act(imgName) {
      imgOn = eval(imgName + "on.src");
      document [imgName].src = imgOn;
    }

    function img_inact(imgName) {
      imgOff = eval(imgName + "off.src");
      document [imgName].src = imgOff;
    }
  </script>
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
<table cellspacing="2" cellpadding="2" width="100%"> 
<tr> 
<td> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm">


<table border="0" cellpadding="0" cellspacing="0">
  <tr valign="middle"> 
    <td colspan="2" align="left">
      <img src="images/caps/$capguild" width="40" height="60" border="0" align="absmiddle">$guild_name
    </td>
  </tr>
  <tr> 
    <td align="left" width="135">
      <strong><font face="Verdana" size="2">Abbreviation:</font></strong>
    </td>
    <td>
      <font face="Verdana" size="-1">$guild_abbreviation</font>
    </td>
  </tr>
  <tr> 
    <td>
      <strong><font face="Verdana" size="2">Guild Type:</font></strong>
    </td>
    <td>
      <font face="Verdana" size="-1">$guild_type</font>
    </td>
  </tr>
  <tr> 
    <td>
      <strong><font face="Verdana" size="2">Website:</font></strong>
    </td>
    <td>
      <font face="Verdana" size="-1">$guild_website</font>
    </td>
  </tr>
  <tr> 
    <td>
      <strong><font face="Verdana" size="2">Master/Mistress:</font></strong></td>
    <td>
      <font face="Verdana" size="-1"><a href="player.php?id=$guild_master">$guildMaster</a></font>
    </td>
  </tr>
  <tr> 
    <td>
      <strong><font face="Verdana" size="2">Total Members:</font></strong>
    </td>
    <td>
      <font face="Verdana" size="-1">$guild_members</font>
    </td>
  </tr>
  <tr> 
    <td>
      <strong><font face="Verdana" size="2">Total Enemies:</font></strong>
    </td>
    <td>
      <font face="Verdana" size="-1">$guild_wars</font>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <font face="Verdana" size="2"><strong>Charter:</strong></font>
    </td>
  </tr>
</table>
<table cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td>
      <font face="Verdana" size="-1">$guild_charter</font>
    </td>
  </tr>
  <tr>
    <td>
      <br>
      <a OnMouseOver="img_act('nav1')" OnMouseOut="img_inact('nav1')" href="skills.php?id=$id&nc=$guild_members&g=$full_name">
      <img height="63" alt="Skill Averages" src="images/items/av_off.gif" width="214" border="0" name="nav1"></a>
    </td>
  </tr>
</table>
<br>
<table width="640" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td bgcolor="#32605e">
      <font face="Verdana" color="#ffffff" size="-1"><b>&nbsp;&nbsp;Members&nbsp;&nbsp;</b></font>
    </td>
    <td bgcolor="#32605e">
      <font face="Verdana" color="#ffffff" size="-1"><b>&nbsp;&nbsp;Recently at war with&nbsp;&nbsp;</b></font>
    </td>
  </tr>
  <tr>
    <td colspan="2"><font size="1pt">&nbsp;</font></td>
  </tr>
  <tr>
    <td>
EOF;

// Guild Members
$result = $sql->query("SELECT char_id, char_name, char_nototitle, char_guildtitle, char_public FROM myrunuo_characters WHERE char_guild = $id");
if ($result->num_rows) {
	while ($row = $result->fetch_assoc()) {
		$charId = intval($row["char_id"]);
		$charName = $row["char_name"];
		$charTitle = $row["char_nototitle"];
		$charGuildTitle = $row["char_guildtitle"];
		$charPublic = intval($row["char_public"]);

		if (strcasecmp($charGuildTitle, "NULL"))
			$charGuildTitle = " [$charGuildTitle]";
		else
			$charGuildTitle = "";

		$cma = strpos($charTitle, ",");
		$namedisplay = substr($charTitle, 0, $cma);
		$charTitle = substr($charTitle, $cma);

		echo <<< EOF
<a href="player.php?id=$charId">$charTitle $charGuildTitle<br></a>
EOF;
	}
}

echo <<<EOF
    </td>
    <td valign="top">

EOF;

// Guild Wars 1
$result = $sql->query("SELECT guild_name, guild_2 FROM myrunuo_guilds_wars INNER JOIN myrunuo_guilds ON guild_2 = guild_id WHERE guild_1 = $id");
$num1 = $result->num_rows;
if ($num1) {
	while ($row = $result->fetch_assoc()) {
		$warName = $row["guild_name"];
		$warId = intval($row["guild_2"]);
		echo "      <font face=\"Verdana\" size=\"-1\"><a href=\"guild.php?id=$warId\">$warName</a></font><br>\n";
	}
}

// Guild Wars 2
$result = $sql->query("SELECT guild_name, guild_1 FROM myrunuo_guilds_wars INNER JOIN myrunuo_guilds ON guild_1 = guild_id WHERE guild_2 = $id");
$num2 = $result->num_rows;
if ($num2) {
	while ($row = $result->fetch_assoc()) {
		$warName = $row["guild_name"];
		$warId = intval($row["guild_1"]);
		echo "      <font face=\"Verdana\" size=\"-1\"><a href=\"guild.php?id=$warId\">$warName</a></font><br>\n";
	}
}

if (!$num1 && !$num2)
	echo "      <font face=\"Verdana\" size=\"-1\">None</font>\n";

if ($timestamp != "")
	$dt = date("F j, Y, g:i a", strtotime($timestamp));
else
	$dt = date("F j, Y, g:i a");

echo <<<EOF
  </tr>
  <tr>
    <td colspan="2"><font size="1pt">&nbsp;</font></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#32605e" colspan="2">
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
</html> 

EOF;


?>