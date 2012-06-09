<?php

// implementation of sparkplatform api
$page_title = 'SparkPlatform Api Concept';

$header = '<h1>* Spark *</h1>';
$content = '<div class="content">' . $page_title . '</div>';
$footer = '<footer>adios</footer>';

include('vendor/mustache/Mustache.php');

$engine = new Mustache;
$engine=>template_file = 'templates/layout.html.mustache';

echo $engine->render(
	array(
		$page_title,
		$header,
		$content,
		$footer,
	)
);