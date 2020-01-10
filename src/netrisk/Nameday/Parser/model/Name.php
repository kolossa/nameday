<?php 

namespace netrisk\Nameday\Parser\model;

class Name{
	
	private $id;
	private $name;
	private $dates;
	
	public function __construct($id, $name, $dates=array()){
		
		$this->id=$id;
		$this->name=$name;
		$this->dates=$dates;
	}
	
	public function getId():int{
		return $this->id;
	}
	
	public function getName():string{
		
		return $this->name;
	}
	
	public function getDates():array{
		
		return $this->dates;
	}
	
	public function setDates(array $dates){
		
		$this->dates=$dates;
	}
}