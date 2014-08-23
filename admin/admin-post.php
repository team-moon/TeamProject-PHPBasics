<form method="POST" action="processing/manage-posts.php" role="form">
    <div id="choose-post">
        <?php $messages = getAllMessagesNames($connection, false); ?>
        <select name="post">
            <option value="choose post">Choose Post</option>

            <?php
            for ($i = 0; $i < count($messages['message_id']); $i++) {
                echo '<option value="' . $messages['message_id'][$i] . '">' . $messages['title'][$i] . '</option>';
            }
            ?>
        </select>
        <input type="submit" name="show-post" value="Show" /> or
        <input type="submit" name="delete-post" value="Delete" />
    </div><!-- #choose-user -->

    <?php
    if (isset($_GET['post-id']) && (int) $_GET['post-id'] > 0 && (int) $_GET['post-id'] &&
        getMessageById($connection, $_GET['post-id'])) {

        $id = (int) $_GET['post-id'];

        $message = getMessageById($connection, $id);
        if (isset($_SESSION['temp-post-title']) && isset($_SESSION['temp-post-datePublished']) &&
            isset($_SESSION['temp-post-tags']) && isset($_SESSION['temp-post-text'])) {

            $title = $_SESSION['temp-post-title'];
            $datePub = $_SESSION['temp-post-datePublished'];
            $tags = $_SESSION['temp-post-tags'];
            $text = $_SESSION['temp-post-text'];
        } else {
            $title = $message['title'];
            $datePub = $message['date_published'];
            $tags = $message['tags'];
            $text = $message['body'];
        }
    ?>
        <div id="change-post-data">
            <p>Change the data of post: <span>"<?php echo $title; ?>"</span></p>
            <label for="postTitle">Title: </label><input type="text" name="postTitle" id="postTitle" value="<?php echo $title; ?>" required /><br/>
            <label for="postDate">Date: </label><input type="datetime" name="postDate" id="postDate" value="<?php echo $datePub; ?>" required /><br/>
            <label for="postText">Text: </label><textarea name="postText" id="postText" required><?php echo $text; ?></textarea><br/>
            <label for="postCategory">Category: </label><select name="postCategory" required>
                <?php
                $categories = getAllCategories($connection);
                if (isset($_SESSION['temp-post-categoryId'])) {
                    $postCategoryId = $_SESSION['temp-post-categoryId'];
                } else {
                    $postCategoryId = $message['category_id'];
                }
                for ($i = 0; $i < count($categories['category_id']); $i++) {
                    $categoryName = $categories['category_name'][$i];
                    $categoryId = $categories['category_id'][$i];

                    if ($postCategoryId == $categoryId) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    echo '<option value="' . $categoryId . '" id="' . $categoryName . '" ' . $selected . '>' . $categoryName . '</option>';
                }
                ?>
            </select>
            <label for="postTags">Tags: </label><input type="text" name="postTags" id="postTags" value="<?php echo $tags; ?>" required /><br/>
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="submit" name="change-post-data" value="Change" />
            <input type="submit" name="cancel-post-data" value="Cancel" />
        </div><!-- #change-user-access -->
    <?php } ?>
</form>
