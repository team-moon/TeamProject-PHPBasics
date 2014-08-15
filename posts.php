<?php
session_start();

require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';

if (!existLoggedUser()) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Posts';

require 'includes/header.php';
?>
<h2>All Posts</h2>

<div id="filter-form">
    <form method="POST" action="processing/manage-filter.php" role="form">        
        <?php $categories = getAllCategories($connection); ?>
        <select name="category">
            <option value="all">all categories</option>
            <?php
            for ($i = 0; $i < count($categories['category_id']); $i++) {
                if (isset($_GET['cat']) && $_GET['cat'] == $categories['category_id'][$i]) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }

                echo '<option value="' . $categories['category_id'][$i] . '" ' . $selected . '>';
                echo $categories['category_name'][$i];
                echo '</option>';
            }
            ?>
        </select>

        <?php $allAuthors = getAllUsers($connection); ?>
        <select name="author">
            <option value="all">all authors</option>
            <?php
            for ($i = 0; $i < count($allAuthors['user_id']); $i++) {
                if (isset($_GET['author']) && $_GET['author'] == $allAuthors['user_id'][$i]) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }

                echo '<option value="' . $allAuthors['user_id'][$i] . '" ' . $selected . '>';
                echo $allAuthors['name'][$i];
                echo '</option>';
            }
            ?>
        </select>

        <select name="sort">
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] == 'asc') {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            ?>
            <option value="desc">latest</option>
            <option value="asc" <?php echo $selected; ?>>oldest</option>
        </select>

        <input type="submit" value="Filter" name="filter" />
    </form>
</div><!-- #filter-form -->

<?php
$filterForPagination = '';

if (isset($_GET['cat']) && $_GET['cat'] != '') {
    $categoryFilter = "msg.category_id = '" . (int) mysqli_real_escape_string($connection, $_GET['cat']) . "'";
    $filterForPagination .= '&cat=' . $_GET['cat'];
} else {
    $categoryFilter = "";
}

if (isset($_GET['author']) && $_GET['author'] != '') {
    $authorFilter = "msg.author_id = '" . (int) mysqli_real_escape_string($connection, $_GET['author']) . "'";
    $filterForPagination .= '&author=' . $_GET['author'];
} else {
    $authorFilter = "";
}

if ((isset($_GET['sort']) && $_GET['sort'] == 'asc')) {
    $orderBy = "ORDER BY msg.date_published ASC";
    $filterForPagination .= '&sort=' . $_GET['sort'];
} else if (isset($_GET['sort']) && $_GET['sort'] == 'desc') {
    $orderBy = "ORDER BY msg.date_published DESC";
    $filterForPagination .= '&sort=' . $_GET['sort'];
} else {
    $orderBy = "ORDER BY msg.date_published DESC";
}

$finalFilter = '';

if ($categoryFilter != '' && $authorFilter == '') {
    $finalFilter = "WHERE " . $categoryFilter;
} else if ($categoryFilter != '' && $authorFilter != '') {
    $finalFilter = "WHERE " . $categoryFilter . " AND " . $authorFilter;
} else if ($categoryFilter == '' && $authorFilter != '') {
    $finalFilter = "WHERE " . $authorFilter;
}

if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
} else {
    $page = 1;
}

$ofset = ($page * POSTS_PER_PAGE) - POSTS_PER_PAGE;

$sql = "
    SELECT *
    FROM `messages` AS msg

    LEFT JOIN `categories` AS cat
    ON msg.category_id = cat.category_id

    LEFT JOIN `users` AS usr
    ON msg.author_id = usr.user_id
    " . $finalFilter . "
    " . $orderBy . "
    LIMIT " . $ofset . ", " . POSTS_PER_PAGE . "
";

$query = mysqli_query($connection, $sql);
$countFilteredPosts = $query->num_rows;

$sqlWithoutLimit = "
    SELECT *
    FROM `messages` AS msg

    LEFT JOIN `categories` AS cat
    ON msg.category_id = cat.category_id

    LEFT JOIN `users` AS usr
    ON msg.author_id = usr.user_id
    " . $finalFilter . "
";

$queryWithoutLimit = mysqli_query($connection, $sqlWithoutLimit);
$countFilteredPostsWithoutLimit = $queryWithoutLimit->num_rows;
?>

<?php while ($row = $query->fetch_assoc()) { ?>
    <?php
    $messageId = $row['message_id'];
    $categoryId = $row['category_id'];
    $categoryName = $row['category_name'];
    $authorId = $row['author_id'];
    $authorName = $row['name'];
    $datePublished = date('d/m/Y', strtotime($row['date_published']));
    $title = $row['title'];
    $body = nl2br($row['body']);
    ?>

    <article class="post">
        <header class="post-header">
            <h1><?php echo $title; ?></h1>
        </header><!-- .post-header -->

        <div class="post-body">
            <p><?php echo $body; ?></p>
        </div><!-- .post-body -->

        <footer class="post-footer">
            Posted on <?php echo $datePublished; ?> by
            <a href="posts.php?author=<?php echo $authorId; ?>" title="Posts by <?php echo $authorName; ?>"><?php echo $authorName; ?></a>
            in <a href="posts.php?cat=<?php echo $categoryId; ?>" title="View all posts in <?php echo $categoryName; ?>"><?php echo $categoryName; ?></a>

            <?php if ($_SESSION['accessLevel'] > 1) { ?>            
                ( <a class="delete" href="processing/delete.php?post=<?php echo $messageId; ?>" title="Delete this post">delete</a> )
            <?php } ?>
        </footer><!-- .post-footer -->
    </article><!-- .post -->
<?php } ?>

<?php if ($countAllPosts == 0) { ?>
    <div class="no-posts">
        Currently there are no posts. Be the one to make first post
        <a title="Add Post" href="add-post.php">here</a>.
    </div>
<?php } else if ($countAllPosts > 0 && $countFilteredPosts == 0) { ?>
    <div class="no-posts">
        There are no posts for your filter criterion.
    </div>
<?php } else if ($countFilteredPostsWithoutLimit > POSTS_PER_PAGE) {
     require 'includes/pagination.php';
}
require 'includes/footer.php';