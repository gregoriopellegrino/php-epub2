<?php
	require_once("item.php");
	
	class manifest {
    	private $epub = null;
    	private $items = null;
    	
    	//costruttore
    	function __construct($epub) {
    	    $this->epub = $epub;
    	    $this->items = array();
    	    $this->import();
    	}
    	
    	public function import() {
    		$xml = $this->epub->getOpf()->manifest;
			
			foreach($xml->item as $item){
    			$attr = $item->attributes();
    			$item = new item($attr["id"], $attr["href"], $attr["media-type"]);
    			$this->addItem($item);
    		}
    	}
    	
    	public function addItem($item) {
    		array_push($this->items, $item);
    	}
    	
    	public function removeItem($item) {
    		$key = array_search($item, $this->items);
    		unset($this->items[$key]);
    	}
    	
    	public function getItemById($id) {
    		foreach($this->items as $item) {
    			if($item->getId() == $id) return $item;
    		}
    		return null;
    	}
    	
    	public function getItemsByMedia_type($media_type) {
    		$return = array();
    		foreach($this->items as $item) {
    			if($item->getMedia_type() == $media_type) array_push($return, $item);
    		}
    		return $return;
    	}
    	
    	public function getItemByHref($href) {
    		foreach($this->items as $item) {
    			if($item->getHref() == $href) return $item;
    		}
    		return null;
    	}
    	
    	public function asXml($manifest) {
    		foreach($this->items as $item) {
    			//var_dump($item);print "<br>";
    			$nodo = $manifest->addChild("item");
    			$nodo->addAttribute("id", $item->getId());
    			$nodo->addAttribute("href", $item->getHref());
    			$nodo->addAttribute("media-type", $item->getMedia_type());
    		}
    	}
    	
	}
?>