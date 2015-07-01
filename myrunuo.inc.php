<?php
include  "database.php";
// Edit your database settings:
// Edit path of .mul files: gumpart.mul gumpidx.mul hues.mul tiledata.mul
$mulpath = "uofiles/";

// Edit hosts allowed to direct to the paperdoll generator or leave blank to allow any
// Example: $validhosts = "http://www.myhost.com http://myhost.com";
$validhosts = "";

// Edit to control number of lines of data per page:
$status_perpage = 30;
$players_perpage = 20;
$guilds_perpage = 20;

// *** End of configuration options ***


$skillnames = array("Alchemy","Anatomy","Animal Lore","Item ID","Arms Lore","Parrying","Begging","Blacksmithing","Bowcraft","Peacemaking","Camping","Carpentry","Cartography","Cooking","Detecting Hidden","Enticement","Evaluating Intel","Healing","Fishing","Forensics","Herding","Hiding","Provocation","Inscription","Lock Picking","Magery","Magic Resistance","Tactics", "Snooping","Musicianship","Poisoning","Archery","Spirit Speak","Stealing","Tailoring","Taming","Taste ID","Tinkering","Tracking","Veterinary","Swordsmanship","Macefighting","Fencing","Wrestling","Lumberjacking","Mining","Meditation","Stealth","Remove Trap","Necromancy","Focus","Chivalry","Bushido","Ninjitsu","Spellweaving","Mysticism","Imbuing", "Throwing");

function sql_connect()
{
  global $SQLhost, $SQLport, $SQLdb, $SQLuser, $SQLpass;

  if ($SQLport != "")
    $link = @mysql_connect("$SQLhost:$SQLport","$SQLuser","$SQLpass");
  else
    $link = @mysql_connect("$SQLhost","$SQLuser","$SQLpass");
  if (!$link) {
    echo "Database access error ".mysql_errno().": ".mysql_error()."\n";
    die();
  }
  $result = mysql_select_db("$SQLdb");
  if (!$result) {
    echo "Error ".mysql_errno($link)." selecting database '$SQLdb': ".mysql_error($link)."\n";
    die();
  }
  return $link;
}

function sql_query($link, $query)
{
  global $SQLhost, $SQLport, $SQLdb, $SQLuser, $SQLpass;

  $result = mysql_query("$query", $link);
  if (!$result) {
    echo "Error ".mysql_errno($link).": ".mysql_error($link)."\n";
    die();
  }
  return $result;
}
function sql_connectDB($SQLdb)
{
  global $SQLhost, $SQLport, $SQLuser, $SQLpass;

  if ($SQLport != "")
    $link = @mysql_connect("$SQLhost:$SQLport","$SQLuser","$SQLpass");
  else
    $link = @mysql_connect("$SQLhost","$SQLuser","$SQLpass");
  if (!$link) {
    echo "Database access error ".mysql_errno().": ".mysql_error()."\n";
    die();
  }
  $result = mysql_select_db("$SQLdb");
  if (!$result) {
    echo "Error ".mysql_errno($link)." selecting database '$SQLdb': ".mysql_error($link)."\n";
    die();
  }
  return $link;
}
function check_get(&$store, $val)
{
  $magic = get_magic_quotes_gpc();
  if (isset($_POST["$val"])) {
    if ($magic)
      $store = stripslashes($_POST["$val"]);
    else
      $store = $_POST["$val"];
  }
  else if (isset($_GET["$val"])) {
    if ($magic)
      $store = stripslashes($_GET["$val"]);
    else
      $store = $_GET["$val"];
  }
}

?>