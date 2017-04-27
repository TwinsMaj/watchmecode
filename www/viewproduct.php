<?php
	session_start();
	
	# import functions lib..
	include 'includes/functions.php';

	# determine if user is logged in.
	Utils::checkLogin();

	# title
	$title = "Store: View Product";

	# include dashboard header
	include 'includes/dashboard_header.php';

	# include db connection
	include 'includes/connection.php';
?>

<div class="wrapper">
	<div id="stream">
		<table id="tab">
				<thead>
					<tr>
						<th>Book Name</th>
						<th>author</th>
						<th>price</th>
						<th>edit</th>
						<th>delete</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
						$listProducts = Utils::viewProducts($conn);
						echo $listProducts;
					?>
          		</tbody>
			</table>
	</div>
</div>

<?php
	
	include 'includes/footer.php';

?>