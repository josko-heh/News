<?php 
include 'database.php';

if (isset($_POST['username_check'])) {
	$username = $_POST['username'];

	$query = "SELECT * FROM users WHERE username = ?";

	$stmt = mysqli_stmt_init($dbc);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    if(!($result = mysqli_stmt_get_result($stmt))){
		echo 'error';
        die("username check query error");
    }
	else if(mysqli_num_rows($result) > 0) {
		echo "taken";	
	}else{
		echo 'not_taken';
	}
}

else if (isset($_POST['save'])) {
	$username = $_POST['username'];

	$query = "SELECT * FROM users WHERE username = ?";

	$stmt = mysqli_stmt_init($dbc);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    if(!($result = mysqli_stmt_get_result($stmt))){
		echo 'error';
        die("save->username query error");
    }
	else if (mysqli_num_rows($result) > 0) {
		echo "exists";	
	}
	else{
		$permissionId = getPermissionId($dbc, "user");
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$hashedPassword =  password_hash($_POST['password'], CRYPT_BLOWFISH);

		$query = "INSERT INTO users (name, surname, username, password, permissionId) VALUES (?, ?, ?, ?, ?)";

		$stmt = mysqli_stmt_init($dbc);
		
		mysqli_stmt_prepare($stmt, $query);
		mysqli_stmt_bind_param($stmt, 'ssssd', $name, $surname, $username, $hashedPassword, $permissionId);
		if(mysqli_stmt_execute($stmt)){
			echo 'Saved!';
		}else {
			echo 'error';
			die("insert user query error");
		}
	}
}

else if (isset($_POST['login'])) {
	$username = $_POST['username'];

	$query = "SELECT * FROM users WHERE username = ?";

	$stmt = mysqli_stmt_init($dbc);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    if(!($result = mysqli_stmt_get_result($stmt))){
		echo 'error';
        die("login->username query error");
    }
	else if (mysqli_num_rows($result) == 0) {
		echo "failed_login";
		exit();	
	}
	else{
		$hashedPassword =  password_hash($_POST['password'], CRYPT_BLOWFISH);

		$query = "	SELECT username, password, permissionId FROM users 
					WHERE username = ?";

		$stmt = mysqli_stmt_init($dbc);
		mysqli_stmt_prepare($stmt, $query);
		mysqli_stmt_bind_param($stmt, 's', $username);
		mysqli_stmt_execute($stmt);
		if(!($result = mysqli_stmt_get_result($stmt))){
			echo 'error';
			die("select user query error");
		}
		else if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_array($result);
			$username = $row['username'];
			$passwordDB = $row['password'];
			$permissionId = $row['permissionId'];
		}else{
			echo "failed_login";
			exit();
		}

		if (password_verify($_POST['password'], $passwordDB)) {
			$uspjesnaPrijava = true;

			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$_SESSION['username'] = $username;
			$_SESSION['level'] = getLevel($dbc, $permissionId);
			
			echo 'logged-in,' . $username;
		}else {
			echo 'failed_login';
		}
	}
}
?>