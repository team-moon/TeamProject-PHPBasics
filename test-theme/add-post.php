<?php
session_start();

require '../includes/config.php';
require '../includes/connection.php';
require '../includes/functions.php';

if (existLoggedUser()) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Add Post';

require 'header.php';

if (isset($_SESSION['temp-title']) &&
    isset($_SESSION['temp-categoryId']) &&
    isset($_SESSION['temp-message'])) {
    
    $title = $_SESSION['temp-title'];
    $categoryId = $_SESSION['temp-categoryId'];
    $message = $_SESSION['temp-message'];   
} else {
    $title = '';
    $categoryId = '';
    $message = '';  
}
?>
	<div id="asides">
			<aside class="fixed-aside">
				<?php if (!existLoggedUser()) { ?>                
                    <header>User Panel</header>
                    <div id="hello-user">
                        <p>Hello, <?php echo $username . ' ' ?></p>
                        <hr>
                	<ul>
                	               	<li><a href="">POSTS</a></li>
                	               	<li><a href="add-post.php">ADD POST</a></li>
                	               	<li><a href="">ACCOUNT</a></li>
					</ul>
					<hr>
					<a href="processing/logout.php">Logout</a>               
                    </div>
                <?php } ?>
            </aside>
</div>


    <div id="add-post-form">
    	<header>Add Post</header>
    <form method="POST" action="processing/manage-post.php" role="form">
        <p>
            <label for="title">TITLE: </label>
            <input id="title" type="text" name="title" value="<?php echo $title; ?>" required placeholder="POST TITLE"/>
        </p>
        <hr>
        <p>
            <label>CATEGORY:</label>
            <?php $categories = getAllCategories($connection); ?>
            <select name="category" required>
                <option value="">-CATEGORIES-</option>
                <?php
                for ($i = 0; $i < count($categories['category_id']); $i++) {
                    if ($categoryId == $categories['category_id'][$i]) {
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
        </p>
        <hr>
        <p>
            <label for="tags">TAGS: </label>
            <input type="text" name="tags" placeholder="INPUT TAGS" required/>
        </p>
        <hr>
        <p>
            <label for="message" id="message">MESSAGE:</label>
            <textarea name="message" id="message" required><?php echo $message; ?></textarea>
        </p>
        <p>            
            <input type="submit" name="add-post" value="Publish" />
        </p>
    </form>
</div><!-- #add-post-form -->


<?php
	require 'footer.php';
?>