<?php
	class metadata {
	
    	private $epub = null;
    	private $title = null;
    	private $creators = null;
    	private $subjects = null;
    	private $description = null;
    	private $publisher = null;
    	private $contributors = null;
    	private $date = null;
    	private $type = null;
    	private $format = null;
    	private $identifier = null;
    	private $source = null;
    	private $language = null;
    	private $relation = null;
    	private $coverage = null;
    	private $rights = null;
    	private $meta = null;
    	
    	//costruttore
    	function __construct($epub) {
    	    $this->epub = $epub;
    	    $this->import();
    	}
    	
    	public function import() {
    		$xml = $this->epub->getOpf();
    		$namespaces = $xml->getNameSpaces(true);
    		$dc = $xml->metadata->children($namespaces['dc']);
    		
    		$this->setTitle($dc->title);
    		$this->setDescription($dc->description);
    		$this->setPublisher($dc->publisher);
    		$this->setDate($dc->date);
    		$this->setType($dc->type);
    		$this->setFormat($dc->format);
    		$this->setIdentifier($dc->identifier);
    		$this->setSource($dc->source);
    		$this->setLanguage($dc->language);
    		$this->setRelation($dc->relation);
    		$this->setCoverage($dc->coverage);
    		$this->setRights($dc->rights);
    		$this->setCreators($dc->creator);
    		
    		//meta
    		$this->meta = array();
    		foreach($xml->metadata->meta as $meta) {
    			$attr = $meta->attributes();
    			$this->addMeta($attr["name"], $attr["content"]);
    		}
    	}

		public function getRoles(){
			$roles = file_get_contents("constants/roles.json");
			return json_decode($roles);
		}
		
		public function getTitle(){
			return $this->title;
		}

		public function setTitle($title){
			$this->title = $title;
		}

		public function getCreators(){
			return $this->creators;
		}

		public function setCreators($creators){
			$this->creators = $creators;
		}

		public function getSubjects(){
			return $this->subjects;
		}

		public function setSubjects($subjects){
			$this->subjects = $subjects;
		}

		public function getDescription(){
			return $this->description;
		}

		public function setDescription($description){
			$this->description = $description;
		}

		public function getPublisher(){
			return $this->publisher;
		}

		public function setPublisher($publisher){
			$this->publisher = $publisher;
		}

		public function getContributors(){
			return $this->contributors;
		}

		public function setContributors($contributors){
			$this->contributors = $contributors;
		}

		public function getDate(){
			return $this->date;
		}

		public function setDate($date){
			$this->date = $date;
		}

		public function getType(){
			return $this->type;
		}

		public function setType($type){
			$this->type = $type;
		}

		public function getFormat(){
			return $this->format;
		}

		public function setFormat($format){
			$this->format = $format;
		}

		public function getIdentifier(){
			return $this->identifier;
		}
		
		public function getMeta($name){
			return $this->meta[$name];
		}

		public function setIdentifier($identifier){
			$this->identifier = $identifier;
		}

		public function getSource(){
			return $this->source;
		}

		public function setSource($source){
			$this->source = $source;
		}

		public function getLanguage(){
			return $this->language;
		}

		public function setLanguage($language){
			$this->language = $language;
		}

		public function getRelation(){
			return $this->relation;
		}

		public function setRelation($relation){
			$this->relation = $relation;
		}

		public function getCoverage(){
			return $this->coverage;
		}

		public function setCoverage($coverage){
			$this->coverage = $coverage;
		}

		public function getRights(){
			return $this->rights;
		}

		public function setRights($rights){
			$this->rights = $rights;
		}
		
		public function addMeta($name, $content){
			$this->meta[(string)$name] = $content;
		}
    	
    	
	}
?>