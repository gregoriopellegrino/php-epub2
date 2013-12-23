<?php
	require_once("itemref.php");
	
	class spine {
	
    	private $epub = null;
    	private $toc = null;
    	private $itemrefs = null;
    	
    	//costruttore
    	function __construct($epub) {
    	    $this->epub = $epub;
    	    $this->itemrefs = array();
    	    $this->import();
    	}
    	
    	public function import() {
    		$xml = $this->epub->getOpf()->spine;
    		$manifest = $this->epub->getManifest();
    		
    		$attr = $xml->attributes();
    		$this->toc = $manifest->getItemById((string)$attr["toc"]);
			
			foreach($xml->itemref as $itemref){
    			$attr = $itemref->attributes();
    			$item = $manifest->getItemById((string)$attr["idref"]);
    			
    			$linear = true;
    			if(($attr["linear"] == "no") and isset($attr["linear"])) $linear = false;
    			
    			$itemref = new itemref($item, $linear);
    			
    			$this->addItemref($itemref);
    		}
    	}
    	
    	public function addItemref($itemref) {
    		array_push($this->itemrefs, $itemref);
    	}
    	
    	public function insertItemref($itemref, $after) {
    		if($after != null) {
				$itemrefs = $this->itemrefs;
				$this->itemrefs = array();
				foreach($itemrefs as $item) {
					$this->addItemref($item);
					if($after == $item) $this->addItemref($itemref);
				}
			} else {
				array_unshift($this->itemrefs, $itemref);
			}
    	}
    	
    	public function getItemrefs() {
    		return $this->itemrefs;
    	}
    	
    	public function getItemrefById($id) {
    		foreach($this->itemrefs as $itemref) {
    			if($itemref->getItem()->getId() == $id) return $itemref;
    		}
    		return null;
    	}
    	
    	public function asXml($spine) {
    		foreach($this->itemrefs as $itemref) {
    			$nodo = $spine->addChild("itemref");
    			$nodo->addAttribute("idref", $itemref->getItem()->getId());
    			$linear = "no";
    			if($itemref->getLinear()) $linear = "yes";
    			$nodo->addAttribute("linear", $linear);
    		}
    	}
	}
?>