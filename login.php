<?php
session_start();
session_regenerate_id(true);
$pageTitle = 'Login';

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
			<input type="text" name="username" placeholder="username" placeholder="username" required autocomplete="on" />
            <input type="password" name="password" placeholder="password" placeholder="password" required />
            <input type="submit" name="user-action" value="Login" />
		</form>
</div>

<?php
if (isset($_SESSION['temp-username'])) {
    unset($_SESSION['temp-username']);
}

require 'includes/footer.php';
