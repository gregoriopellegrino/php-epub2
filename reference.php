<?php
	class reference {
	
    	private $type = null;
    	private $title = null;
    	private $href = null;

    	//costruttore
    	public function __construct($type, $title, $href) {
    	    $this->type = $type;
    	    $this->title = $title;
    	    $this->href = $href;
    	}
    	
    	public function setType($type) {
    		$this->type = $type;
    	}
    	
    	public function setTitle($title) {
    		$this->title = $title;
    	}
    	
    	public function setHref($href) {
    		$this->href = $href;
    	}
    	
    	public function getType() {
    		return $this->type;
    	}
    	
    	public function getTitle() {
    		return $this->title;
    	}
    	
    	public function getHref() {
    		return $this->href;
    	}
	}
?>