<?php

require("myrunuo.inc.php");

$sText = "Black";

check_get($tp, "tp");
$tp = intval($tp);

check_get($fn, "fn");
if ($fn != "")
	$where = "WHERE char_name LIKE '" . addslashes($fn) . "%'";
else
	$where = "";

$link = sql_connect();

// Total public players
if ($where != "")
	$wherep = $where . " AND char_public=1";
else
	$wherep = "WHERE char_public=1";
$result = sql_query($link, "SELECT COUNT(*) FROM myrunuo_characters $wherep");
list($totalpublic) = mysql_fetch_row($result);
$totalpublic = intval($totalpublic);
mysql_free_result($result);

// Total players
$result = sql_query($link, "SELECT COUNT(*) FROM myrunuo_characters $where");
list($totalplayers) = mysql_fetch_row($result);
$totalplayers = intval($totalplayers);
mysql_free_result($result);

// Player timestamp
$result = sql_query($link, "SELECT time_datetime FROM myrunuo_timestamps WHERE time_type='Char'");
if (!(list($timestamp) = mysql_fetch_row($result)))
	$timestamp = "";
mysql_free_result($result);

echo <<<EOF
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<center>
<head>
  <title>Shard Players</title>
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
		<td class="section-mm"><h2>Player Search</h2> 
<form action="searchplayers.php" method="post"> 
  <font face="Verdana" size="2"> 
  Search for 
  <select name="which"> 
    <option value="0">Beginning of Name</option> 
    <option value="1">Exact Name</option> 
  </select> 
  of character named <input type="text" name="charname" value="">&nbsp;&nbsp;
  <input type="submit" name="submit" value="search"> 
</form> 
		</td> 
		<td class="section-mr"></td> 
	</tr> 
	<tr><td class="section-bl"></td><td class="section-bm"></td><td class="section-br"></td></tr> 
</table><div class="separator"></div><!-- end --> </td> 
</tr> 
<table cellspacing="0" cellpadding="0" width="section">  
<tr> 
<td> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm">
<br>
<font face="Verdana, Comic Sans MS" size="4"><strong>SHARD PLAYERS</strong></font> 
<br>
<table cellspacing="0" cellpadding="0" width="580" border="0">
  <tbody>
    <tr> 
      <td colspan="3" align="left" valign="middle">
        <font face="Verdana" size="-1"><img height="60" align="left" src="images/caps/t.gif" width="40" border="0"> his page shows the overall players.<br><br><br><br><br></font>
      </td>
    </tr>

    <tr>
      <td colspan="3" align="center">
        <table>
          <tr>
            <td nowrap>
              <font face="Arial, Helvetica, Sans-Serif" size="2">
                <a href="players.php" STYLE="color: $sText">ALL</a> | <a href="players.php?fn=A" STYLE="color: $sText">A</a>
                | <a href="players.php?fn=B" STYLE="color: $sText">B</a> | <a href="players.php?fn=C" STYLE="color: $sText">C</a> 
                | <a href="players.php?fn=D" STYLE="color: $sText">D</a> | <a href="players.php?fn=E" STYLE="color: $sText">E</a> 
                | <a href="players.php?fn=F" STYLE="color: $sText">F</a> | <a href="players.php?fn=G" STYLE="color: $sText">G</a> 
                | <a href="players.php?fn=H" STYLE="color: $sText">H</a> | <a href="players.php?fn=I" STYLE="color: $sText">I</a> 
                | <a href="players.php?fn=J" STYLE="color: $sText">J</a> | <a href="players.php?fn=K" STYLE="color: $sText">K</a> 
                | <a href="players.php?fn=L" STYLE="color: $sText">L</a> | <a href="players.php?fn=M" STYLE="color: $sText">M</a> 
                | <a href="players.php?fn=N" STYLE="color: $sText">N</a> | <a href="players.php?fn=O" STYLE="color: $sText">O</a> 
                | <a href="players.php?fn=P" STYLE="color: $sText">P</a> | <a href="players.php?fn=Q" STYLE="color: $sText">Q</a> 
                | <a href="players.php?fn=R" STYLE="color: $sText">R</a> | <a href="players.php?fn=S" STYLE="color: $sText">S</a> 
                | <a href="players.php?fn=T" STYLE="color: $sText">T</a> | <a href="players.php?fn=U" STYLE="color: $sText">U</a> 
                | <a href="players.php?fn=V" STYLE="color: $sText">V</a> | <a href="players.php?fn=W" STYLE="color: $sText">W</a> 
                | <a href="players.php?fn=X" STYLE="color: $sText">X</a> | <a href="players.php?fn=Y" STYLE="color: $sText">Y</a> 
                | <a href="players.php?fn=Z" STYLE="color: $sText">Z</a>
              </font>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr> 
      <td align="left" colspan="3" bgcolor="#32605e">
        <font color=white>&nbsp;&nbsp;<b>Total Players:</b> $totalplayers &nbsp;<b>Total Public Players:</b> $totalpublic</font>
      </td>
    </tr>
    <tr>
      <td colspan="3">

EOF;

if ($tp - $players_perpage >= 0) {
	$num = $tp - $players_perpage;
	echo "        <a href=\"players.php?tp=$num&fn=$fn\"><img src=\"images/items/back.jpg\" border=\"0\"></a>\n";
} else
	echo "        &nbsp; &nbsp;";

$page = intval($tp / $players_perpage) + 1;
$pages = ceil($totalplayers / $players_perpage);
if ($pages > 1)
	echo " <font size=\"-1\" face=\"Verdana\">Page [$page/$pages]</font> ";

// Players
$result = sql_query($link, "SELECT char_id,char_name,char_nototitle,char_public,accesslevel FROM myrunuo_characters $where ORDER by char_name LIMIT $tp,$players_perpage");
$num = mysql_numrows($result);

if ($tp + $players_perpage < $totalplayers) {
	$num = $tp + $players_perpage;
	echo "        <a href=\"players.php?tp=$num&fn=$fn\"><img src=\"images/items/next.jpg\" border=\"0\"></a>\n";
}

echo <<<EOF
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <table>

EOF;

if ($num) {
	while ($row = mysql_fetch_row($result)) {
		$id = $row[0];
		$charname = $row[1];
		$temp = $row[2];
		$accesslevel = $row[4];
		if ($accesslevel == 4) {
			$charname = "*Admin" . " " . $row[1];
			$temp = "*Admin" . " " . $row[1];
		} else if ($accesslevel == 3) {
			$charname = "*Seer" . " " . $row[1];
			$temp = "*Seer" . " " . $row[1];
		} else if ($accesslevel == 2) {
			$charname = "*GM" . " " . $row[1];
			$temp = "*GM" . " " . $row[1];
		} else if ($accesslevel == 1) {
			$charname = "*Counselor" . " " . $row[1];
			$temp = "*Counselor" . " " . $row[1];
		}

		echo <<<EOF
          <tr>
            <td width="120">
              <a href="player.php?id=$id">$charname</a>
            </td>
            <td>
              $temp
            </td>
          </tr>

EOF;
	}
} else {
	echo <<<EOF
          <tr>
            <td colspan="3">No players could be found.</td>
          </tr>

EOF;
}

echo <<<EOF
        </table>
      </td>
    </tr>

EOF;

mysql_free_result($result);
mysql_close($link);

if ($timestamp != "")
	$dt = date("F j, Y, g:i a", strtotime($timestamp));
else
	$dt = date("F j, Y, g:i a");

echo <<<EOF
  <tr>
    <td colspan="3">&nbsp;<br></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#32605e" colspan="3">
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