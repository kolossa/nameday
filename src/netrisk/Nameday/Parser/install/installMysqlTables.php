<?php 

require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');

$config=require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'db.php');

$connection=netrisk\Nameday\Parser\database\MySqlConnection::getInstance();

$pdo=$connection->getPdo();

echo 'start creating database'.PHP_EOL;
$pdo->exec("CREATE DATABASE IF NOT EXISTS netrisk");
$pdo->exec("USE netrisk");
echo 'database is created'.PHP_EOL;

echo PHP_EOL;

echo 'start creating names table'.PHP_EOL;
$pdo->exec("CREATE TABLE IF NOT EXISTS names(
	id int primary key auto_increment, 
	name varchar(255),
	INDEX (name)
)");
echo 'names table is created'.PHP_EOL;

echo PHP_EOL;

echo 'start creating dates table'.PHP_EOL;
$pdo->exec("CREATE TABLE IF NOT EXISTS dates(
	id int primary key auto_increment, 
	`date` varchar(255),
	main boolean,
	name_id int,
	FOREIGN KEY (name_id) REFERENCES names(id),
	INDEX (`date`)
)");
echo 'names table is created'.PHP_EOL;

echo PHP_EOL;