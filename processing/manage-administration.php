<?php

session_start();

require '../includes/config.php';
require '../includes/connection.php';
require '../includes/functions.php';
require '../includes/messages.php';

// If the user does not have enough access 
// level forward the user to the index page
if ($_SESSION['accessLevel'] < 3) {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['show-user']) || isset($_POST['delete-user'])) {
    $id = safeInput($_POST['user']);

    if ($id == 'choose user') {
        $_SESSION['messages'] = $messages['chooseUser'];
        header('Location: ../administration.php');
        exit();
    }

    if ($id == $_SESSION['userId']) {
        $_SESSION['messages'] = $messages['canNotAdminYourself'];
        header('Location: ../administration.php');
        exit();
    }
    
    if (isset($_POST['show-user'])) {
        $level = getAccessLevelByUserId($connection, $id);
        header('Location: ../administration.php?user-id=' . $id . '&level=' . $level);
        exit();
    }
    
   if (isset($_POST['delete-user'])) {
        deleteUser($connection, $id);
        $_SESSION['messages'] = $messages['userDeleted'];
        header('Location: ../administration.php');
        exit();
    }
}

if (isset($_POST['change-user-access'])) {
    $accessLevelId = safeInput($_POST['access-level-id']);
    $id = safeInput($_POST['id']);

    if (existSuchUserId($connection, $id) &&
        existSuchAccessLevelId($connection, $accessLevelId) &&
        $id != $_SESSION['userId']) {
        
        changeAccessLevel($connection, $id, $accessLevelId, $messages);
    } else {
        $_SESSION['messages'] = $messages['noSuchUserOrAccessLevel'];
        header('Location: ../administration.php');
        exit();
    }
}

if (isset($_POST['cancel-change-user-access'])) {
    header('Location: ../administration.php');
    exit();
}