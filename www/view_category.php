<?php
	session_start();
	
	# import functions lib..
	include 'includes/functions.php';

	# determine if user is logged in.
	Utils::checkLogin();

	# title
	$title = "Store: View Category";

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
						<th>category id</th>
						<th>category name</th>
						<th>edit</th>
						<th>delete</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						#$categoryList = Utils::fetchCategories($conn); 
						#echo $categoryList;

						Utils::fetchCategories($conn, function($data) {
							$result = "";

							while ($row = $data->fetch(PDO::FETCH_BOTH)) {
								$result .= '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td>
								<td><a href="editcategory.php?cat_id='.$row[0].'">edit</a></td>
								<td><a href="deletecategory.php?cat_id='.$row[0].'">delete</a></td></tr>';
							}

							echo $result;
						});
					?>
          		</tbody>
			</table>
	</div>
</div>


<?php
	
	include 'includes/footer.php';

?>