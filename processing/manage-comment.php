<?php

session_start();

require_once '../includes/config.php';
require_once '../includes/connection.php';
require_once '../includes/functions.php';
require_once '../includes/messages.php';

// If the user does not have enough access
// level forward the user to the index page
if ($_SESSION['accessLevel'] < 3) {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['choose-post'])) {
    $pId = safeInput($_POST['post']);

    if ($pId == 'choose post') {
        $_SESSION['messages'] = $messages['choosePost'];
        header('Location: ../administration.php');
        exit();
    }

    if (isset($_POST['choose-post'])) {
        header('Location: ../administration.php?message-id=' . $pId);
        exit();
    }
}

if (isset($_POST['show-comment']) || isset($_POST['delete-comment'])) {
    $cId = safeInput($_POST['comment']);

    if ($cId == 'choose comment') {
        $_SESSION['messages'] = $messages['chooseComment'];
        header('Location: ../administration.php?message-id=' . $pId);
        exit();
    }

    if (isset($_POST['show-comment'])) {
        header('Location: ../administration.php?message-id=' . $pId . '&comm-id=' . $cId);
        exit();
    }

    if (isset($_POST['delete-comment'])) {
        deleteComment($connection, $cId);
        unset($_SESSION['$post-comments']);
        unset($_SESSION['current-post-comments']);
        $_SESSION['messages'] = $messages['commentDeleted'];
        header('Location: ../administration.php');
        exit();
    }
}

if (isset($_POST['change-comment-data'])) {
    $id = safeInput($_POST['id']);

    if (existSuchCommentId($connection, $id)) {
        $commentDate = safeInput($_POST['commDate']);
        $commentText = safeInput($_POST['commText']);

        // Keep entries for the user in case of not valid data
        $_SESSION['temp-comment-date'] = $commentDate;
        $_SESSION['temp-comment-text'] = $commentText;

        // Check for empty field
        if (trim($_POST['commDate']) == '' || trim($commentText) == '') {
            $_SESSION['messages'] = $messages['emptyFields'];
            header('Location: ../administration.php?post-id=' . $id);
            exit();
        }

        if (trim($commentDate) == '') {
            $_SESSION['messages'] = $messages['chooseComment'];
            header('Location: ../administration.php?post-id=' . $id);
            exit();
        }

        $redirectPageOnFalse = 'administration.php?post-id=' . $id;
        validatePostMessage($commentText, $messages, $redirectPageOnFalse);

        $commentDate = mysqli_real_escape_string($connection, $commentDate);
        $commentText = mysqli_real_escape_string($connection, $commentText);

        changeComment($connection, $id, $commentDate, $commentText, $messages);
    } else {
        $_SESSION['messages'] = $messages['noSuchPost'];
        unset($_SESSION['$post-comments']);
        unset($_SESSION['current-post-comments']);
        unset($_SESSION['temp-comment-date']);
        unset($_SESSION['temp-comment-text']);
        unset($_SESSION['current-comment-id']);
        header('Location: ../administration.php');
        exit();
    }
}

if (isset($_POST['cancel-comment-data'])) {
    unset($_SESSION['$post-comments']);
    unset($_SESSION['current-post-comments']);
    unset($_SESSION['temp-comment-date']);
    unset($_SESSION['temp-comment-text']);
    unset($_SESSION['current-comment-id']);
    header('Location: ../administration.php');
    exit();
}