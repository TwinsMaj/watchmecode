<?php
	session_start();

	# import functions lib..
	include 'includes/functions.php';

	# determine if user is logged in.
	Utils::checkLogin();

	# title
	$title = "Store: Add Category";

	# include dashboard header
	include 'includes/dashboard_header.php';

	# include db connection
	include 'includes/connection.php';

	# track errors
	$errors = [];

	if(array_key_exists('add', $_POST)) {

		if(empty($_POST['cat_name'])) {
			$errors['cat_name'] = "Please enter a category name";
		}

		if(empty($errors)) {
			$clean = array_map('trim', $_POST);

			Utils::addCategory($conn, $clean);

		}

	}
?>

<div class="wrapper">
	<div id="stream">
		
		<h1 id="register-label">Add Category</h1>
		<hr>
		<form id="register"  action ="add_category.php" method ="POST">
			<div>
				<?php Utils::displayError('cat_name', $errors); ?>
				<label>category name:</label>
				<input type="text" name="cat_name" placeholder="category name">
			</div>

			<input type="submit" name="add" value="add">
		</form>


	</div>
</div>


<?php
	
	include 'includes/footer.php';

?>