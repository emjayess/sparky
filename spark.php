<?php

	$spark = new SparkAPI_APIAuth(
	        'sorenson_key_1',
	        '6Yu0hcorl3TG8nzuofuBt'
	);

	$spark->SetApplicationName('Sparky/0.0.1');
	
	$spark->SetDeveloperMode(true);

	$auth = $spark->Authenticate();// or die('fail');

	if ($auth === false) {
	        echo "<p>Api Error Code: {$spark->last_error_code}</p>";
	        echo "<p>Api Error Message: {$spark->last_error_mess}</p>";
	        exit;
	}