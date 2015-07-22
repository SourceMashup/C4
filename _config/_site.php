<?php

	/**
	* Site class
	*/
	class site
	{

		private $_dbConn;
		private $_root;
		private $_page;
		public $content;
		public $data;
		
		function __construct($root)
		{
			include "_config.php";
        	$this->_dbConn = new mysqli($dbHost,$dbUser,$dbPass,$dbName);
        	$this->_root = $root;
		}

		public function dataExists()
		{
			$DATA_TABLE = "SITE";
			$result = $this->_dbConn->query("SELECT * FROM " . $DATA_TABLE . " LIMIT 1;");
			if($result && $result->num_rows > 0)
			{
				$result = $result->fetch_object();
				$this->data = json_decode($result->CONFIG);
				return true;
			}else
				return false;
		}


		public function dbConn()
		{
			return $this->_dbConn;
		}

		public function validateWebURL($url)
		{
			if($url == "/dbCreate.php")
			{
				if(file_exists($this->_root . DIRECTORY_SEPARATOR . "_config" . DIRECTORY_SEPARATOR . "_config.php")){
					return false;
				}else{
					$this->_page = "dbCreate.php";
					return true;
				}
			}
			$URL_TABLE = "URLS";
			/*if($url == $this->config->admin_url)
			{
				$this->page = "admin";
				return true;
			}*/

			$result = $this->_dbConn->query("SELECT * FROM " . $URL_TABLE . " WHERE URL = '" . $url . "' OR REFERENCE_URL = '" . $url . "' LIMIT 1;");
			if($result && $result->num_rows > 0)
			{
				$this->_page = $result->fetch_object();
				return true;
			}else{
				/*foreach ($this->posts as $post) {
					if($url == $post->url){
						$this->page = $post;
						return true;
					}


				}*/
				return false;
			
			}
		}

		public function page(){
			if(isset($this->_page->FILE))
				return $this->_page->FILE;
			else
				return $this->_page;
		}

		public function root(){ return $this->_root;}

		public function contentExists(){
			$CONTENT_TABLE = "CONTENT";
			$result = $this->_dbConn->query("SELECT * FROM " . $CONTENT_TABLE . ";");
			if($result && $result->num_rows > 0)
			{
				while($row = $result->fetch_object())
				{
					$this->content[$row->NAME] = $row->CONTENT;
				}
				return true;
			}else
				return false;
		}

		public function includes($file,$page=null){
			$site = $this;
			$file = $this->buildFileName($file,"_includes");
			ob_start();
			include $file;
			$data = ob_get_contents();
			ob_end_clean();
			return $data;
		}




		private function buildFileName($filename,$dir)
		{
			if(mb_substr($filename, 0, 1) == DIRECTORY_SEPARATOR)
			{
				$filename = ltrim ($filename, DIRECTORY_SEPARATOR);
			}
			$file;
			if(strpos($filename,DIRECTORY_SEPARATOR) !== false)
			{
				$file = (mb_substr($filename, 0, 1) != "_") ? "_" . $filename : "" . $filename;
			}else{
				$file = $dir . DIRECTORY_SEPARATOR . $filename;
			}

			$file = $this->_root . DIRECTORY_SEPARATOR . $file;
			if(file_exists($file . ".php"))
				$file =  $file . ".php";
			elseif (file_exists($file . ".html")) 
				$file = $file . ".html";
			elseif (file_exists($file . ".htm"))
				$file = $file . ".htm";

			return $file;
		}
		


	}

?>