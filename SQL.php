<?php
include_once "database.php";
function check_get(&$store, $val) {
	$magic = get_magic_quotes_gpc();
	if (isset($_POST["$val"])) {
		if ($magic)
			$store = stripslashes($_POST["$val"]);
		else
			$store = $_POST["$val"];
	} else if (isset($_GET["$val"])) {
		if ($magic)
			$store = stripslashes($_GET["$val"]);
		else
			$store = $_GET["$val"];
	}
}
$skillnames = array("Alchemy", "Anatomy", "Animal Lore", "Item Identification", "Arms Lore", "Parrying", "Begging", "Blacksmithing", "Bowcraft", "Peacemaking", "Camping", "Carpentry", "Cartography", "Cooking", "Detecting Hidden", "Enticement", "Evaluating Intelligence", "Healing", "Fishing", "Forensic Evaluation", "Herding", "Hiding", "Provocation", "Inscription", "Lockpicking", "Magery", "Magic Resistance", "Tactics", "Snooping", "Musicianship", "Poisoning", "Archery", "Spirit Speak", "Stealing", "Tailoring", "Taming", "Taste ID", "Tinkering", "Tracking", "Veterinary", "Swordsmanship", "Mace fighting", "Fencing", "Wrestling", "Lumberjacking", "Mining", "Meditation", "Stealth", "Remove Trap", "Necromancy", "Focus", "Chivalry", "Bushido", "Ninjitsu", "Spellweaving", "Mysticism", "Imbuing", "Throwing");

class SQL {
	/**
	 * Uninstantiable
	 */
	CONST STATUSPERPAGE = 30;
	CONST PLAYERSPERPAGE = 20;
	CONST GUILDSPERPAGE = 20;
	private function __construct() {}
	private static $connection = null;
	/**
	 * Gets a connection to the MySQL database.
	 * @throws mysqli_sql_exception
	 * @return mysqli
	 */
	public static function getConnection() {
		if (is_null(SQL::$connection)) {
			SQL::$connection = new mysqli(Config::HOST, Config::USERNAME, Config::$password, Config::DATABASE);
			SQL::$connection->set_charset('utf8');
		}
		if (SQL::$connection->connect_error)
			throw new mysqli_sql_exception("Failed to connect to database: " . SQL::$connection->connect_error);
		return SQL::$connection;
	}
}
?>