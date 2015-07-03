<?php

include_once "SQL.php";

function skillname($skillId, $skill) {
	global $skillnames;

	if ($skill / 10 >= 100)
		$temp = "Grandmaster:<br>";
	else
		$temp = "";
	$skillname = /*$temp .*/
		$skillnames[$skillId];

	return $skillname;
}

check_get($id, "id");
$id = intval($id);

echo <<<EOF
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
  <title>View Player</title>
  <meta http-equiv="Content-Type" content="text/html; CHARSET=iso-8859-1">
  <link rel="stylesheet" type="text/css" href="style.css"/> 
  <link href="styles.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
EOF;
$sql = SQL::getConnection();
$result = $sql->query("SELECT serial, accounts.accounts.id, lastlogin, myrunuo_characters.char_id, accounts.characters.id FROM accounts.characters, accounts.accounts, myrunuo.myrunuo_characters WHERE accounts.characters.id = accounts.accounts.id AND SERIAL = myrunuo_characters.char_id AND myrunuo_characters.char_id = $id");
$row = $result->fetch_assoc();
$serial = $row["serial"];
$charId = $row["char_id"];
$lastLogin = $row["lastlogin"];

if ($lastLogin != "")
	$dt = date("F j, Y, g:i a", strtotime($lastLogin));
else
	$dt = date("F j, Y, g:i a");
$lastonline = "<tr><td><label for=\"name-value\">Last Login:</label></td><td id=\"name-value\" align=\"right\">$dt</td></tr>";

$result = $sql->query("SELECT myrunuo_guilds.guild_id, myrunuo_guilds.guild_name, myrunuo_characters.char_guildtitle FROM myrunuo_characters INNER JOIN myrunuo_guilds ON myrunuo_characters.char_guild = myrunuo_guilds.guild_id WHERE myrunuo_characters.char_id = $id");
$row = $result->fetch_assoc();
$guildId = $row["guild_id"];
$guildName = $row["guild_name"];
$guildTitle = $row["char_guildtitle"];

