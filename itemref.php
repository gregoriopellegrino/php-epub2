<?php
	class itemref {
	
    	private $item = null;
    	private $linear = null;

    	//costruttore
    	public function __construct($item, $linear) {
    	    $this->item = $item;
    	    $this->linear = $linear;
    	}
    	
    	public function setItem($item) {
    		$this->item = $item;
    	}
    	
    	public function setLinear($linear) {
    		$this->linear = $linear;
    	}
    	
    	public function getItem() {
    		return $this->item;
    	}
    	
    	public function getLinear() {
    		return $this->linear;
    	}
    	
	}
?>