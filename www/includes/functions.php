<?php
	class Utils 
	{
		public static function checkLogin() {
			if(!isset($_SESSION['admin_id'])) {
				Utils::redirect("admin_login.php", "");
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

		public static function fetchCategories($dbconn) {
			$result = "";

			$stmt = $dbconn->prepare("SELECT * FROM category");
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
				$result .= '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td>
				<td><a href="editcategory.php?cat_id='.$row[0].'">edit</a></td>
				<td><a href="deletecategory.php?cat_id='.$row[0].'">delete</a></td></tr>';
			}

			return $result;
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

	}