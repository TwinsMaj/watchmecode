<?php
	session_start();

	# import functions lib..
	include 'includes/functions.php';

	# determine if user is logged in.
	Utils::checkLogin();

	# include db connection
	include 'includes/connection.php';

	# expect incoming request to come with an id..
	if(isset($_GET['cat_id'])) {
		$catID = $_GET['cat_id'];
	}

	# handle delete
	Utils::deleteCategory($conn, $catID);

	# redirect 
	Utils::redirect('view_category.php', "");