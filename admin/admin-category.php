<form method="POST" action="processing/manage-category.php" role="form">
    <div id="choose-category">
        <?php $categories = getAllCategories($connection, false); ?>
        <select name="category">
            <option value="choose category">Choose category</option>
            <?php
            for ($i = 0; $i < count($categories['category_id']); $i++) {
                echo '<option value="' . $categories['category_id'][$i] . '">' . $categories['category_name'][$i] . '</option>';
            }
            ?>
        </select>
        <input type="submit" name="show-category" value="Show" /> or
        <input type="submit" name="delete-category" value="Delete" />
    </div><!-- #choose-user -->

    <?php
    if (isset($_GET['cat-id']) && (int) $_GET['cat-id'] > 0 && (int) $_GET['cat-id'] &&
        getCategoryById($connection, $_GET['cat-id'])) {

        $id = (int) $_GET['cat-id'];

        $category = getCategoryById($connection, $id);
        if (isset($_SESSION['temp-category-name'])) {
            $categoryName = $_SESSION['temp-category-name'];
        } else {
            $categoryName = $category['category_name'];
        }
        ?>
        <div id="change-category-data">
            <p>Change name of category: <span>"<?php echo $categoryName; ?>"</span></p>
            <label for="postTitle">New name: </label><input type="text" name="categoryName" id="categoryName" value="<?php echo $categoryName; ?>" required /><br/>
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="submit" name="change-category" value="Change" />
            <input type="submit" name="cancel-category-change" value="Cancel" />
        </div><!-- #change-user-access -->
    <?php } ?>
</form>
