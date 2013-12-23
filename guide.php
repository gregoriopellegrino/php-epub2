<?php
	require_once("reference.php");
	
	class guide {
	
    	private $epub = null;
    	private $references = null;
    	
    	//costruttore
    	function __construct($epub) {
    	    $this->epub = $epub;
    	    $this->references = array();
    	    $this->import();
    	}
    	
    	public function import() {
    		$xml = $this->epub->getOpf()->guide;
    		$manifest = $this->epub->getManifest();
			
			foreach($xml->reference as $reference){
    			$attr = $reference->attributes();
    			
    			$reference = new reference((string)$attr["type"], (string)$attr["title"], (string)$attr["href"]);
    			
    			$this->addReference($reference);
    		}
    	}
    	
    	public function addReference($reference) {
    		array_push($this->references, $reference);
    	}
    	
    	public function getReferences() {
    		return $this->references;
    	}
    	
    	public function getReferenceByType($type) {
    		foreach($this->references as $reference) {
    			if($reference->getType() == $type) return $reference;
    		}
    		return null;
    	}
    	
    	public function asXml($guide) {
    		foreach($this->references as $reference) {
    			$nodo = $guide->addChild("reference");
    			$nodo->addAttribute("href", $reference->getHref());
    			$nodo->addAttribute("type", $reference->getType());
    			$nodo->addAttribute("title", $reference->getTitle());
    		}
    	}
	}
?>