if ($id) {
	$result = $sql->query("SELECT char_name, char_nototitle, char_female, char_counts, char_str, char_dex, char_int, char_public, char_faction, char_skillsum, char_statsum, rank, level, wins, losses, accesslevel FROM myrunuo_characters WHERE char_id = $id");
	$row = $result->fetch_assoc();
	$charName = $row["char_name"];
	$charTitle = $row["char_nototitle"];
	$sex = $row["char_female"];
	$kills = $row["char_counts"];
	$str = $row["char_str"];
	$dex = $row["char_dex"];
	$int = $row["char_int"];
	$public = $row["char_public"];
	$factionValue = $row["char_faction"];
	$skillSum = $row["char_skillsum"];
	$statSum = $row["char_statsum"];
	$rank = $row["rank"];
	$level = $row["level"];
	$wins = $row["wins"];
	$losses = $row["losses"];
	$accountLevel = $row["accesslevel"];
	if (!isset($charName))
		$charName = "Invalid character.";

	$skillSum = number_format($skillSum / 10, 1, ".", "");

	if ($public == 1)
		$strng = "Yes.";
	else
		$strng = "No.";
	if ($accountLevel == 4)
		$accessLevel = "Administrator";
	else if ($accountLevel == 3)
		$accessLevel = "Seer";
	else if ($accountLevel == 2)
		$accessLevel = "Game Master";
	else if ($accountLevel == 1)
		$accessLevel = "Counselor";
	if ($factionValue == 1)
		$faction = "Minax";
	else if ($factionValue == 2)
		$faction = "Shadowlords";
	else if ($factionValue == 3)
		$faction = "True Britannians";
	else if ($factionValue == 4)
		$faction = "Council Of Mages";
	else
		$faction = "";
	$isFaction = "";
	if ($factionValue >= 1)
		$isFaction = "Faction";


	$factions = "<tr><td><label for=\"name-value\">$isFaction</label></td><td id=\"name-value\" align=\"right\">$faction</td></tr>";

	if ($sex == 1)
		$sex1 = "her";
	else
		$sex1 = "his";

	if ($accountLevel > 0)
		$showacclvl = "<tr><td><label for=\"name-value\">Staff Position:</label></td><td id=\"name-value\" align=\"right\">$accessLevel</td></tr>";
	if ($guildName != ("" || NULL)) {
		$gid1 = "<a href=guild.php?id=$guildId>$guildName</a>";
		$guildName = "<tr><td><label for=\"name-value\">Guild:</label></td><td id=\"name-value\" align=\"right\">$gid1</td></tr>";
	}
	if ($guildTitle != ("" || NULL)) {
		$guildTitle = "<tr><td><label for=\"name-value\">Guild Title:</label></td><td id=\"name-value\" align=\"right\">$guildTitle</td></tr>";
	}
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

	$ordinalrank = addOrdinalNumberSuffix($rank);

	if ($public == 1) {
		echo <<<EOF
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
		<td valign="top"> 
			<table cellspacing="2" cellpadding="2" width="100%"> 
				<tr> 
					<td valign="top"> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm">						<!-- general information --> 
						<fieldset> 
							<legend>General Information</legend> 
							<table cellpadding="3" cellspacing="1" width="100%"> 
								<tr> 
									<td><label for="name-value">Name:</label></td> 
									<td id="name-value" align="right">$charName</td> 
								</tr> 
     							$showacclvl
							$lastonline
							$guildName
							$guildTitle
							$factions
																									</table> 
						</fieldset> 
						<!-- /general information --> 
 
						<fieldset> 
							<legend>Attributes</legend> 
							<table cellpadding="3" cellspacing="1" width="100%"> 
								<tr> 
									<td><label for="strength-value">Strength</label></td> 
									<td id="strength-value" align="right">$str</td> 
								</tr> 
								<tr> 
									<td><label for="dexterity-value">Dexterity</label></td> 
									<td id="dexterity-value" align="right">$dex</td> 
								</tr> 
								<tr> 
									<td><label for="intelligence-value">Intelligence</label></td> 
									<td id="intelligence-value" align="right">$int</td> 
								</tr> 
							</table> 
						</fieldset> 
 
						<fieldset> 
							<legend>Skills</legend> 
							<table cellpadding="3" cellspacing="1" width="100%"> 


EOF;
	} else
		echo <<<html
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
		<td valign="top"> 
			<table cellspacing="2" cellpadding="2" width="100%"> 
				<tr> 
					<td valign="top"> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm">						<!-- general information --> 
						<fieldset> 
							<legend>General Information</legend> 
							<table cellpadding="3" cellspacing="1" width="100%"> 
								<tr> 
									<td><label for="name-value">Name</label></td> 
									<td id="name-value" align="right">$charName</td> 
								</tr> 	
							$guildName
							$factions																								</table> 
						</fieldset> 
						<!-- /general information --> 
 
						<fieldset> 
							<legend>Character Class</legend> 
							<table cellpadding="3" cellspacing="1" width="100%"> 
								<tr> 
									<td><em>$charName has chosen not to reveal this information.</em></td> 
								</tr> 
							</table> 
						</fieldset> 
 
						<fieldset> 
							 
							<table cellpadding="3" cellspacing="1" width="100%"> 
html;
	if ($public == 1) {
		$result = $sql->query("SELECT skill_id, skill_value FROM myrunuo_characters_skills WHERE char_id = $id ORDER BY skill_value DESC LIMIT 54");
		$num = 0;
		$skillSum = 0;
		while (($row = $result->fetch_assoc()) && $skillSum <= 600) {
			$skillId = $row['skill_id'];
			$skill = $row['skill_value'];
			$name = skillname($skillId, $skill);

			// Fix for swapped skill IDs
			if ($skillId == 47)
				$skillId = 48;
			else if ($skillId == 48)
				$skillId = 47;


			//$image = skillimage($skillId, $skill);
			$skill = number_format($skill / 10, 1, ".", "");

			echo <<<EOF
    <tr><td><label for="skill-value-$num"><a href="http://www.uoguide.com/$name">$name</a></label></td><td id="skill-value-$num" align="right">$skill</td></tr>
EOF;

			$skillSum += $skill;
			$num++;
		}
	} else
		echo "";
	echo <<<html
								<!--<tr> 
									<td><label for="skill-value-1">$name</label></td> 
									<td id="skill-value" align="right">$skill</td> 
								</tr> -->
								<!-- <tr> 
									<td><label for="skill-value-2">Inscription</label></td> 
									<td id="skill-value-2" align="right">100.0</td> 
								</tr> 
								<tr> 
									<td><label for="skill-value-3">Magery</label></td> 
									<td id="skill-value-3" align="right">100.0</td> 
								</tr> 
								<tr> 
									<td><label for="skill-value-4">Resisting Spells</label></td> 
									<td id="skill-value-4" align="right">100.0</td> 
								</tr> 
								<tr> 
									<td><label for="skill-value-5">Tactics</label></td> 
									<td id="skill-value-5" align="right">100.0</td> 
								</tr> 
								<tr> 
									<td><label for="skill-value-6">Wrestling</label></td> 
									<td id="skill-value-6" align="right">100.0</td> 
								</tr> 
								<tr> 
									<td><label for="skill-value-7">Meditation</label></td> 
									<td id="skill-value-7" align="right">100.0</td> 
								</tr> -->
							</table> 
						</fieldset> 
						<!-- /character class --> 
		</td> 
		<td class="section-mr"></td> 
	</tr> 
	<tr><td class="section-bl"></td><td class="section-bm"></td><td class="section-br"></td></tr> 
</table>	
				<div class="separator"></div> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm">						
						<fieldset> 
							<legend>Dueling Statistics</legend> 
							<table cellpadding="3" cellspacing="1" width="100%"> 
								<tr> 
									<td><label for="rank-value">Rank</label></td> 
									<td id="rank-value" align="right">$ordinalrank</td> 
								</tr> 
								<tr> 
									<td><label for="level-value">Level</label></td> 
									<td id="level-value" align="right">$level</td> 
								</tr> 
								<tr> 
									<td><label for="wins-value">Wins</label></td> 
									<td id="wins-value" align="right">$wins</td> 
								</tr> 
								<tr> 
									<td><label for="losses-value">Losses</label></td> 
									<td id="losses-value" align="right">$losses</td> 
								</tr> 
							</table> 
						</fieldset> 
						
		</td> 
		<td class="section-mr"></td> 
	</tr> 
	<tr><td class="section-bl"></td><td class="section-bm"></td><td class="section-br"></td></tr> 
</table>						<div class="separator"></div> 
			</td>
					<td valign="top" style="width: 314px"> 
						<div class="player-view"> 
							<!-- paperdoll --> 
							<div class="paperdoll"><img style=”border: none;” src="paperdoll.php?id=$id" alt="Paperdoll of $charName" /></div> 
							<!-- /paperdoll --> 
						</div> 
					</td> 
				</tr> 
			</table> 
		</td> 
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
html;

	while ($num < 3) {
		echo "    <td>&nbsp;</td>\n";
		$num++;
	}
	echo "  </tr>\n";
}
?>
</table>
</body>
</center>
</html>