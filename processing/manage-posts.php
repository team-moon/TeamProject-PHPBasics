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

if (isset($_POST['show-post']) || isset($_POST['delete-post'])) {
    $id = safeInput($_POST['post']);

    if ($id == 'choose post') {
        $_SESSION['messages'] = $messages['choosePost'];
        header('Location: ../administration.php');
        exit();
    }

    if (isset($_POST['show-post'])) {
        header('Location: ../administration.php?post-id=' . $id);
        exit();
    }

    if (isset($_POST['delete-post'])) {
        deleteMessage($connection, $id);
        $_SESSION['messages'] = $messages['postDeleted'];
        header('Location: ../administration.php');
        exit();
    }
}

if (isset($_POST['change-post-data'])) {
    $id = safeInput($_POST['id']);

    if (existSuchPostId($connection, $id)) {
        $postTitle = safeInput($_POST['postTitle']);
        $postDate = safeInput($_POST['postDate']);
        $postText = safeInput($_POST['postText']);
        $postCategory = safeInput($_POST['postCategory']);
        $postTags = safeInput($_POST['postTags']);

        // Keep entries for the user in case of not valid data
        $_SESSION['temp-post-title'] = $postTitle;
        $_SESSION['temp-post-datePublished'] = $postDate;
        $_SESSION['temp-post-tags'] = $postTags;
        $_SESSION['temp-post-text'] = $postText;
        $_SESSION['temp-post-categoryId'] = $postCategory;

        // Check for empty field
        if (trim($_POST['postTitle']) == '' || trim($postText) == '') {
            $_SESSION['messages'] = $messages['emptyFields'];
            header('Location: ../administration.php?post-id=' . $id);
            exit();
        }

        if (trim($postCategory) == '') {
            $_SESSION['messages'] = $messages['chooseCategory'];
            header('Location: ../administration.php?post-id=' . $id);
            exit();
        }

        $redirectPageOnFalse = 'administration.php?post-id=' . $id;
        validatePostTitle($postTitle, $messages, $redirectPageOnFalse);
        validatePostMessage($postText, $messages, $redirectPageOnFalse);
        validatePostCategory($connection, $postCategory, $messages, $redirectPageOnFalse);
        validatePostTags($postTags, $messages, $redirectPageOnFalse);

        $postTitle = mysqli_real_escape_string($connection, $postTitle);
        $postText = mysqli_real_escape_string($connection, $postText);
        $postCategory = mysqli_real_escape_string($connection, $postCategory);
        $postTags = mysqli_real_escape_string($connection, $postTags);

        changePost($connection, $id, $postTitle, $postDate, $postText, $postCategory, $postTags, $messages);
    } else {
        $_SESSION['messages'] = $messages['noSuchPost'];
        header('Location: ../administration.php');
        exit();
    }
}

if (isset($_POST['cancel-post-data'])) {
    header('Location: ../administration.php');
    exit();
}