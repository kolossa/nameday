<?php 

namespace netrisk\Nameday\Parser\controllers;

use netrisk\Nameday\Parser\model\MySqlNameRepository;
use netrisk\Nameday\Parser\database\MySqlConnection;
use netrisk\Nameday\Parser\model\Name;
use netrisk\Nameday\Parser\model\Date;

class DateController{

	public function getNames(){
		
		header('Content-Type: application/json');
		
		if(isset($_GET["date"])) {
			
			$date=new \DateTime($_GET['date']);
			
			$connection=MySqlConnection::getInstance();

			$pdo=$connection->getPdo();
			
			$repository=new MySqlNameRepository($pdo);
			
			
			$names=$repository->getNamesByDateTime($date);
			
			$result=[];
			
			foreach($names as $name){
				
				$result[$name->getId()]=$name->getName();
			}
			
			echo json_encode( $result);
		}
	}
}