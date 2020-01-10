<?php 

namespace netrisk\Nameday\Parser\model;

class Date{
	
	private $id;
	private $date;
	private $main;
	private $name;
	
	public function __construct($id, $date, $main, $name=null){
		
		$dateParts=explode('.', $date);
		
		if($dateParts[0]>12 || $dateParts[0]<1){
			throw new \Exception('Wrong month: ' . $dateParts[0]);
		}
		
		if($dateParts[1]>31 || $dateParts[1]<1){
			throw new \Exception('Wrong day: ' . $dateParts[1]);
		}
		
		
		$this->id=$id;
		$this->date=$date;
		$this->main=$main;
		
		
		if($name!==null && $name instanceof Name){
			$this->name=$name;
		}
		
	}
	
	public function getId():int{
		
		return $this->id;
	}
	
	public function getDate():string{
		
		return $this->date;
	}
	
	public function getMain():bool{
		
		return $this->main;
	}
	
	public function getName():Name{
		
		return $this->name;
	}
}