<?php
require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';
require 'includes/messages.php';

if (existLoggedUser()) {
    $username = $_SESSION['username'];
    $userId = $_SESSION['userId'];
}
if(!isset($_SESSION['accessLevel'])) {
    $_SESSION['accessLevel'] = 0;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php printf('%s | %s', $pageTitle, APPLICATION_NAME); ?></title>
        <link rel="stylesheet" href="css/styles.css" />
		
		<script src="includes/script.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <header id="header">
                <h1 id="logo">
                    <a href="index.php">Team moon's awesome forum</a>
                </h1>

                <?php $countAllPosts = countAllPosts($connection); ?>
                <nav id="main-nav" role="navigation">
                    <ul>
                        <li>
                            <a <?php checkForCurrentPage($pageTitle, 'Posts') ?> href="posts.php">Posts (<?php echo $countAllPosts; ?>)</a>
                        </li>
						<li>
                            <a <?php checkForCurrentPage($pageTitle, 'Users') ?> href="users.php">Users</a>
                        </li>
						<?php if($_SESSION['accessLevel'] > 0) { ?>
                        <li>
                            <a <?php checkForCurrentPage($pageTitle, 'Add Post') ?> href="add-post.php">Add Post</a>
                        </li>
						<?php } ?>
						<?php if($_SESSION['accessLevel'] > 0) { ?>
                        <li>
                            <a <?php checkForCurrentPage($pageTitle, 'Account') ?> href="account.php">Account</a>
                        </li>
						<?php } ?>
                        <?php if($_SESSION['accessLevel'] > 1) { ?>
                        <li>
                            <a <?php checkForCurrentPage($pageTitle, 'Add Category') ?> href="add-category.php">Add Category</a>
                        </li>
                        <?php } ?>
                        <?php if($_SESSION['accessLevel'] > 2) { ?>
                        <li>
                            <a <?php checkForCurrentPage($pageTitle, 'Administration') ?> href="administration.php">Administration</a>
                        </li>
                        <?php } ?>
                    </ul>
					<div id="search-box">
						<form method="POST" action="search.php" role="form">
							<input type="text" name="searchText" placeholder="search..." required />
							<input type="submit" name="search" value="Search" />
						</form>
					</div><!-- #search-box -->
                </nav><!-- #main-nav -->
			 </header><!-- #header -->
			 
			<div id="asides">
			<aside>
				<?php if (existLoggedUser()) { ?>       
					<header>User Panel</header>				
                    <div id="hello-user">
                        <p>Hello, <?php echo $username . ' ' . printAccessLevelName($connection, $_SESSION['accessLevel']); ?></p>
						<hr>
						<ul>
                	        <li><a href="index.php">POSTS</a></li>
                	        <li><a href="add-post.php">ADD POST</a></li>
                	        <li><a href="account.php">ACCOUNT</a></li>
						</ul>               
						<hr>
                    <a href="processing/logout.php">Logout</a>
					</div>                
                <?php } else { ?>
					<header>Log In</header>
                    <div id="log_in">
                        <form method="POST" action="processing/check-user.php" role="form">
                            <input type="text" name="username" placeholder="username" placeholder="username" required autocomplete="on" />
                            <input type="password" name="password" placeholder="password" placeholder="password" required />
                            <input type="submit" name="user-action" value="Login" />
                        </form>
						<br>
						<a href="register.php">Don't have an account? Sign up!</a>
                    </div>
					<div id="sign_up">
						<div>Sign Up:</div>
						<form action="" method="post">
							<input type="text" name="sign_up_user_name" placeholder="User Name...">
							<br>
							<input type="password" name="sign_up_password" placeholder="Password...">
							<br>
							<input type="text" name="repeat_sign_up_password" placeholder="Repeat Password...">
							<br>
							<input type="submit" value="Sign Up">
						</form>
					</div>
                <?php } ?>
			</aside>
			<aside>
				<header>Links</header>
				<div id="friends_links">
					<ul>
						<li><a href="https://softuni.bg/">Software University</a></li>
						<li><a href="http://www.nakov.com/">Svetlin Nakov</a></li>
                        <li><a href="http://chochev.eu">Chochev.eu</a></li>
                        <li><a href="http://www.alexkondov.wordpress.com/">AlexKondov.wordpress.com</a></li>
                        <li><a href="http://www.petarivanov.com/">PetarIvanov.com</a></li>
                        <li><a href="http://www.vitoshacademy.com/">VitoshAcademy.com</a></li>
                        <li><a href="http://stoyanstoyanov.eu">StoyanStoyanov.eu</a></li>
					</ul>
				</div>
			</aside>
			</div>

            <div id="content">
                <?php
                if (isset($_SESSION['messages'])) {
                    echo $_SESSION['messages'];
                    unset($_SESSION['messages']);
                }
