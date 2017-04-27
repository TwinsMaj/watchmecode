<?php
	session_start();

	# import functions lib..
	include 'includes/functions.php';

	# determine if user is logged in.
	Utils::checkLogin();

	# title
	$title = "Store: Edit Product";

	# include dashboard header
	include 'includes/dashboard_header.php';

	# include db connection
	include 'includes/connection.php';

	# check or query string in incoming request
	if(isset($_GET['bid'])) {
		$bookID = $_GET['bid'];
	}

	# get a book obj
	$item = Utils::getBookByID($conn, $bookID);

	# get the category for this item
	$category = Utils::getCategoryByID($conn, $item['category_id']);
	//print_r($category); exit();

	# track errors
	$errors = [];


?>

<div class="wrapper">
	<div id="stream">
		
		<h1 id="register-label">Edit Product</h1>
		<hr>
		<form id="register"  action ="editproduct.php" method ="POST" enctype="multipart/form-data">
			<div>
				<?php Utils::displayError('book_name', $errors); ?>
				<label>Book name:</label>
				<input type="text" name="book_name" placeholder="Book name" value="<?php echo $item['name']; ?>">
			</div>

			<div>
				<?php Utils::displayError('author', $errors); ?>
				<label>Author:</label>
				<input type="text" name="author" placeholder="Author" value="<?php echo $item['author']; ?>">
			</div>

			<div>
				<?php Utils::displayError('price', $errors); ?>
				<label>Price:</label>
				<input type="text" name="price" placeholder="Price" value="<?php echo $item['price']; ?>">
			</div>

			<div>
				<label>Select Category:</label>
				<select name="cat">
					<option><?php echo $category['category_name']; ?></option>
					<?php 

						Utils::fetchCategories($conn, $category['category_name'], function($stmt, $val) {
							$result = "";

							while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

								if($row['category_name'] == $val) 
									continue;

								$result .= '<option value="'.$row[0].'">'.$row[1].'</option>';
							}

							echo $result;
						});

					?>
				</select>
			</div>

			<input type="submit" name="add" value="add">
		</form>

		<h4 class="jumpto">Upload new image: <a href="changeimage.php">change</a></h4>
	</div>
</div>

<?php
	
	include 'includes/footer.php';

?>