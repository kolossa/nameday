<?php 

namespace netrisk\Nameday\Parser\database;

class MySqlConnection{
	
	private $pdoObject;
	private static $instance=null;
	
	public static function getInstance(){
		
		if(self::$instance==null){
			self::$instance=new MySqlConnection();
			
			$configPath=__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php';
			$config=include($configPath);
			self::$instance->pdoObject = new \PDO($config['mysql']['dsn'], $config['mysql']['username'], $config['mysql']['password']);
			self::$instance->pdoObject->exec("USE netrisk");
			self::$instance->pdoObject->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
		}
		
		return self::$instance;
	}
	
	private function __construct(){
	}
	
	public function getPdo(){
		return $this->pdoObject;
	}
}