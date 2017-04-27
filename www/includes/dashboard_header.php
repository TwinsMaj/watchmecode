<!DOCTYPE html>
<html>
<head>
	<title>TEST</title>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>

<body>
	<section>
		<div class="mast">
			<h1>T<span>SSB</span></h1>
			<nav>
				<ul class="clearfix">
					<li><a href="add_category.php" <?php Utils::curNav("add_category.php"); ?>>add category</a></li>
					<li><a href="view_category.php" <?php Utils::curNav("view_category.php"); ?>>view category</a></li>
					<li><a href="addproduct.php" <?php Utils::curNav("addproduct.php"); ?>>add product</a></li>
					<li><a href="viewproduct.php" <?php Utils::curNav("viewproduct.php"); ?>>view product</a></li>
				</ul>
			</nav>
		</div>
	</section>