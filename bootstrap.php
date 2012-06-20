<?php

	// no autoloading here
	require 'vendor/sparkapi/lib/Core.php';
	require 'vendor/klein/klein.php';
	require 'vendor/mustache/Mustache.php';
	require 'vendor/mustache/MustacheLoader.php';
	require 'spark.php';
	//require 'search.php';

	// set up templating w/mustache:
	$m = new Mustache;
	$partials = new MustacheLoader('templates', 'html.mustache');
	$templates['index'] = file_get_contents('templates/index.html.mustache');
	$templates['listing'] = file_get_contents('templates/listing.html.mustache');
	$templates['listings'] = file_get_contents('templates/listings.html.mustache');