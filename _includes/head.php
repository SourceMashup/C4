<?php
if(isset($page->parm->title))
{
	$title = $page->parm->title;
}elseif(isset($page->title)){
	$title = $page->title;
}else{
	if($site->dataExists())
		$title = $site->data->title;
	else
		$title = "";
}
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $title; ?></title>
  <meta name="description" content="{% if page.excerpt %}{{ page.excerpt | strip_html | strip_newlines | truncate: 160 }}{% else %}{{ site.data.settings.description }}{% endif %}">

  <link rel="stylesheet" href="{{ "/assets/css/main.css" }}">
  <link rel="canonical" href="{{ page.url | replace:'index.html','' }}">
  <link rel="alternate" type="application/rss+xml" title="{{ site.data.settings.title }}" href="/feed.xml" />
</head>