<?php
session_start();
session_regenerate_id(true);
$pageTitle = 'Sign Up';
require 'includes/header.php';
/*
require 'includes/config.php';
require 'includes/functions.php';
*/
if (existLoggedUser()) {
    header('Location: posts.php');
    exit();
}

if (isset($_SESSION['temp-username'])) {
    $username = $_SESSION['temp-username'];
} else {
    $username = '';
}
?>
<div id="add-post-form">
<h2><?php echo $pageTitle; ?></h2>

		<form method="POST" action="processing/check-user.php" role="form">
			<p>
				<label for="username">Username: </label>
				<input id="username" type="text" name="username" required autocomplete="off" value="<?php echo $username; ?>" />
			</p>
			<p>
				<label for="password">Password: </label>
				<input id="password" type="password" name="password" required />
			</p>
			<p>
				<label for="reenter-password">Re-enter password: </label>
				<input id="reenter-password" type="password" name="reenter-password" required />
			</p>
			<p>
				<input type="submit" name="user-action" value="SignUp" />
			</p>
		</form>
</div>

<?php
if (isset($_SESSION['temp-username'])) {
    unset($_SESSION['temp-username']);
}

require 'includes/footer.php';
