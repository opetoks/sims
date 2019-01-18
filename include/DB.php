<?php class DB
{
	private static $_instance = null;
	private $_pdo, $_query, $_error = false, $_results, $_resultsArray, $_lastId,$_count = 0, $_queryCount = 0; 
	public $num_rows = 0;
	private function __construct()
	{
		try
		{
			$this->_pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
			$this->_pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET SESSION sql_mode = ''");
			$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}
	public static function getInstance()
	{
		if (!isset(self::$_instance))
			self::$_instance = new DB();
		return self::$_instance;
	}
}
  ?>
