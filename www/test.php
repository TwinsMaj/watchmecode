<?php

	function fetchData($callback) {
		# go to db to fetch the fllg names..
		$data = ["femi", "dayo", "tola"];

		$callback($data);
	}

	$processData = function($dataToProcess) {
		foreach ($dataToProcess as $key => $value) {
			echo '<span>'.$key.'--->'.$value.'</span><br/>';
		}
	};

	$processDataAsPara = function($dataToProcess) {
		foreach ($dataToProcess as $key => $value) {
			echo '<p>'.$key.'--->'.$value.'</p><br/>';
		}
	};


	fetchData($processData);