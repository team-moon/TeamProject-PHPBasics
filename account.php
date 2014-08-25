<?php
session_start();
$pageTitle = 'Account';

require 'includes/header.php';
/*
require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';
*/
if (!existLoggedUser()) {
    header('Location: index.php');
    exit();
}
?>
<div id="add-post-form">
	<h2>Manage Account</h2>

		<form method="POST" action="processing/manage-account.php" role="form">
			<p>
				<label for="old-password">Old password: </label>
				<input id="password" type="password" name="old-password" required />
			</p>
			<p>
				<label for="new-password">New password: </label>
				<input id="reenter-password" type="password" name="new-password" required />
			</p>
			<p>
				<input type="submit" name="change-password" value="Change" />
			</p>
		</form>
</div>
<?php
require 'includes/footer.php';