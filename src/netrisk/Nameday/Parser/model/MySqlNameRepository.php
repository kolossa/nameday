<?php 

namespace netrisk\Nameday\Parser\model;

class MySqlNameRepository{
	
	private $pdo;
	
	public function __construct(\PDO $pdo){
		$this->pdo=$pdo;
	}
	
	public function insert(Name $name):void{
		
		$stmt = $this->pdo->prepare("INSERT INTO names VALUES(?,?)");
		$stmt->execute([$name->getId(), $name->getName()]);
		
		foreach($name->getDates() as $date){
			
			$stmt = $this->pdo->prepare("INSERT INTO dates VALUES(?,?,?)");
			$stmt->execute([$date->getId(), $date->getDate(), $name->getId()]);
		}
	}
	
	public function insertNames(array $names):bool{
		
		if(count($names)==0){
			return false;
		}
		
		$dates=[];
		
		$sql="INSERT INTO names (`name`) VALUES ";
		$sqlparts=[];
		
		foreach($names as $name){
			
			$dates=array_merge($dates, $name->getDates());
			
			$sqlparts[]='(\''.$name->getName().'\')';
		}
		$sql.=implode(',', $sqlparts);
		
		$this->pdo->exec($sql);
		
		
		$dateSql="INSERT INTO dates (`date`, `main`, name_id) VALUES ";
		$dateSqlParts=[];
		
		foreach($dates as $date){
			
			$attributes=[];
			$attributes[]='\''.$date->getDate().'\'';
			$attributes[]=(int)$date->getMain();
			$attributes[]=$date->getName()->getId();
			
			$dateSqlParts[]='('.implode(',', $attributes).')';
		}
		
		$this->pdo->exec($dateSql.implode(',', $dateSqlParts));
		
		return true;
	}
	
	public function nameIsExists(Name $name){
		
		$sql="SELECT 1 FROM names WHERE name=:name";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':name', $name->getName());
		$stmt->execute();
		$result=$stmt->fetch(\PDO::FETCH_ASSOC);
		if($result[1]=='1'){
			return true;
		}
		return false;
	}
	
	public function dateIsExists(Date $date){
		
		$sql="SELECT 1 FROM dates WHERE `date`=:date AND name_id=:name_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':date', $date->getDate());
		$stmt->bindValue(':name_id', $date->getName()->getId());
		$stmt->execute();
		$result=$stmt->fetch(\PDO::FETCH_ASSOC);
		if($result[1]=='1'){
			return true;
		}
		return false;
	}
	
	public function getNamesByDateTime(\DateTime $dateTime){
		
		$sql="SELECT names.* FROM names LEFT JOIN dates ON name_id=names.id WHERE dates.date=:date";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':date', $dateTime->format('n.j.'));
		$stmt->execute();
		$data=$stmt->fetchAll();
		
		$result=[];
		foreach($data as $d){
			
			$result[]=new Name($d['id'], $d['name'], []);
		}
		
		return $result;
	}
}