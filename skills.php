<?php

include_once "SQL.php";
$skillnames = array("Alchemy", "Anatomy", "Animal Lore", "Item Identification", "Arms Lore", "Parrying", "Begging", "Blacksmithing", "Bowcraft", "Peacemaking", "Camping", "Carpentry", "Cartography", "Cooking", "Detecting Hidden", "Enticement", "Evaluating Intelligence", "Healing", "Fishing", "Forensic Evaluation", "Herding", "Hiding", "Provocation", "Inscription", "Lockpicking", "Magery", "Magic Resistance", "Tactics", "Snooping", "Musicianship", "Poisoning", "Archery", "Spirit Speak", "Stealing", "Tailoring", "Taming", "Taste ID", "Tinkering", "Tracking", "Veterinary", "Swordsmanship", "Mace fighting", "Fencing", "Wrestling", "Lumberjacking", "Mining", "Meditation", "Stealth", "Remove Trap", "Necromancy", "Focus", "Chivalry", "Bushido", "Ninjitsu", "Spellweaving", "Mysticism", "Imbuing", "Throwing");
if (!isset($_GET["id"]))
	$id = 0;
else
	$id = $_GET["id"];

if (!isset($_GET["nc"]))
	$nc = 0;
else
	$nc = $_GET["nc"];

if (!isset($_GET["g"]))
	$guild = 0;
else
	$guild = $_GET["g"];

$guild = htmlspecialchars($guild);

$sql = SQL::getConnection();

// Skills timestamp
$result = $sql->query("SELECT time_datetime FROM myrunuo_timestamps WHERE time_type = 'Guild'");
$row = $result->fetch_assoc();
$timestamp = $row["time_datetime"];

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

$result = $sql->query("
					SELECT skill_id, SUM(skill_value) AS totalskill_value
                    FROM myrunuo_characters LEFT JOIN myrunuo_characters_skills ON myrunuo_characters.char_id = myrunuo_characters_skills.char_id
                    WHERE char_guild = $id GROUP BY skill_id");

$skillId = -1;
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
                <font face="Verdana" size="-1"><a href="http://www.uoguide.com/$skillnames[$i]">$skillnames[$i]</a></font>
              </td>
              <td align="right">
                <font face="Verdana" size="-1">&nbsp;&nbsp;

EOF;

		if ($skillId < $i) {
			if ($row = $result->fetch_assoc()) {
				$skillId = intval($row["skill_id"]);
				$skillValue = sprintf("%0.1f", $row["totalskill_value"] / $nc / 10);
			} else
				$skillId = 99;
		}
		if ($i == $skillId)
			echo "$skillValue";
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
	<img src="./images/footer_a.jpg" alt="" /><img src="./images/footer_b.jpg" alt="" /><img src="./images/footer_c.jpg" alt="" /><img src="./images/footer_d.jpg" alt="" />
	</div> 
</div> 
 
</div> 
</body>
</center>
</html>

EOF;

?>