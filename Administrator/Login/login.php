<?php
session_start();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true){
	header("location: ../AdminDisplays/Dashboard/dashboard.php");
	exit;
}
require_once "../Database/config.php";

$username_err = '';
$password_err = '';
$login_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get username and password from form data
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	// Validate username and password
	if (empty($username)) {
		$username_err = "Please enter username.";
	} else {
		$username = mysqli_real_escape_string($conn, $username);
	}
	if (empty($password)) {
		$password_err = "Please enter your password.";
	} else {
		$password = mysqli_real_escape_string($conn, $password);
	}

	// Check if username and password are valid
	if (empty($username_err) && empty($password_err)) {
		$sql = "SELECT id, username, password, clearance FROM users WHERE username = ?";
		if ($stmt = mysqli_prepare($conn, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			$param_username = $username;

			if (mysqli_stmt_execute($stmt)) {
				mysqli_stmt_store_result($stmt);

				if (mysqli_stmt_num_rows($stmt) == 1) {
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $clearance);

					if (mysqli_stmt_fetch($stmt)) {
						if (password_verify($password, $hashed_password)) {
							// Password is correct, start a new session
							session_start();

							// Store data in session variables
							$_SESSION["logged_in"] = true;
							$_SESSION["id"] = $id;
							$_SESSION["username"] = $username;
							$_SESSION["clearance"] = $clearance;

							// Redirect user to dashboard
							header("location: ../AdminDisplays/Dashboard/dashboard.php");
							exit();
						} else {
							// Display an error message if password is not valid
							$password_err = "The password you entered was not valid.";
						}
					}
				} else {
					// Display an error message if username doesn't exist
					$username_err = "No account found with that username.";
				}
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}
	mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="login.css">
	<title>Admin Login</title>
</head>

<body>
	<header>
		<img src="../../Photos/wma-logo.png" />
	</header>

	<main>
		<div class="login_form">
			<form name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<fieldset>
					<legend>Admin's Login</legend>
					<div class="form_fields">
						<div class="input_fields">
							<span><?php echo $username_err; ?></span>
							<label for="username">Username: </label>
							<input type="text" name="username" placeholder="Enter Username:" />
						</div>

						<div class="input_fields">
							<span><?php echo $password_err; ?></span>
							<label for="password">Password: </label>
							<input type="password" name="password" placeholder="Enter Password:" />
						</div>
					</div>
					<button id="submit" name="submit" type="submit" onclick="resetForm()">
						LOGIN
					</button>
				</fieldset>
			</form>
		</div>
	</main>
</body>

</html>