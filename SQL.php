<?php
include_once "database.php";
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