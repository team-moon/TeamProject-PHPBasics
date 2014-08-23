<form method="POST" action="processing/manage-comment.php" role="form">
    <div id="choose-post">
        <?php $posts = getAllMessagesNames($connection, false); ?>
        <select name="post" required>
            <option value="choose post">Choose Post</option>

            <?php
            for ($i = 0; $i < count($posts['message_id']); $i++) {
                echo '<option value="' . $posts['message_id'][$i] . '">' . $posts['title'][$i] . '</option>';
            }
            ?>
        </select>
        <input type="submit" name="choose-post" value="Choose post" />
    </div><!-- #choose-post -->

    <?php
    if (isset($_SESSION['current-post-comments']) || (isset($_GET['message-id']) && (int) $_GET['message-id'] > 0 && (int) $_GET['message-id'] &&
    getMessageById($connection, $_GET['message-id']))) {

        if(!isset($_SESSION['current-post-comments'])) {
            $currentPostId = (int) $_GET['message-id'];

            $post = getMessageById($connection, $currentPostId);
            $_SESSION['post-comments'] = $post;
            $_SESSION['current-post-comments'] = $currentPostId;
        }
    ?>
        <div id="choose-comments">
            <?php $comments = getPostComments($connection, $_SESSION['current-post-comments']); ?>
            <select name="comment" required >
                <option value="choose comment">Choose Comment</option>

                <?php
                for ($i = 0; $i < count($comments['comment_id']); $i++) {
                    echo '<option value="' . $comments['comment_id'][$i] . '">' . $comments['date'][$i] . '</option>';
                }
                ?>
            </select>
            <input type="submit" name="show-comment" value="Show" /> or
            <input type="submit" name="delete-comment" value="Delete" />
        </div><!-- #choose-comments -->

        <?php
        if (isset($_SESSION['current-comment-id']) || (isset($_GET['comm-id']) && (int) $_GET['comm-id'] > 0 && (int) $_GET['comm-id'] &&
            getPostComments($connection, $_SESSION['current-post-comments']))) {

            if(isset($_SESSION['current-comment-id'])) {
                $id = $_SESSION['current-comment-id'];
            } else {
                $id = (int) $_GET['comm-id'];
            }

            $comments = getPostComments($connection, $_SESSION['current-post-comments']);

            $comment = getCommentById($connection, $id);
            if (isset($_SESSION['temp-comment-text']) && isset($_SESSION['temp-comment-date']) &&
                isset($_SESSION['post-comments'])) {

                $text = $_SESSION['temp-comment-text'];
                $dateComm = $_SESSION['temp-comment-date'];
            } else {
                $text = $comment['comment_content'];
                $dateComm = $comment['date'];
            }
            ?>
            <div id="change-comment-data">
                <p>Change comments data: <span>"<?php echo $dateComm; ?>"</span></p>
                <label for="commDate">Date commented: </label><input type="text" name="commDate" id="commDate" value="<?php echo $dateComm; ?>" required /><br/>
                <label for="commText">Text: </label><textarea name="commText" id="commText" required><?php echo $text; ?></textarea><br/>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="submit" name="change-comment-data" value="Change" />
                <input type="submit" name="cancel-comment-data" value="Cancel" />
            </div><!-- #change-user-access -->
        <?php } ?>
    <?php } ?>
</form>