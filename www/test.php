<?php
	include 'includes/connection.php';
	include 'includes/functions.php';

	$admins = Utils::showAdmins($conn);
	echo $admins;

