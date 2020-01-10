<?php 

namespace netrisk\Nameday\Parser\views;

class View{
	
	private $filePath;
	
	public function __construct($filePath) {
		
		$this->filePath = $filePath;
	}
	
	public function render($data) {
		
		if (!file_exists(__DIR__.DIRECTORY_SEPARATOR.$this->filePath . '.php')) {
			throw new \Exception('File not found: ' . $this->filePath);
		}
		
		ob_start();
		
		extract($data);
		
		include($this->filePath . '.php');
		
		$content = ob_get_contents();
		
		ob_end_clean();
		return $content;
	}
}