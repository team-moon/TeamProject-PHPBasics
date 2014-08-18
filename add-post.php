<?php
session_start();

require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';

if (existLoggedUser()) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Add Post';

require 'includes/header.php';

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

<h2>Add New Post</h2>

<div id="add-post-form">
    <form method="POST" action="processing/manage-post.php" role="form">
        <p>
            <label for="title">Title: </label>
            <input id="title" type="text" name="title" value="<?php echo $title; ?>" required />
        </p>
        <p>
            <label>Category:</label>
            <?php $categories = getAllCategories($connection); ?>
            <select name="category" required>
                <option value=""></option>
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
        <p>
            <label for="tags">Tags: </label>
            <input type="text" id="tags" placeholder="Input tags seperated with a space" required/>
        </p>
        <p>
            <label for="message">Message:</label>
            <textarea name="message" id="message" required><?php echo $message; ?></textarea>
        </p>
        <p>            
            <input type="submit" name="add-post" value="Publish" />
        </p>
    </form>
</div><!-- #add-post-form -->

<?php
unset($_SESSION['temp-title']);
unset($_SESSION['temp-categoryId']);
unset($_SESSION['temp-message']);

require 'includes/footer.php';