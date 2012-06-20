<?php

	require 'bootstrap.php';

	/**
	 * handler for list (search) form submission
	 */
	respond('POST', '/list', function($req, $response) {
		global $spark, $m, $templates, $listings, $partials;

		$max_price = $req->max;
		$min_price = $req->min;
		
		//@todo: validate+sanitize user input

		$listings['listings'] = $spark->GetListings(
			array(
				'_pagination' => 1,
				'_limit' => 15,
				'_page' => 1, 
				'_filter' => "ListPrice Ge $min_price And ListPrice Le $max_price",
				'_orderby' => '+ListPrice'
			)
		);

		array_walk_recursive($listings, 'listing_formatter');

		//$listings['page_size'] = $spark->page_size; //@todo: user choice for page size
		$listings['total_pages'] = $spark->total_pages;
		$listings['current_page'] = $spark->current_page;

		echo $m->render(
			$templates['index'], 
			$listings, $partials
		);
	});

	/**
	 * home/default handler
	 */
	respond('GET', '/', function($req, $res) {
		global $m, $templates, $listings, $partials;

		echo $m->render(
			$templates['index'], 
			$listings, $partials
		);
	});

	/**
	 * handler for individual listing
	 */
	respond('GET', '/listing/[:id]', function($req) {
		global $spark, $m, $templates, $listings, $partials;

		//@todo: validate+sanitize [:id] url param

		$listing = $spark->GetListing($req->id);
		$listing['photos'] = $spark->GetListingPhotos($req->id);
		$listing['openhouses'] = $spark->GetListingOpenHouses($req->id);

		array_walk_recursive($listing, 'listing_formatter');

		echo $m->render(
			$templates['listing'], 
			$listing, $partials
		);

		//debug
		
		echo '<h3>debug</h3><pre>';
		print_r($listing);
		echo '</pre>';
		
		exit;
	});

	function listing_formatter(&$val, $key) {
		if ($key == 'City') $val = ucwords(strtolower($val));
		if ($key == 'ListPrice') $val = number_format($val);
		if ($val == '********') $val = '';
	}

	// dispatch klein responders
	//echo '<hr/>Klein is routing requests';
	dispatch();