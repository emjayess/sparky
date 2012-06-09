<?php

include('vendor/mustache/Mustache.php');

// implementation of sparkplatform api
$page_title = 'SparkPlatform Api Concept';
$header = '* Spark *';
$content = $page_title;
$footer = 'adios';

$m = new Mustache;
$layout = file_get_contents('templates/layout.html.mustache');

echo $m->render(
	$layout,
	array(
	  'page_title' => $page_title,
	  'header' => $header,
	  'content' => $content,
	  'footer' => $footer
	)
);
