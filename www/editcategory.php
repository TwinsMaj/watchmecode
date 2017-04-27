<?php
	session_start();

	# import functions lib..
	include 'includes/functions.php';

	# determine if user is logged in.
	Utils::checkLogin();

	# title
	$title = "Store: Edit Category";

	# include dashboard header
	include 'includes/dashboard_header.php';

	# include db connection
	include 'includes/connection.php';

	# expect incoming request to come with an
	if(isset($_GET['cat_id'])) {
		$catID = $_GET['cat_id'];
	}

	# use DAO to fetch the current object's
	# data..
	$item = Utils::getCategoryByID($conn, $catID);

	$errors = [];

	if(array_key_exists('edit', $_POST)) {
		if(empty($_POST['cat_name'])) {
			$errors['cat_name'] = "Please enter a category name";
		}

		if(empty($errors)) {
			$clean = array_map('trim', $_POST);
			$clean['cid'] = $catID;

			# do update..
			Utils::updateCategory($conn, $clean);

			# redirect..
			#Utils::redirect("view_category.php", "");
		}
	}
	
?>

<div class="wrapper">
	<div id="stream">
		
		<h1 id="register-label">Edit Category</h1>
		<hr>
		<form id="register"  action ="" method ="POST">
			<div>
				<?php Utils::displayError('cat_name', $errors); ?>
				<label>category name:</label>
				<input type="text" name="cat_name" placeholder="category name" value="<?php echo $item[1]; ?>">
			</div>

			<input type="submit" name="edit" value="edit">
		</form>


	</div>
</div>


<?php
	
	include 'includes/footer.php';

?>