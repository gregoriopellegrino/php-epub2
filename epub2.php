<?php
	//TODO import guide
	
	require_once("metadata.php");
	require_once("manifest.php");
	require_once("spine.php");
	require_once("guide.php");
	
	class epub2 {
	
		private $name = null;
    	private $file = null;
    	private $path = null;
    	private $metadata = null;
		private $manifest = null;
		private $spine = null;
		private $guide = null;
		private $opf_path = null;

    	// method declaration
    	function __construct($file, $name, $path) {
    	    $this->name = $name;
    	    $this->file = $file;
    	    $this->path = $path;
    	    $this->metadata = new metadata($this);
    	    $this->manifest = new manifest($this);
    	    $this->spine = new spine($this);
    	    $this->guide = new guide($this);
    	}
    	
    	/*public function decompress() {
    		mkdir($this->path, 0755);
    		$path = realpath($this->path);

			$zip = new ZipArchive;
			$res = $zip->open($this->file);
			if ($res === true) {
  				$zip->extractTo($path);
  				$zip->close();
			}
    	}*/
    	
    	// return XML object of opf file
    	public function getOpf() {
    		if(!isset($this->opf_path)) {
				$container = simplexml_load_file($this->path."META-INF/container.xml");
				foreach($container->rootfiles->rootfile as $rootfile) {
					$attr = $rootfile->attributes();
					if($attr["media-type"] == "application/oebps-package+xml") $this->opf_path = $attr["full-path"];
				}
    	    }
    		
    		return simplexml_load_file($this->path.$this->opf_path);
    	}
    	
    	public function save() {
    		$content = $this->getOpf();
    		
    		//manifest
    		$manifest = $content->manifest;
    		$dom = dom_import_simplexml($manifest);
    		while (isset($dom->firstChild)) $dom->removeChild($dom->firstChild);  
    		$this->getManifest()->asXml($manifest);
    		
    		//spine
    		$spine = $content->spine;
    		$dom = dom_import_simplexml($spine);
    		while (isset($dom->firstChild)) $dom->removeChild($dom->firstChild);  
    		$this->getSpine()->asXml($spine);
    		
    		//guide
    		$guide = $content->guide;
    		if(!empty($guide)) {
				$dom = dom_import_simplexml($guide);
				while (isset($dom->firstChild)) $dom->removeChild($dom->firstChild);  
				$this->getGuide()->asXml($guide);
			}
    		
    		//Format XML to save indented tree rather than one line
			$dom = new DOMDocument('1.0');
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML($content->asXML());
			$dom->save($this->path."OEBPS/content.opf");
    	}
    	
    	/*public function importSpine($xml) {
    		$attr = $xml->attributes();
    		$toc = $this->manifest->getItemById($attr["toc"]);
    		$this->spine = new spine($toc);
    		
    		foreach($xml->itemref as $itemref){
    			$attr = $itemref->attributes();
    			if(isset($attr["linear"])) {
    				if($attr["linear"] == "yes") $linear = true;
    				if($attr["linear"] == "no") $linear = false;
    			} else {
    				$linear = true;
    			}
    			
    			$item = $this->manifest->getItemById($attr["idref"]);
    			if($item != null) $this->spine->pushItem($item, $linear);
    		}
    	}*/
    	
    	/*public function importGuide($xml) {
    		foreach($xml->reference as $reference){
    			$attr = $reference->attributes();
    			$type = $attr["type"];
    			$href = $attr["href"];
    			
    			$items = $this->getItemsByHref($href, false);
    			foreach($items as $item) {
    				$item->setType($type);
    			}
    		}
    	}*/
    	
    	/*public function importToc($xml) {
    		foreach($xml->navPoint as $navPoint){
    			$this->items[count($this->items)] = $this->importNavpPoint($navPoint);
    		}
    	}
    	
    	public function importNavpPoint($xml) {
    		$text = $xml->navLabel->text;
    		$attr = $xml->content->attributes();
    		$href = $attr["src"];
    		$item = new item("", $href, "", "", true, "", $text);
    		
    		foreach($xml->navPoint as $navPoint) $item->addChild($this->importNavpPoint($navPoint));
    		
    		return $item;
    	}*/
    	
    	/*public function itemsToTable() {
    		$html  = "<thead><tr><th>id</th><th>text</th><th>href</th><th>type</th><th>media-type</th><th>isVisible</th></tr></thead>";
    		$html .= "<tbody>";
    		
    		$id = 0;
    		foreach($this->items as $item) {
    			$html .= $item->toTable($id, null);
    			$id++;
    		}
    		
    		$html .= "</tbody>";
    		
    		return $html;
    	}*/
    	
    	public function getPath() {
    		return $this->path;
    	}
    	
    	public function getMetadata() {
    		return $this->metadata;
    	}
    	
    	public function getManifest() {
    		return $this->manifest;
    	}
    	
    	public function getSpine() {
    		return $this->spine;
    	}
    	
    	public function getGuide() {
    		return $this->guide;
    	}
	}
?>