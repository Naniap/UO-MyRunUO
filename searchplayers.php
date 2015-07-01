<?php
require("myrunuo.inc.php");
//added
check_get($id, "id");
$id = intval($id);
//end

$msg = "";
// Check for sumitted response
check_get($submit, "submit");
if ($submit != "") {
	// Get name user is searching for
	check_get($player, "charname");

	// If the name input is less than 3 characters then flag error
	if (strlen($player) < 3)
		$msg = "<font face=\"Arial\" size=\"2\" size=\"3\">ERROR:</font><br>You must enter the name of the character you wish to search for. The name must be at least three letters long.</font><br>";
	else {
		// Setup exact / beginning name search
		$front = "LIKE '";
		$back = "'";

		check_get($which, "which");
		if ($which == "0") {
			$front = "LIKE '%";
			$back = "%'";
		}
		$link = sql_connect();


		$player = addslashes($player);
		$result = sql_query($link, "SELECT char_id,char_name FROM myrunuo_characters WHERE char_name {$front}{$player}{$back} ORDER by char_name"); // char_public=1 AND
		//$msg = "Your search returned the following characters:<br>\n";

		if (mysql_numrows($result)) {
			// Cycle through all records and display hyper link with shard player
			while ($row = mysql_fetch_row($result)) {
				$id = intval($row[0]);
				$name = htmlspecialchars($row[1]);
				//$msg .= "<a href=\"player.php?id=$id\">$name</a><br>\n";
				$msg .= "<tr><td class=\"entry\"><a href=\"player.php?id=$id\">$name</a></td>";
			}
		} else
			$msg .= "<font face=\"Arial\" size=\"2\">No characters with that name found.</font>\n";
		mysql_free_result($result);
		mysql_close($link);
	}
}

echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
 <title>Search Players</title> 
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
<table cellspacing="2" cellpadding="2" width="100%"> 
<tr> 
<td> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm">
<h2>Player Search</h2>

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
</font>
	
</td> 
		<td class="section-mr"></td>
	</tr> 
	<tr><td class="section-bl"></td><td class="section-bm"></td><td class="section-br"></td></tr> 
</table><div class="separator"></div> </td> 
</tr> 
 
<tr> 
<td> 
<table cellpadding="0" cellspacing="0" class="section"> 
	<tr><td class="section-tl"></td><td class="section-tm"></td><td class="section-tr"></td></tr> 
	<tr> 
		<td class="section-ml"></td> 
		<td class="section-mm"><fieldset> 
<legend>Search results for "$player"</legend> 
<table cellpadding="3" cellspacing="1" width="100%"> 
	<tr> 
		<td class="header">Player</td> 
		<!-- <td class="header" align="center">Guild</td> -->
	</tr>	
  $msg
  <!-- <td class="entry" align="center">$guild</td> -->
</table>
   <!-- added end-->
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
</html> 

EOF;
?>