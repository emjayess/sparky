<?php

require_once('vendor/sparkapi/lib/Core.php');

$spark = new SparkAPI_APIAuth(
	'sorenson_key_1',
	'6Yu0hcorl3TG8nzuofuBt'
);

$spark->SetApplicationName('Sparky/0.0.1');
$spark->SetDeveloperMode(true);

if ($spark->Authenticate() === false) {
	echo "Api Error Code: {$spark->last_error_code}<br>\n";
	echo "Api Error Message: {$spark->last_error_mess}<br>\n";
	exit;
}

$listigs = $spark->GetListings(
	array(
		'_pagination' => 1,
		'_limit' => 15,
		'_page' => 1, 
		'_filter' => "ListPrice Ge 150000.00 And ListPrice Le 200000.00",
		'_orderby' => '+ListPrice'
	)
);

print_r($listings);