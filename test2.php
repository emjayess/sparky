<?php

require_once('vendor/sparkapi/lib/Core.php');
//require_once('vendor/mustache/Mustache.php');
//require_once('vendor/mustache/MustacheLoader.php');

//$m = new Mustache;
//$partials = new MustacheLoader('templates', 'html.mustache');

//$templates['listings'] = file_get_contents('templates/listings.html.mustache');

$spark = new SparkAPI_APIAuth(
        'sorenson_key_1',
        '6Yu0hcorl3TG8nzuofuBt'
);

$spark->SetApplicationName('Sparky/0.0.1');
$spark->SetDeveloperMode(true);

$auth = $spark->Authenticate();// or die('fail');

if ($auth === false) {
        //echo "Api Error Code: {$spark->last_error_code}<br>\n";
        //echo "Api Error Message: {$spark->last_error_mess}<br>\n";
        exit;
}
else {
        //echo "Api Auth Success?!";
}


$listings['listings'] = $spark->GetListings(
	array(
		'_pagination' => 1,
		'_limit' => 15,
		'_page' => 1, 
		'_filter' => "ListPrice Ge 150000.00 And ListPrice Le 250000.00",
		//'_expand' => 'PrimaryPhoto',
		'_orderby' => '+ListPrice'
	)
);

array_walk_recursive($listings, function(&$val, $key) {
	if ($key == 'City') $val = ucwords(strtolower($val));
	if ($key == 'ListPrice' ) $val = number_format($val);
});

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

/*
setlocale(LC_MONETARY, 'en_US');



echo $m->render($templates['listings'],
	$listings,
	$partials
);

echo '<pre>';
print_r($listings);
echo '</pre>';

*/