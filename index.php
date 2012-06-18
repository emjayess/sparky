<?php

	if (isset($_POST['query'])) {
		echo 'search query = ' . $_POST['query'];
		echo '<pre>';
		print_r($_POST['query']);
		echo '</pre>';
		exit;
	}

//require_once('vendor/sparkapi/lib/Core.php');
require_once('vendor/mustache/Mustache.php');
require_once('vendor/mustache/MustacheLoader.php');
require_once('test2.php');

$m = new Mustache;
$partials = new MustacheLoader('templates', 'html.mustache');
$templates['index'] = file_get_contents('templates/index.html.mustache');

/*
$search = [
	'min_price' => 150000,
	'max_price' => 220000
];
*/

echo $m->render($templates['index'],
	$listings,//array(),
	$partials
);