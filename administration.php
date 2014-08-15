<?php
session_start();

require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';

if (!existLoggedUser()) {
    header('Location: index.php');
    exit();
}

if ($_SESSION['accessLevel'] < 3) {
    header('Location: posts.php');
    exit();
}

$pageTitle = 'Administration';

require 'includes/header.php';
?>

<h2>Administrate Users</h2>

<div id="admin-form">
    <form method="POST" action="processing/manage-administration.php" role="form">
        <div id="choose-user">
            <?php $users = getAllUsers($connection, false); ?>
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
        </div><!-- #choose-user -->

        <?php
        if (isset($_GET['id']) && (int) $_GET['id'] > 0 && (int) $_GET['id'] != $_SESSION['userId'] &&
            getUsernameById($connection, $_GET['id']) &&
            isset($_GET['level']) && $_GET['level'] > 0) {
            
            $id = (int) $_GET['id'];
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
                </p>
            </div><!-- #change-user-access -->
            
        <?php } ?>
    </form>
</div><!-- #admin-form -->

<?php
require 'includes/footer.php';