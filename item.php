<?php
	class item {
	
    	private $id = null;
    	private $href = null;
    	private $media_type = null;

    	//costruttore
    	public function __construct($id, $href, $media_type) {
    	    $this->id = $id;
    	    $this->href = $href;
    	    $this->media_type = $media_type;
    	}
    	
    	public function setId($id) {
    		$this->id = $id;
    	}
    	
    	public function setMedia_type($media_type) {
    		$this->media_type = $media_type;
    	}
    	
    	public function setHref($href) {
    		$this->href = $href;
    	}
    	
    	public function getId() {
    		return $this->id;
    	}
    	
    	public function getHref() {
    		return $this->href;
    	}
    	
    	public function getMedia_type() {
    		return $this->media_type;
    	}
    	
	}
?>