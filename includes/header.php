<?php
if (existLoggedUser()) {
    $username = $_SESSION['username'];
    $userId = $_SESSION['userId'];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php printf('%s | %s', $pageTitle, APPLICATION_NAME); ?></title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <div id="wrapper">
            <header id="header">
                <h1 id="logo">
                    <a href="index.php"><?php echo APPLICATION_NAME ?></a>
                </h1>

                <?php if (existLoggedUser()) { ?>                
                    <div id="hello-user">
                        <p>Hello, <?php echo $username . ' ' . printAccessLevelName($connection, $_SESSION['accessLevel']); ?> | <a href="processing/logout.php">Logout</a></p>
                    </div>                
                <?php } else { ?>
                    <div id="login-form">
                        <form method="POST" action="processing/check-user.php" role="form">
                            <input type="text" name="username" placeholder="username" placeholder="username" required autocomplete="on" />
                            <input type="password" name="password" placeholder="password" placeholder="password" required />
                            <input type="submit" name="user-action" value="Login" />
                        </form>
                    </div>
                <?php } ?>
            </header><!-- #header -->

            <?php if (existLoggedUser()) { ?>
                <?php $countAllPosts = countAllPosts($connection); ?>
                <nav id="main-nav" role="navigation">
                    <ul>
                        <li>
                            <a <?php checkForCurrentPage($pageTitle, 'Posts') ?> href="posts.php">Posts (<?php echo $countAllPosts; ?>)</a>
                        </li>
						<li>
                            <a <?php checkForCurrentPage($pageTitle, 'Users') ?> href="users.php">Users</a>
                        </li>
                        <li>
                            <a <?php checkForCurrentPage($pageTitle, 'Add Post') ?> href="add-post.php">Add Post</a>
                        </li>
                        <li>
                            <a <?php checkForCurrentPage($pageTitle, 'Account') ?> href="account.php">Account</a>
                        </li>
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
                </nav><!-- #main-nav -->
            <?php } ?>

            <div id="content">
                <?php
                if (isset($_SESSION['messages'])) {
                    echo $_SESSION['messages'];
                    unset($_SESSION['messages']);
                }
