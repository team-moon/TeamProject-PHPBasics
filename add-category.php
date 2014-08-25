<?php
session_start();

require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';

if (!existLoggedUser()) {
    header('Location: index.php');
    exit();
}

if ($_SESSION['accessLevel'] < 2) {
    header('Location: posts.php');
    exit();
}

$pageTitle = 'Add Category';

require 'includes/header.php';
?>
<div id="add-post-form">
	<h2>Add New Category</h2>
		<form method="POST" action="processing/manage-categories.php" role="form">
			<p>
				<label for="category">Category: </label>
				<input id="category" type="text" name="category" required />
			</p>
			<p>
				<input type="submit" name="add-category" value="Add" />
			</p>
		</form>
</div><!-- #add-post-form -->

<?php
require 'includes/footer.php';