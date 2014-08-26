<form method="POST" action="processing/manage-administration.php" role="form">
    <div id="choose-user">
        <?php $users = getAllUsers($connection, false);
            if($users != null && count($users['user_id']) > 0) { ?>
        <select name="user">
            <option value="choose user">Choose User</option>

            <?php
            for ($i = 0; $i < count($users['user_id']); $i++) {
                echo '<option value="' . $users['user_id'][$i] . '">' . $users['name'][$i] . '</option>';
            }
            ?>
        </select>
        <input type="submit" name="show-user" value="Show" /> or
        <input type="submit" name="delete-user" value="Delete" />
        <?php } else { ?>
        <p class="error-msg">There are no users to administrate!</p>
        <?php } ?>
    </div><!-- #choose-user -->

    <?php
    if (isset($_GET['user-id']) && (int) $_GET['user-id'] > 0 && (int) $_GET['user-id'] != $_SESSION['userId'] &&
        getUsernameById($connection, $_GET['user-id']) &&
        isset($_GET['level']) && $_GET['level'] > 0) {

        $id = (int) $_GET['user-id'];
        $level = (int) $_GET['level'];

        $username = getUsernameById($connection, $id);
        ?>

        <div id="change-user-access">
            <p>Change the access level of user: <span><?php echo $username; ?></span></p>
            <p>
                <?php
                $accessLevels = getAllAccessLevels($connection);

                for ($i = 0; $i < count($accessLevels['access_lvl']); $i++) {
                    $accessLevelName = $accessLevels['access_name'][$i];
                    $accessLevelId = $accessLevels['access_lvl'][$i];

                    if ($level == $accessLevelId) {
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }

                    echo '<input type="radio" name="access-level-id" value="' . $accessLevelId . '" id="' . $accessLevelName . '" ' . $checked . ' />';
                    echo '<label for="' . $accessLevelName . '">' . $accessLevelName . '</label>';
                }
                ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="submit" name="change-user-access" value="Change" />
                <input type="submit" name="cancel-change-user-access" value="Cancel" />
            </p>
        </div><!-- #change-user-access -->
    <?php } ?>
</form>
