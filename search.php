<?php

	function search($min, $max) {
		$listings['listings'] = $spark->GetListings(
			array(
				'_pagination' => 1,
				'_limit' => 15,
				'_page' => 1, 
				'_filter' => "ListPrice Ge {$min} And ListPrice Le {$max}",
				//'_expand' => 'PrimaryPhoto',
				'_orderby' => '+ListPrice'
			)
		);

		array_walk_recursive($listings, function(&$val, $key) {
			if ($key == 'City') $val = ucwords(strtolower($val));
			if ($key == 'ListPrice' ) $val = number_format($val);
		});

		return $listings['listings'];
	}

	/*
	function list_filter(&$item, &$key, $l) {
		//echo "$item\n";
		if ($item == '********') {
			$item = "***";
			unset($listings[$l[$key]]);
		}
	}

	foreach ($listings as $listing) {
		array_walk($listing['StandardFields'], 'list_filter', $listing);
	}
	*/