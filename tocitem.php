<?php
	class tocitem {
	
    	private $item = null;
    	private $text = null;

    	//costruttore
    	public function __construct($item, $text) {
    	    $this->item = $item;
    	    $this->text = $text;
    	}
    	
    	public function setItem($item) {
    		$this->item = $item;
    	}
    	
    	public function setText($text) {
    		$this->text = $text;
    	}
    	
    	public function getItem() {
    		return $this->item;
    	}
    	
    	public function getText() {
    		return $this->text;
    	}
    	
	}
?>