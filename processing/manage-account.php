<?php

session_start();

require_once '../includes/config.php';
require_once '../includes/connection.php';
require_once '../includes/functions.php';
require_once '../includes/messages.php';

// If a form is not submitted forward the
// user to the index page
if (!isset($_POST['change-password'])) {
    header('Location: ../index.php');
    exit();
}

$oldPassword = $_POST['old-password'];
$newPassword = $_POST['new-password'];

// Check for empty fields
if (trim($oldPassword) == '' || trim($newPassword) == '') {
    $_SESSION['messages'] = $messages['emptyFields'];
    header('Location: ../account.php');
    exit();
}

// Validate both passwords
if (mb_strlen($oldPassword) < 5 || mb_strlen($oldPassword) > 16 ||
        mb_strlen($newPassword) < 5 || mb_strlen($newPassword) > 16) {
    $_SESSION['messages'] = $messages['passwdNotValidLength'];
    header('Location: ../account.php');
    exit();
}

$oldPassword = safeInput($oldPassword);
$newPassword = safeInput($newPassword);

$newPassword = mysqli_real_escape_string($connection, $newPassword);

if (oldPasswordMath($connection, $oldPassword)) {
    $sql = "UPDATE `users`
            SET `passwd` = '" . $newPassword . "'
            WHERE `user_id` = '" . $_SESSION['userId'] . "'";
    
    $query = mysqli_query($connection, $sql);
    $_SESSION['messages'] = $messages['passwordChanged'];
    header('Location: ../account.php');
    exit();
} else {
    $_SESSION['messages'] = $messages['wrongOldPassword'];
    header('Location: ../account.php');
    exit();
}