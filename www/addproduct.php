<?php
	session_start();

	# import functions lib..
	include 'includes/functions.php';

	# determine if user is logged in.
	Utils::checkLogin();

	# title
	$title = "Store: Add Product";

	# include dashboard header
	include 'includes/dashboard_header.php';

	# include db connection
	include 'includes/connection.php';

	# track errors
	$errors = [];

	# file destination
	$destination = "";

	# max file size
	define('MAX_FILE_SIZE', '2097152');

	# allowed extensions
	$ext = ["image/jpg", "image/png", "image/jpeg"];

	# be sure if the user clicked the submit button
	if(array_key_exists('add', $_POST)) {
		if(empty($_POST['book_name'])) {
			$errors['book_name'] = "please enter a book name";
		}

		if(empty($_POST['author'])) {
			$errors['author'] = "please enter author name";
		}

		if(empty($_POST['price'])) {
			$errors['price'] = "please enter a price";
		}

		if(empty($_POST['cat'])) {
			$errors['cat'] = "please select a category";
		}

		# was a file selected...?
		if(empty($_FILES['img']['name'])) {
			$errors['img'] = "Please select a file";
		}

		# is size OK...
		if($_FILES['img']['size'] > MAX_FILE_SIZE) {
			$errors['img'] = "File size too large. allowed:2mb";
		}

		# check format
		if(!in_array(strtolower($_FILES['img']['type']), $ext)) {
			$errors['img'] = "File format not supported.";
		}

		# upload the ffile
	    $check = Utils::uploadFile("uploads/", $_FILES, "img");

		if($check[0]){
			$destination = $check[1];
		} else {
			$errors['img'] = "Files not uploaded";
		}

		# if everything is OK...
		if(empty($errors)) {

			$clean = array_map('trim', $_POST);
			$clean['loc'] = $destination;

			# do insert and redirect...
			Utils::doAddProduct($conn, $clean);
			Utils::redirect('addproduct.php', "");
		}
	}

?>

<div class="wrapper">
	<div id="stream">
		
		<h1 id="register-label">Add Product</h1>
		<hr>
		<form id="register"  action ="addproduct.php" method ="POST" enctype="multipart/form-data">
			<div>
				<?php Utils::displayError('book_name', $errors); ?>
				<label>Book name:</label>
				<input type="text" name="book_name" placeholder="Book name">
			</div>

			<div>
				<?php Utils::displayError('author', $errors); ?>
				<label>Author:</label>
				<input type="text" name="author" placeholder="Author">
			</div>

			<div>
				<?php Utils::displayError('price', $errors); ?>
				<label>Price:</label>
				<input type="text" name="price" placeholder="Price">
			</div>

			<div>
				<label>Select Category:</label>
				<select name="cat">
					<?php
						Utils::fetchCategories($conn, function($data) {
							$result = "";

							while ($row = $data->fetch(PDO::FETCH_BOTH)) {
								$result .= '<option value="'.$row[0].'">'.$row[1].'</option>';
							}

							echo $result;
						});
					?>
				</select>
			</div>

			<div>
				<?php Utils::displayError('img', $errors); ?>
				<label>Select an image:</label>
				<input type="file" name="img">
			</div>

			<input type="submit" name="add" value="add">
		</form>


	</div>
</div>


<?php
	
	include 'includes/footer.php';

?>