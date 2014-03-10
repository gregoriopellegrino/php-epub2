<?php
	require_once("tocitem.php");
	
	class toc {
    	private $epub = null;
    	private $title = null;
    	private $list = null;
    	
    	//costruttore
    	function __construct($epub = null, $xml = null) {
    	    $this->epub = $epub;
    	    $this->list = array();
    	    if(!isset($xml) and isset($epub)) {
    	    	$xml = $epub->getNav();
    	    	if($xml == false) return null;
    	    	$xml->registerXPathNamespace("xhtml", "http://www.w3.org/1999/xhtml");
    	    	$nodes = $xml->xpath('//xhtml:nav[@epub:type="toc"]');
    	    	$xml = $nodes[0];
    	    }
    	    if(isset($xml)) $this->import($xml);
    	}
    	
    	public function import($xml) {
			if(isset($xml->h1)) $this->title = (string) $xml->h1;
			if(isset($xml->span)) $this->title = (string) $xml->span;
			
			foreach($xml->ol->li as $listitem){    			
    			if(isset($listitem->ol)) {
    				//ricorsivo
    				$listitem = new toc($this->epub, $listitem);
    				$this->addItem($listitem);
    			} else {
    				$attr = $listitem->a->attributes();
					$item = $this->epub->getManifest()->getItemByHref((string) $attr["href"]);
					if($item != null) {
						$listitem = new tocitem($item, (string) $listitem->a);
						$this->addItem($listitem);
					}
				}
    		}
    	}
    	
    	public function addItem($item) {
    		array_push($this->list, $item);
    	}
    	
    	public function removeItem($item) {
    		$key = array_search($listitem, $this->items);
    		unset($this->items[$key]);
    	}
    	
    	public function asXml($parent, $root = true) {
    		if(isset($this->title)) {
    			if($root) {
    				$parent->addChild("h1", $this->title);
    			} else {
    				$parent->addChild("span", $this->title);
    			}
    		}
    		
    		$parent = $parent->addChild("ol");
    		foreach($this->list as $listitem) {
    			$nodo = $parent->addChild("li");
    			if(get_class($listitem) == get_class()) {
    				$nodo = $listitem->asXml($nodo, false);
    			} else {
					$nodo = $nodo->addChild("a", $listitem->getText());
					$nodo->addAttribute("href", $listitem->getItem()->getHref());
				}
    		}
    		
    		return $parent;
    	}
    	
    	public function getTitle() {
    		return $this->title;
    	}
    	
    	public function setTitle($title) {
    		$this->title = $title;
    	}
    	
	}
?>