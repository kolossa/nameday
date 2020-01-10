<?php 

require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');

$url = explode('/', $_SERVER['REQUEST_URI']);
$key=array_search('Parser', $url);

$controller=isset($url[$key+1])?$url[$key+1]:null;

$action=isset($url[$key+2])?$url[$key+2]:null;
$action=explode('?', $action);
$action=$action[0];

if($controller==null || $action==null){
	throw new \Exception('Route not found!');
}

$controllerFound=false;
foreach (new \DirectoryIterator('controllers') as $fileInfo) {
    
	if($fileInfo->isDot()){
		continue;
	}
    
	$controllerName=str_ireplace('controller.php', '', $fileInfo->getFilename());
	
	if(strtolower($controller)==strtolower($controllerName)){
		$controllerFound=true;
		$controllerName='netrisk\Nameday\Parser\controllers\\'.$controllerName;
		$controllerName.='Controller';
		$controllerObject=new $controllerName();
		
		$methodName=$action;
		
		if( method_exists($controllerObject, $methodName)){
			
			echo $controllerObject->$methodName();
			
			break;
		}else{
			
			throw new \Exception('Action not found!');
		}
	}
}

if(!$controllerFound){
	throw new \Exception('Controller not found!');
}

