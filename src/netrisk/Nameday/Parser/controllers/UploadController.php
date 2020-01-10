<?php 

namespace netrisk\Nameday\Parser\controllers;

use netrisk\Nameday\Parser\views\View;
use netrisk\Nameday\Parser\database\MySqlConnection;
use netrisk\Nameday\Parser\model\MySqlNameRepository;
use netrisk\Nameday\Parser\model\Name;
use netrisk\Nameday\Parser\model\Date;

class UploadController{
	
	public function uploadNamedayFile(){
		
		$msg='';
		
		if(isset($_POST["submit"])) {
			
			if(!$_FILES['file']['error']){
				
				$connection=MySqlConnection::getInstance();

				$pdo=$connection->getPdo();
				
				$repository=new MySqlNameRepository($pdo);
				
				$file = new \SplFileObject($_FILES['file']['tmp_name']);

				$nameId=1;
				$dateId=1;
				
				$names=[];
				
				while (!$file->eof()) {
					
					$pattern1='[[:alpha:]]+\s+';
					$pattern2='((\d{1,2}\.\d{1,2}\.)+|(,)+|(\*)?)+';
					$pattern='/'.$pattern1.$pattern2.'/u';
					$line=$file->fgets();
					
					$line=iconv("ISO-8859-2","UTF-8",  $line);
					$line=strip_tags($line);
					$line=trim($line);
					
					
					preg_match_all($pattern,$line,$matches);
					
					if(isset($matches[0][0])){
						$nameAndDates=$matches[0][0];
						preg_match_all('/'.$pattern1.'/u', $nameAndDates, $matches2);
						if(isset($matches2[0][0])){
							
							
							
							$name=$matches2[0][0];
							$name=trim($name);
							
							
							
							$dates=str_replace($name, '', $nameAndDates);
							$dates=trim($dates);
							
							if($dates){
								
								$nameDates=[];
								$nameModel=new Name($nameId++, $name);
								
								
								if($repository->nameIsExists($nameModel)){
									continue;
								}
								
								$names[]=$nameModel;
								
								$datesArray=explode(',', $dates);
								foreach($datesArray as $date){
									
									if($date==''){
										continue;
									}
									
									$main=stripos($date, '*')!==false ? true : false;
									
									if($main){
										$date=str_replace('*', '', $date);
									}
									
									$dateModel=new Date($dateId++, $date, $main, $nameModel);
									
									if($repository->dateIsExists($dateModel)){
										continue;
									}
									
									$nameDates[]=$dateModel;
									
									
								}
								
								$nameModel->setDates($nameDates);
							}
						}
					}
				}
				$repository->insertNames($names);
				
				
				$msg='File upload succeeded!';
			}
		}
		
		
		$view=new View('upload/upload');
		return $view->render(['msg'=>$msg]);
	}
}