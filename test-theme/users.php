<?php
session_start();

require '../includes/config.php';
require '../includes/connection.php';
require '../includes/functions.php';

if (existLoggedUser()) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Users';

require 'header.php';
?>
<h2>All Users</h2>

<?php

if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
} else {
    $page = 1;
}

$ofset = ($page * POSTS_PER_PAGE) - POSTS_PER_PAGE;

$sql = "
    SELECT *
    FROM `users`
";

$query = mysqli_query($connection, $sql);
$countFilteredPosts = $query->num_rows;

$sqlWithoutLimit = "
    SELECT *
    FROM `users`;
";

$queryWithoutLimit = mysqli_query($connection, $sqlWithoutLimit);
$countFilteredPostsWithoutLimit = $queryWithoutLimit->num_rows;
?>

<?php while ($row = $query->fetch_assoc()) { ?>
    <?php
    $userid = $row['user_id'];
    $username = $row['name'];
    $activity = $row['activity'];
    ?>

    <article class="post">
        <header class="post-header">
            <a href="posts.php?author=<?php echo $userid; ?>"><h1><?php echo $username; ?></h1> Points: <?php echo $activity; ?></a>
        </header><!-- .post-header -->
    </article><!-- .post -->
<?php } 
require 'footer.php';