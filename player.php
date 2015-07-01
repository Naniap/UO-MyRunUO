<?php

require("myrunuo.inc.php");

/*function skillimage($skillid, $skill)
{
  if ($skill / 10 >= 100)
    $temp = "g";
  else
    $temp = "";
  $skillimage = "images/skills/{$skillid}{$temp}.gif";

  return $skillimage;
}*/

function skillname($skillid, $skill)
{
  global $skillnames;

  if ($skill / 10 >= 100)
    $temp = "Grandmaster:<br>";
  else
    $temp = "";
  $skillname = /*$temp .*/ $skillnames[$skillid];

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
$link2 = sql_connectDB("accounts");
$result = sql_query($link2, "SELECT SERIAL, accounts.accounts.id, lastlogin, myrunuo_characters.char_id, accounts.characters.id FROM accounts.characters, accounts.accounts, myrunuo.myrunuo_characters WHERE accounts.characters.id = accounts.accounts.id AND SERIAL = myrunuo_characters.char_id AND myrunuo_characters.char_id=$id");
  if (!(list($serial,$charid,$lastlogin) = mysql_fetch_row($result))) {
	  }
if ($lastlogin != "")
  $dt = date("F j, Y, g:i a", strtotime($lastlogin));
else
  $dt = date("F j, Y, g:i a");
$lastonline = "<tr><td><label for=\"name-value\">Last Login:</label></td><td id=\"name-value\" align=\"right\">$dt</td></tr>";

mysql_free_result($result);  
mysql_close($link2);
$link = sql_connect();

 $gid1 = sql_query($link, "SELECT myrunuo_guilds.guild_id,myrunuo_guilds.guild_name, myrunuo_characters.char_guildtitle FROM myrunuo_characters INNER JOIN myrunuo_guilds ON myrunuo_characters.char_guild=myrunuo_guilds.guild_id WHERE myrunuo_characters.char_id=$id");
  if (list($gid,$guild,$guildtitle) = mysql_fetch_row($gid1)) 
    $gid = intval($gid);

if ($id) {
  $result = sql_query($link, "SELECT char_name,char_nototitle,char_female,char_counts,char_str,char_dex,char_int,char_public,char_faction,char_skillsum,char_statsum,rank,level,wins,losses,accesslevel FROM myrunuo_characters WHERE char_id=$id");
  if (!(list($charname,$chartitle,$sex,$kills,$str,$dex,$int,$public,$fac,$skillsum,$statsum,$rank,$level,$wins,$losses,$acclvl) = mysql_fetch_row($result))) {
    //echo "Invalid character ID!\n";
    $charname = "Invalid character!";
    //die();
  }
  mysql_free_result($result);  
  
  $skillsum = number_format($skillsum/10, 1,".", "");

  if ( $public == 1 )
     $strng = "Yes.";
  else
     $strng = "No.";
  if ($acclvl == 4)
     $accesslevel = "Administrator";
  else if ($acclvl == 3)
     $accesslevel = "Seer";
  else if ($acclvl == 2)
     $accesslevel = "Game Master";
  else if ($acclvl == 1)
     $accesslevel = "Counselor";
  if ( $fac == 1 )
    $faction = "Minax";
  else if ( $fac == 2 )
    $faction = "Shadowlords";
  else if ( $fac == 3 )
    $faction = "True Britannians";
  else if ( $fac == 4 )
    $faction = "Council Of Mages";
  else 
    $faction = "";

  if ( $fac >= 1 )
     $isfaction = "Faction"; 

  $factions = "<tr><td><label for=\"name-value\">$isfaction</label></td><td id=\"name-value\" align=\"right\">$faction</td></tr>";

  if ( $sex == 1 )
    $sex1 = "her";
  else 
    $sex1 = "his";

  if ( $acclvl > 0 )
     $showacclvl = "<tr><td><label for=\"name-value\">Staff Position:</label></td><td id=\"name-value\" align=\"right\">$accesslevel</td></tr>";
  if ( $guild != ("" || NULL) )
  {
     $gid1 = "<a href=guild.php?id=$gid>$guild</a>";
     $guild = "<tr><td><label for=\"name-value\">Guild:</label></td><td id=\"name-value\" align=\"right\">$gid1</td></tr>";
  }
  if ( $guildtitle != ("" || NULL) )
  {
     $guildtitle = "<tr><td><label for=\"name-value\">Guild Title:</label></td><td id=\"name-value\" align=\"right\">$guildtitle</td></tr>";
  }
  function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }
  $ordinalrank = addOrdinalNumberSuffix($rank);

if ( $public == 1 )
{
  echo <<<EOF
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
									<td id="name-value" align="right">$charname</td> 
								</tr> 
     							$showacclvl
							$lastonline
							$guild
							$guildtitle
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
}
else
echo <<<html
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
									<td id="name-value" align="right">$charname</td> 
								</tr> 	
							$guild
							$factions																								</table> 
						</fieldset> 
						<!-- /general information --> 
 
						<fieldset> 
							<legend>Character Class</legend> 
							<table cellpadding="3" cellspacing="1" width="100%"> 
								<tr> 
									<td><em>$charname has chosen not to reveal this information.</em></td> 
								</tr> 
							</table> 
						</fieldset> 
 
						<fieldset> 
							 
							<table cellpadding="3" cellspacing="1" width="100%"> 
html;
if ($public == 1)
{
  $result = sql_query($link, "SELECT skill_id,skill_value FROM myrunuo_characters_skills WHERE char_id=$id ORDER BY skill_value DESC LIMIT 54");
  $num = 0;
  $skillsum = 0;
  while ((list($skillid,$skill) = mysql_fetch_row($result)) && $skillsum <= 600) 
  {
    $skillid = intval($skillid);
    $skill = intval($skill);
    $name = skillname($skillid, $skill);

    // Fix for swapped skill IDs
    if ($skillid == 47)
      $skillid = 48;
    else if ($skillid == 48)
      $skillid = 47;


	
    //$image = skillimage($skillid, $skill);
    $skill = number_format($skill/10, 1,".", "");

    echo <<<EOF
    <tr><td><label for="skill-value-$num">$name</label></td><td id="skill-value-$num" align="right">$skill</td></tr>
     <!-- <td align="center" valign="top">
	 <table><font face="Arial" size="2">$name: $skill</font></table>
    </td> -->

EOF;

    $skillsum += $skill;
    $num++;
  }
  mysql_free_result($result);
}
else
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
<!-- <table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm">						
						<fieldset> 
							 <legend>Videos</legend> 
							<table cellpadding="3" cellspacing="1"> 
								<tr> 
									<td align="right">1.</td> 
									<td><a href="http://videos.uogamers.com/view.php?videoId=366436">1v1 Mage 5x</a></td> 
								</tr> 
								<tr> 
									<td align="right">2.</td> 
									<td><a href="http://videos.uogamers.com/view.php?videoId=366413">1v1 Mage 5x</a></td> 
								</tr> 
								<tr> 
									<td align="right">3.</td> 
									<td><a href="http://videos.uogamers.com/view.php?videoId=366407">1v1 Mage 5x</a></td> 
								</tr> 
								<tr> 
									<td align="right">4.</td> 
									<td><a href="http://videos.uogamers.com/view.php?videoId=366404">1v1 Mage 5x</a></td> 
								</tr> 
								<tr> 
									<td align="right">5.</td> 
									<td><a href="http://videos.uogamers.com/view.php?videoId=366402">1v1 Mage 5x</a></td> 
								</tr> 
								<tr> 
									<td align="right">6.</td> 
									<td><a href="http://videos.uogamers.com/view.php?videoId=366388">1v1 Mage 5x</a></td> 
								</tr> 
								<tr> 
									<td align="right">7.</td> 
									<td><a href="http://videos.uogamers.com/view.php?videoId=366066">1v1 Mage 5x</a></td> 
								</tr> 
							</table> 
						</fieldset> 
						 
		</td> 
		<td class="section-mr"></td> 
	</tr> 
	<tr><td class="section-bl"></td><td class="section-bm"></td><td class="section-br"></td></tr> 
</table>	-->				</td> 
					<td valign="top" style="width: 314px"> 
						<div class="player-view"> 
							<!-- paperdoll --> 
							<div class="paperdoll"><img style=”border: none;” src="paperdoll.php?id=$id" alt="Paperdoll of $charname" /></div> 
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
	<img src="http://my.uoreplay.com/images/footer_a.jpg" alt="" /><img src="http://my.uoreplay.com/images/footer_b.jpg" alt="" /><img src="http://my.uoreplay.com/images/footer_c.jpg" alt="" /><img src="http://my.uoreplay.com/images/footer_d.jpg" alt="" /> 
	</div> 
</div> 
 
</div> 
html;

  while ($num < 3) {
    echo "    <td>&nbsp;</td>\n";
    $num++;
  }

  echo "  </tr>\n"; 
 /*$result = sql_query($link, "SELECT myrunuo_guilds.guild_id,myrunuo_guilds.guild_name FROM myrunuo_characters INNER JOIN myrunuo_guilds ON myrunuo_characters.char_guild=myrunuo_guilds.guild_id WHERE myrunuo_characters.char_id=$id");
  if (list($gid,$guild) = mysql_fetch_row($result)) {
    $gid = intval($gid);*/
    echo <<<EOF
<!--  <tr>
    <td align="center" colspan="3">
      <br><font face="Verdana, Arial" color="#000000" size="2"><b>Guild:</b> &nbsp; &nbsp;<a href="guild.php?id=$gid" style="color: Black">$guild</a></font>
    </td>
  </tr> -->

EOF;
}

mysql_close($link);


echo <<<EOF
</table>
</body>
</center>
</html>

EOF;

?>