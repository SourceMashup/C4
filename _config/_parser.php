<?php
   /*
	* Parsing class.  Applies layouts
	*/
	class parser
	{
		private $_root;
		private $site;

		function __construct($root, $site)
		{
			$this->_root = $root;
			$this->site = $site;
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

		public function parsePage($page)
		{
			$site = $this->site;
			$file = $this->buildFileName($page,"_pages");
			ob_start();
			include $file;
			$data = ob_get_contents();
			ob_end_clean();
			if(!isset($_parm))
				$_parm = null;
			if(!isset($_title))
				$_title = null;
			$page = new page($_parm, $_title);
			if(!empty($_layout)){
				$data = $this->addLayout($data, $page, $_layout);
			}
			return $data;
		}


		private function addLayout($content, $page, $layout=null)
		{
			if(!isset($site))
				$site = $this->site;
			if(empty($layout))
				return $content;

			$file = $this->buildFileName($layout,"_layouts");
			ob_start();
			include $file;
			$data = ob_get_contents();
			ob_end_clean();
			if(!empty($_layout))
			{
				$data = $this->addLayout($data, $page, $_layout);
			}
			return $data;
			
		}

	}

	/**
	* 
	*/
	class page
	{
		public $parm;
		public $title;
		function __construct($parm=null, $title=null)
		{
			$this->parm = json_decode($parm);
			$this->title = $title;
		}
	}
?>