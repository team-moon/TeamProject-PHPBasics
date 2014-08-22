<?php

mb_internal_encoding('UTF-8');

/**
 * Check if there is any logged user
 * 
 * @return boolean
 */
function existLoggedUser() {
    if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
        return true;
    } else {
        return false;
    }
}

/**
 * Keep data for the logged user in the session
 * 
 * @param int $userId
 * @param string $username
 * @param int $accessLevel
 */
function keepDataForLoggedUser($userId, $username, $accessLevel = 1) {
    $_SESSION['isLogged'] = true;
    $_SESSION['userId'] = $userId;
    $_SESSION['username'] = $username;
    $_SESSION['accessLevel'] = $accessLevel;
}

/**
 * Print access level name of the current user
 * 
 * @param object $connection
 * @param int $accessLevel
 * @return string/void
 */
function printAccessLevelName($connection, $accessLevel) {
    $sql = "SELECT * FROM access_levels";
    $query = mysqli_query($connection, $sql);

    while ($row = $query->fetch_assoc()) {
        if ($accessLevel == $row['access_lvl'] && $accessLevel != 1) {
            return '(' . $row['access_name'] . ')';
        }
    }
}

/**
 * Return class "current" if it is in that page
 * 
 * @param string $pageTitle
 * @param string $currentLink
 * @return string/void
 */
function checkForCurrentPage($pageTitle, $currentLink) {
    if ($pageTitle == $currentLink) {
        echo 'class="current"';
    }
}

/**
 * Normalize data
 * 
 * @param string $string
 * @return string
 */
