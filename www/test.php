<?php
	function multiple($x) {
		return $x * $x;
	}

	$num = [1, 2, 3, 4];

	foreach ($num as $value) {
		# code...
		echo multiple($value);
		echo '<br/>';
	}

	$newArray = array_map('multiple', $num);

	print_r($newArray);