<?php

require("myrunuo.inc.php");

check_get($id, "id");
$id = intval($id);

check_get($nc, "nc");
$nc = intval($nc);

check_get($guild, "g");
$guild = htmlspecialchars($guild);

$link = sql_connect();

// Skills timestamp
$result = sql_query($link, "SELECT time_datetime FROM myrunuo_timestamps WHERE time_type='Skills'");
if (!(list($timestamp) = mysql_fetch_row($result)))
  $timestamp = "";
mysql_free_result($result);

echo <<<EOF
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<style type="text/css">
.class1 A:link {text-decoration: underline; color: white;}
.class1 A:visited {text-decoration:underline; color: white;}
.class1 A:active {text-decoration: underline; color: red;}
.class1 A:hover {text-decoration: underline; color: red;}

.class2 A:link {text-decoration: underline overline}
.class2 A:visited {text-decoration: underline overline}
.class2 A:active {text-decoration: underline overline}
.class2 A:hover {text-decoration: underline; color: green;}
</style>
<html>
<center>
<head>
  <title>$guild Webpage</title>
  <meta http-equiv="Content-Type" content="text/html; CHARSET=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style.css"/> 
<link href="styles.css" rel="stylesheet" type="text/css" /> 
</head>
<body> 
<div align="center"> 
 
<div id="banner"><img src="../images/banner.jpg" alt="" /></div>jpg" alt="" /></div> 
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
<table cellspacing="0" cellpadding="0" width="480" border="0">
  <tbody>
    <tr> 
      <td bgcolor="#32605e" colspan="2">
        <font face="Verdana" size="-1" color="#ffffff"><b>Overall Skill Averages for <span class="class1"><A HREF="guild.php?id=$id">$guild</span></b></font>
      </td>
    </tr>
    <tr>
      <td colspan="2"><font size="1pt">&nbsp;</font></td>
    </tr>
    <tr>
      <td valign="top">
        <table cellspacing="0" cellpadding="0" border="0">
          <tbody>

EOF;

$result = sql_query($link, "SELECT skill_id,SUM(skill_value) AS totalskill_value
                    FROM myrunuo_characters LEFT JOIN myrunuo_characters_skills ON myrunuo_characters.char_id=myrunuo_characters_skills.char_id
                    WHERE char_guild=$id GROUP BY skill_id"); // AND char_public=1

$sid = -1;
for ($l = 0; $l < 2; $l++) {
  for ($i = 0 + ($l * 26); $i <= 25 + ($l * 26); $i++) {
    // Fix for swapped skill numbers
    if ($i == 47)
      $s = 48;
    else if ($i == 48)
      $s = 47;
    else
      $s = $i;

    echo <<<EOF
            <tr> 
              <td>
                <font face="Verdana" size="-1"><a href="http://guide.uo.com/skill_$s.html">$skillnames[$i]</a></font>
              </td>
              <td align="right">
                <font face="Verdana" size="-1">&nbsp;&nbsp;

EOF;

    if ($sid < $i) {
      if ($row = mysql_fetch_row($result)) {
        $sid = intval($row[0]);
        $val = sprintf("%0.1f", $row[1] / $nc / 10);
      }
      else
        $sid = 99;
    }
    if ($i == $sid)
      echo "$val";
    else
      echo "0";

    echo <<<EOF
                </font>
              </td>
            </tr>

EOF;
  }

  if (!$l) {
    echo <<<EOF
          </tbody>
        </table>
      </td>
      <td valign="top">
        <table cellspacing="0" cellpadding="0" border="0">
          <tbody>

EOF;
  }
}

mysql_free_result($result);
mysql_close($link);

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
      <td colspan="2"><font size="1pt">&nbsp;</font></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#32605e" colspan="2">
        <font face="Verdana" color="#ffffff" size="-1">&nbsp;&nbsp;<b>Last Updated:</b> $dt</font>
      </td>
    </tr>
  </tbody>
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