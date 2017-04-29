
<?php

	function fetchData($callback) {
		# go to db to fetch the fllg names..
		$data = ["femi", "dayo", "tola"];

		$callback($data);
	}

	$processData = function($dataToProcess) {
		foreach ($dataToProcess as $key => $value) {
			echo '<span>'.$key.'--->'.$value.'</span><br/>';
		}
	};

	$processDataAsPara = function($dataToProcess) {
		foreach ($dataToProcess as $key => $value) {
			echo '<p>'.$key.'--->'.$value.'</p><br/>';
		}
	};


	//fetchData($processData);

function shout($lambda) {
	$lambda();
}

function message() {
	echo "well done";
};

shout(message);


function fetchCategories($err, $cb) {
	# ... fetch categories from db..
	$data = ["java", "javascript", "php", "erlang", "scala"];

	$cb($data);
}

function displayCart($dbconn, $custID) {
	$stmt  = $dbconn->prepare("SELECT * FROM cart WHERE customer_id=:cid");
	$stmt->bindParam(":cid", $custID);
	$stmt->execute();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$book = getBookByID($row['book_id']);


	}
}

1 6 11

SELECT * FROM admin LIMIT , :start, 5

$dispay = 5;

function setPages($dbconn, $dis) {
	"selec * from admin";
	$total = sql.count;

	return $total/$dis
}

$start = ($page - 1) * $display;


$pages = setPages($conn, $dispay);







$dispay = 0;

if(isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	getPageCount($conn, $dispay);
}

if(isset($_GET['start'])) {
	$start = $_GET['start'];
} else {
	$start = 1;
}


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table border="1">
		<th>categories</th>
		<tbody>
			<?php
				showViews($conn, $start);// SELECT * FROM admin LIMIT :start, 5
			?>
		</tbody>

		<?php 

			function getStart($dispay, $start) {
				returns ($start - 1)  * $dispay
			}
			for($i = 0; $i < $pages; ++$i) {
				echo '<a href="view.php?p='.$page.'&s='.getStart($dispay, $start).'">'.$i.'</a>';
			}
		?>
	</table>

	<form>
		<select name="">
			<?php 
				fetchCategories(function($msg) {
					$result = "";

					foreach ($msg as $val) {
						$result .= "<option>".$val."</option>";
					}

					echo $result;
				});
			?>
		</select>
	</form>
</body>
</html>