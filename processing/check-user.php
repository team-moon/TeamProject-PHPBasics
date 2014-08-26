<?php

session_start();


require_once '../includes/config.php';
require_once '../includes/connection.php';
require_once '../includes/functions.php';
require_once '../includes/messages.php';


// If a form is not submitted forward the
// user to the index page
if (!isset($_POST['user-action'])) {
    header('Location: ../index.php');
    exit();
}

$userAction = $_POST['user-action'];
$username = $_POST['username'];
$password = $_POST['password'];

// Check for empty fields
if (trim($username) == '' || trim($password) == '' ||
        (isset($_POST['reenter-password']) && trim($_POST['reenter-password']) == '')) {
    $_SESSION['messages'] = $messages['emptyFields'];
    header('Location: ../index.php');
    exit();
}

$username = safeInput($username);
$password = safeInput($password);

$username = mysqli_real_escape_string($connection, $username);
$password = mysqli_real_escape_string($connection, $password);

switch ($userAction) {
    case 'Login':
        $sql = "SELECT * FROM `users`
                WHERE `name` = '" . $username . "'";

        $query = mysqli_query($connection, $sql);

        if ($query->num_rows == 1) {
            $row = $query->fetch_assoc();

            if ($username == $row['name'] && $password == $row['passwd']) {
                keepDataForLoggedUser($row['user_id'], $row['name'], $row['access_lvl']);
                header('Location: ../posts.php');
                exit();
                break;
            }
        }

        $_SESSION['messages'] = $messages['wrongUsernameOrPass'];
        header('Location: ../index.php');
        exit();
        break;
    case 'SignUp':
        $reenterPassword = safeInput($_POST['reenter-password']);

        // Validate data
        validateUsername($username, $messages);
        validatePassword($password, $reenterPassword, $messages);

        if (usernameExist($connection, $username)) {
            $_SESSION['messages'] = $messages['usernameExist'];
            $_SESSION['temp-username'] = $username;
            header('Location: ../index.php');
            exit();
        }

        $sql = "INSERT INTO `users`
                VALUES (NULL, '" . $username . "', '" . $password . "', DEFAULT, 1)";

        $query = mysqli_query($connection, $sql);

        $userId = mysqli_insert_id($connection);

        keepDataForLoggedUser($userId, $username);
        header('Location: ../posts.php');
        exit();
        break;
    default:
        $_SESSION['messages'] = $messages['wrongFormSubmission'];
        header('Location: ../index.php');
        exit();
        break;
}