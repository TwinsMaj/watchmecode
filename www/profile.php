<?php
	include 'includes/connection.php';
	include 'includes/functions.php';

	$admin_id = $_GET['aid'];
	$data = Utils::extraInfo($conn, $admin_id);
	echo $data;