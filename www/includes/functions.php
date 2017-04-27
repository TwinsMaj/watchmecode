<?php
	class Utils 
	{
		public static function checkLogin() {
			if(!isset($_SESSION['admin_id'])) {
				static::redirect("admin_login.php", "");
			}
		}

		public static function displayError($key, $arr) {

			if(isset($arr[$key])) {
				echo '<span class="err">'.$arr[$key]. '</span>';
			}

		}


		public static function doRegistration($dbconn, $input) {
			$stmt = $dbconn->prepare("INSERT INTO admin(firstname, lastname, email, hash) 
					VALUES(:fn, :ln, :e, :h)");

			$data = [
				":fn" => $input['fname'],
				":ln" => $input['lname'],
				":e" => $input['email'],
				":h" => $input['password']
			];

			$stmt->execute($data);
		} 


		public static function doesEmailExist($dbconn, $email) {
			$result = false;

			$stmt = $dbconn->prepare("SELECT * FROM admin WHERE email=:e");
			$stmt->bindParam(":e", $email); 

			$stmt->execute();

			# count result set
			$count = $stmt->rowCount();

			if($count > 0) { $result = true; }

			return $result;
		}


		public static function doLogin($dbconn, $input) {
			$result = [];

			$stmt = $dbconn->prepare("SELECT admin_id, hash FROM admin WHERE email=:e");
			$stmt->bindParam(":e", $input['email']);

			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_BOTH);

			# if either the email or password is wrong, we return a false array
			if( ($stmt->rowCount() != 1) || !password_verify($input['password'], $row['hash']) ) {

			Utils::redirect("admin_login.php? +msg=", "either username or password is incorrect");
				exit();
			} else {
				# return true plus extra information...
				$result[] = true;
				$result[] = $row['admin_id'];
			}

			return $result;
		}


		public static function redirect($loc, $msg) {
			header("Location: ".$loc.$msg);
		}

		public static function addCategory($dbconn, $input) {
			$stmt = $dbconn->prepare("INSERT INTO category(category_name) VALUES(:name)");
			$stmt->bindParam(":name", $input['cat_name']);

			$stmt->execute();
		}

		public static function curNav($page) {
			$curPage = basename($_SERVER['SCRIPT_FILENAME']);
			if($curPage == $page) {
				echo 'class="selected"';
			}
		}

		public static function fetchCategories($dbconn, $any = null, $cb) {
			$stmt = $dbconn->prepare("SELECT * FROM category");
			$stmt->execute();

			# delegate to cb..
			$cb($stmt, $any);
		}

		public static function showAdmins($dbconn) {
			$result = "";

			$stmt = $dbconn->prepare("SELECT * FROM admin");
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
				$result .= '<a href="profile.php?aid='.$row[0].'">'.$row[1].'</a><br/>';
			}

			return $result;
		}

		public static function extraInfo($dbconn, $admin_id) {
			$result = "";

			$stmt = $dbconn->prepare("SELECT * FROM admin WHERE admin_id=:aid");
			$stmt->bindParam(":aid", $admin_id);
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
				$result .= '<p>'.$row['email'].'</p><h3>'.$row['lastname'].'</h3><br/>';
			}

			return $result;
		}


		public static function getCategoryByID($dbconn, $cat_id) {
			$stmt = $dbconn->prepare("SELECT * FROM category WHERE category_id=:cid");
			$stmt->bindParam(":cid", $cat_id);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_BOTH);

			return $row;
		}

		public static function updateCategory($dbconn, $input) {
			$stmt = $dbconn->prepare("UPDATE category SET category_name=:name WHERE category_id=:catid");

			$data = [
				":name" => $input['cat_name'],
				":catid" => $input['cid']
			];

			$stmt->execute($data);
		}


		function deleteCategory($dbconn, $catid) {
			$stmt = $dbconn->prepare("DELETE FROM category WHERE category_id=:cid");
			$stmt->bindParam("cid", $catid);

			$stmt->execute();
		}

		public static function uploadFile($destination, $files, $key) {

			$result = [];

			$rnd = rand(00000, 99999);
			$file_name = str_replace(" ", "_", $files[$key]['name'] );

			$file_name = $rnd.$file_name;
			$destination = $destination.$file_name;

			if(move_uploaded_file($files[$key]['tmp_name'], $destination)){
				$result[] = true;
				$result[] = $destination;
		
			} else {
				$result[] = false;
			}

			return $result;

		}


		public static function doAddProduct($dbconn, $input) {
			$stmt = $dbconn->prepare("INSERT INTO book(category_id, name, author, price, img_loc) 
				VALUES(:cid, :name, :author, :price, :loc)");
			
			$data = [
				":cid" 		=> $input['cat'],
				":name" 	=> $input['book_name'],
				":author" 	=> $input["author"],
				":price" 	=> $input['price'],
				":loc" 		=> $input['loc']
			];

			$stmt->execute($data);
		}

		public static function viewProducts($dbconn) {
			$result = "";

			$stmt = $dbconn->prepare("SELECT book_id, name, author, price FROM book");
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
				$result .= '<tr><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td>
				<td><a href="editproduct.php?bid='.$row[0].'">edit</a></td>
				<td><a href="deleteproduct.php?bid='.$row[0].'">delete</a></td></tr>';
			}

			return $result;
		}


		public static function getBookByID($dbconn, $pid) {
			$stmt = $dbconn->prepare("SELECT * FROM book WHERE book_id=:bid");
			$stmt->bindParam(":bid", $pid);

			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_BOTH);

			return $row;
		}


	}