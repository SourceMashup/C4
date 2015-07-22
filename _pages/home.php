<?php
$_layout = "default";
$_title = "Home";
?>


<?php

if($site->contentExists())
{
	echo excerpt($site->content["about"]);
}

?>