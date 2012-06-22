<?php

	require 'bootstrap.php';

	function getlist($request) {
		postlist($request);
		//echo "btw {$request->min} &amp; {$request->max}";
		//exit;
	}

	function postlist($request) {
		global $spark, $m, $templates;

		//@todo: validate+sanitize user input

		$listings['listings'] = $spark->GetListings(
			array(
				'_pagination' => 1,
				'_limit' => 15,
				'_page' => 1, 
				'_filter' => "ListPrice Ge {$request->min} And ListPrice Le {$request->max}",
				'_orderby' => '+ListPrice'
			)
		);

		array_walk_recursive($listings, 'listing_formatter');

		$listings['querymin'] = $request->min;
		$listings['querymax'] = $request->max;

		//$listings['page_size'] = $spark->page_size; //@todo: user choice for page size
		$listings['total_pages'] = $spark->total_pages;
		$listings['current_page'] = $spark->current_page;

		echo $m->render(
			$templates['index']
			,$listings
			,$templates['partials']
		);
	}

	/**
	 * handler(s) for list (search) as HTTP GET
	 */
	respond('GET', '/list', 'getlist');
	respond('GET', '/list/[:min]/[:max]', 'getlist');

	/**
	 * handler for list (search) form submission
	 */
	respond('POST', '/list', 'postlist');

	/**
	 * home/default handler
	 */
	respond('GET', '/', function() {
		global $m, $templates;

		echo $m->render(
			$templates['index']
			,array(// search form defaults:
				'querymin' => '80000.00',
				'querymax' => '120000.00'
			)
			,$templates['partials']
		);
	});

	/**
	 * handler for individual listing
	 */
	respond('GET', '/listing/[:id]', function($request) {
		global $spark, $m, $templates, $listings;

		//@todo: validate+sanitize [:id] url param

		$listing = $spark->GetListing($request->id);
		$listing['photos'] = $spark->GetListingPhotos($request->id);
		$listing['openhouses'] = $spark->GetListingOpenHouses($request->id);

		array_walk_recursive($listing, 'listing_formatter');

		echo $m->render(
			$templates['listing']
			,$listing
			,$templates['partials']
		);

		//debug
		echo '<h3>debug</h3><pre>';
		print_r($listing);
		echo '</pre>';
		
		exit;
	});

	function listing_formatter(&$val, $key) {
		if ($key != 'StateOrProvince') $val = ucwords(strtolower($val));
		if ($key == 'ListPrice') $val = number_format($val);
		if ($val == '********') $val = '';
	}

	// dispatch klein responders
	//echo '<hr>Klein is routing requests';
	dispatch();