function safeInput($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

/**
 * Validate the username and if it's not valid
 * show user a message
 * 
 * @param string $username
 * @param array $messages
 * @return void
 */
function validateUsername($username, $messages) {
    if (mb_strlen($username) < 5 || mb_strlen($username) > 16) {
        $_SESSION['messages'] = $messages['usernameNotValidLength'];
        $_SESSION['temp-username'] = $username;
        header('Location: ../index.php');
        exit();
    }

    if (!ctype_alnum(str_replace('_', '', $username))) {
        $_SESSION['messages'] = $messages['usernameNotValidContent'];
        $_SESSION['temp-username'] = $username;
        header('Location: ../index.php');
        exit();
    }
}

/**
 * Validate the password and if it's not valid
 * show user a message
 * 
 * @param string $password
 * @param string $reenterPassword
 * @param array $messages
 * @return void
 */
function validatePassword($password, $reenterPassword, $messages) {
    if (mb_strlen($password) < 5 || mb_strlen($password) > 16 ||
            mb_strlen($reenterPassword) < 5 || mb_strlen($reenterPassword) > 16) {
        $_SESSION['messages'] = $messages['passwdNotValidLength'];
        header('Location: ../index.php');
        exit();
    }

    if ($password !== $reenterPassword) {
        $_SESSION['messages'] = $messages['passwordsNotMatch'];
        header('Location: ../index.php');
        exit();
    }
}

function validateTitle($title, $messages) {
    if (mb_strlen($title) < 5 || mb_strlen($title) > 50) {
        $_SESSION['messages'] = $messages['titleNotValidLength'];
        header('Location: ../add-post.php');
        exit();
    }
}

function validateCategory($connection, $categoryId, $messages) {
    $allCategories = getAllCategories($connection);

    if (!in_array($categoryId, $allCategories['category_id'])) {
        $_SESSION['messages'] = $messages['noSuchCategory'];
        header('Location: ../add-post.php');
        exit();
    }
}

function validateMessage($message, $messages) {
    if (mb_strlen($message) < 1 || mb_strlen($message) > 250) {
        $_SESSION['messages'] = $messages['messageNotValidLength'];
        header('Location: ../add-post.php');
        exit();
    }
}
function validateTags($tags) {
    if (strlen($tags) < 1 || strlen($tags) > 100) {
        $_SESSION['messages'] = $messages['tagsInvalidLength'];
        header('Location: ../add-post.php');
        exit();
    }
}

/**
 * Check if the old password match
 * 
 * @param object $connection
 * @param string $oldPassword
 * @return boolean
 */
function oldPasswordMath($connection, $oldPassword) {
    $sql = "SELECT `passwd`
            FROM `users`
            WHERE `user_id` = '" . $_SESSION['userId'] . "'";

    $query = mysqli_query($connection, $sql);
    $row = $query->fetch_assoc();

    if ($oldPassword === $row['passwd']) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check if the username already exist
 * 
 * @param object $connection
 * @param string $username
 * @return boolean
 */
function usernameExist($connection, $username) {
    $sql = "SELECT * FROM `users`
            WHERE `name` = '" . $username . "'";

    $query = mysqli_query($connection, $sql);

    if ($query->num_rows == 1) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check if already exist category with this name
 * 
 * @param object $connection
 * @param string $categoryName
 * @return boolean
 */
function categoryExist($connection, $categoryName) {
    $sql = "SELECT `category_name`
            FROM `categories`
            WHERE `category_name` = '" . $categoryName . "'";

    $query = mysqli_query($connection, $sql);

    if ($query->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function existSearchResults($connection, $searchText, $messages) {
    $sql = "SELECT `title`
            FROM `messages`
            WHERE `title`
            LIKE '%$searchText%'";

    $query = mysqli_query($connection, $sql);

    if (!$query) {
        $_SESSION['messages'] = $messages['wrongQueryExecution'];
        header('Location: index.php');
        exit;
    }

    $result = $query->num_rows;

    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}

function insertCategory($connection, $categoryName, $messages) {
    $sql = "INSERT INTO `categories`
            VALUES (NULL, '" . $categoryName . "')";

    $query = mysqli_query($connection, $sql);

    if ($query) {
        $_SESSION['messages'] = $messages['categoryInserted'];
        header('Location: ../add-category.php');
        exit();
    } else {
        $_SESSION['messages'] = $messages['categoryNotInserted'];
        header('Location: ../add-category.php');
        exit();
    }
}

function getAllUsers($connection, $includeCurrentUser = true) {
    if ($includeCurrentUser) {
        $sql = "SELECT `user_id`, `name`, `access_lvl`
                FROM `users`";
    } else {
        $sql = "SELECT `user_id`, `name`, `access_lvl`
                FROM `users`
                WHERE `user_id` != '" . $_SESSION['userId'] . "'";
    }

    $query = mysqli_query($connection, $sql);

    while ($row = $query->fetch_assoc()) {
        $users['user_id'][] = $row['user_id'];
        $users['name'][] = $row['name'];
    }

    return $users;
}

function getAllCategories($connection) {
    $sql = "SELECT *
            FROM `categories`";

    $query = mysqli_query($connection, $sql);

    while ($row = $query->fetch_assoc()) {
        $categories['category_id'][] = $row['category_id'];
        $categories['category_name'][] = $row['category_name'];
    }

    return $categories;
}

function getAllAccessLevels($connection) {
    $sql = "SELECT *
            FROM `access_levels`";

    $query = mysqli_query($connection, $sql);

    while ($row = $query->fetch_assoc()) {
        $accessLevels['access_lvl'][] = $row['access_lvl'];
        $accessLevels['access_name'][] = $row['access_name'];
    }

    return $accessLevels;
}

function getUsernameById($connection, $id) {
    $id = mysqli_real_escape_string($connection, $id);
    
    $sql = "SELECT `name`
            FROM `users`
            WHERE `user_id` = '" . $id . "'";

    $query = mysqli_query($connection, $sql);
    $row = $query->fetch_assoc();

    return $row['name'];
}

function getAccessLevelByUserId($connection, $id) {
    $id = mysqli_real_escape_string($connection, $id);
    
    $sql = "SELECT `access_lvl`
            FROM `users`
            WHERE `user_id` = '" . $id . "'";

    $query = mysqli_query($connection, $sql);
    $row = $query->fetch_assoc();

    return $row['access_lvl'];
}

function existSuchUserId($connection, $id) {
    $id = mysqli_real_escape_string($connection, $id);
    
    $sql = "SELECT `user_id`
            FROM `users`
            WHERE `user_id` = '" . $id . "'";

    $query = mysqli_query($connection, $sql);

    if ($query->num_rows == 1) {
        return true;
    } else {
        return false;
    }
}

function existSuchAccessLevelId($connection, $accessLevelId) {
    $accessLevelId = mysqli_real_escape_string($connection, $accessLevelId);
    
    $sql = "SELECT `access_lvl`
            FROM `access_levels`
            WHERE `access_lvl` = '" . $accessLevelId . "'";

    $query = mysqli_query($connection, $sql);

    if ($query->num_rows == 1) {
        return true;
    } else {
        return false;
    }
}

function changeAccessLevel($connection, $id, $accessLevelId, $messages) {
    $id = mysqli_real_escape_string($connection, $id);
    $accessLevelId = mysqli_real_escape_string($connection, $accessLevelId);
            
    $sql = "UPDATE `users`
            SET `access_lvl` = '" . $accessLevelId . "'
            WHERE `user_id` = '" . $id . "'";

    $query = mysqli_query($connection, $sql);

    $_SESSION['messages'] = $messages['successfullUpdate'];
    header('Location: ../administration.php');
    exit();
}

function countAllPosts($connection) {
    $sql = "SELECT COUNT(*)
            FROM `messages`";

    $query = mysqli_query($connection, $sql);
    $row = $query->fetch_assoc();
    
    return $row['COUNT(*)'];
}

function deleteUser($connection, $id) {
    $id = mysqli_real_escape_string($connection, $id);
    
    // Delete all posts written by this user
    
    $sql = "DELETE FROM `messages`
            WHERE `author_id` = '" . $id . "'";
    
    $query = mysqli_query($connection, $sql);
    
    // Delete the user
    
    $sql = "DELETE FROM `users`
            WHERE `user_id` = '" . $id . "'
            LIMIT 1";
    
    $query = mysqli_query($connection, $sql);
}