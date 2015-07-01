<?php

require("myrunuo.inc.php");

check_get($id, "id");
$id = intval($id);

/*check_get($nc, "nc");
$nc = intval($nc);

check_get($guild, "g");
$guild = htmlspecialchars($guild);*/


$link = sql_connect();

// Skills timestamp
$result = sql_query($link, "SELECT time_datetime FROM myrunuo_timestamps WHERE time_type='Skills'");
if (!(list($timestamp) = mysql_fetch_row($result)))
	$timestamp = "";
mysql_free_result($result);

if ($id) {
	$result = sql_query($link, "SELECT char_name,char_public,char_female FROM myrunuo_characters WHERE char_id=$id");
	if (!(list($charname, $public, $sex) = mysql_fetch_row($result))) {
		echo "Invalid character ID!\n";
		die();
	}
}


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
  <link rel="stylesheet" type="text/css" href="style.css"/> 
  <link href="styles.css" rel="stylesheet" type="text/css" /> 
  <title>$charname Webpage</title>
  <meta http-equiv="Content-Type" content="text/html; CHARSET=iso-8859-1">
</head>
<body bgcolor="#ffffff" text="#000000">
<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr align="center" valign="middle"> 
       <td>
      <font size="3" face="Arial, Helvetica, sans-serif"><a href="status.php"><b>Online Players</b></a></font>
    </td>
    <td>
      <font size="3" face="Arial, Helvetica, sans-serif"><a href="players.php"><b>View Players</b></a></font>
    </td>
    <td>
      <font size="3" face="Arial, Helvetica, sans-serif"><a href="searchplayers.php"><b>Search Players</b></a></font>
    </td>
    <td>
      <font size="3" face="Arial, Helvetica, sans-serif"><a href="guilds.php"><b>View Guilds</b></a></font>
    </td>
  </tr>
</table>
<br>
<body bgcolor="#ffffff" text="#000000">

<table cellspacing="0" cellpadding="0" width="480" border="0">
  <tbody>
    <tr> 
      <td bgcolor="#32605e" colspan="2">
        <font face="Verdana" size="-1" color="#ffffff"><b> Overall Skills for <span class="class1"><A HREF="player.php?id=$id">$charname</span></a></b></font>
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
if ($sex = 1)
	$sex1 = "her";
else
	$sex1 = "his";
/*$result = sql_query($link, "SELECT skill_id,SUM(skill_value) AS totalskill_value
                    FROM myrunuo_characters LEFT JOIN myrunuo_characters_skills ON myrunuo_characters.char_id=myrunuo_characters_skills.char_id
                    WHERE char_guild=$id GROUP BY skill_id");*/ // AND char_public=1
if ($public == 1) {
	$result = sql_query($link, "SELECT skill_id,skill_value FROM myrunuo_characters_skills WHERE char_id=$id");

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
					$val = sprintf("%0.1f", $row[1] /*/ $nc*/ / 10);
				} else
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
} else
	echo "This character has chosen to not display $sex1 skills.";
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
</center>
</body>
</html>

EOF;

?>