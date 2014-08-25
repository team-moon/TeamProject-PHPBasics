<?php
session_start();

require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';

if (!existLoggedUser()) {
    header('Location: index.php');
    exit();
}

if ($_SESSION['accessLevel'] < 3) {
    header('Location: posts.php');
    exit();
}

$pageTitle = 'Administration';

require 'includes/header.php';
?>
<div id="add-post-form">
	<h2>Administration page</h2>
	<div id="admin-form">
		<div id="user-administration">
			<h3>Users administration</h3>
			<?php
				require 'admin/admin-user.php';
			?>
		</div>
		<div id="post-administration">
			<h3>Posts administration</h3>
			<?php
				require 'admin/admin-post.php';
			?>
		</div>
		<div id="comments-administration">
			<h3>Comments administration</h3>
			<?php
				require 'admin/admin-comment.php';
			?>
		</div>
		<div id="categories-administration">
			<h3>Categories administration</h3>
			<?php
				require 'admin/admin-category.php';
			?>
		</div>
        <div id="ranks-administration">
            <h3>Ranks administration</h3>
            <?php
            require 'admin/admin-ranks.php';
            ?>
        </div>
	</div><!-- #admin-form -->
</div>
<?php
unset($_SESSION['temp-post-title']);
unset($_SESSION['temp-post-datePublished']);
unset($_SESSION['temp-post-tags']);
unset($_SESSION['temp-post-text']);
unset($_SESSION['temp-post-categoryId']);
unset($_SESSION['temp-category-name']);

require 'includes/footer.php';