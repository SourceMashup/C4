<?php
ini_set('display_errors', 1); 

$pageURL = $_SERVER["REQUEST_URI"];

include '_config/_parser.php';
include '_config/_site.php';


$site = new site(__DIR__);
$parser = new parser(__DIR__,$site);
$root = __DIR__;
include '_config/_functions.php';

if($site->validateWebURL($pageURL))
{

	echo $parser->parsePage($site->page());
}
else{
	echo $parser->parsePage("404");
}

?>