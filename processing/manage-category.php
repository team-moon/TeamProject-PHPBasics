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

if (isset($_POST['show-category']) || isset($_POST['delete-category'])) {
    $id = safeInput($_POST['category']);

    if ($id == 'choose category') {
        $_SESSION['messages'] = $messages['chooseCategory'];
        header('Location: ../administration.php');
        exit();
    }

    if (isset($_POST['show-category'])) {
        header('Location: ../administration.php?cat-id=' . $id);
        exit();
    }

    if (isset($_POST['delete-category'])) {
        deleteCategory($connection, $id, $messages);
        $_SESSION['messages'] = $messages['categoryDeleted'];
        header('Location: ../administration.php');
        exit();
    }
}

if (isset($_POST['change-category'])) {
    $id = safeInput($_POST['id']);

    if (existSuchCategoryId($connection, $id)) {
        $categoryName = safeInput($_POST['categoryName']);

        // Keep entries for the user in case of not valid data
        $_SESSION['temp-category-name'] = $categoryName;

        // Check for empty field
        if (trim($_POST['categoryName']) == '') {
            $_SESSION['messages'] = $messages['emptyFields'];
            header('Location: ../administration.php?cat-id=' . $id);
            exit();
        }

        $redirectPageOnFalse = 'administration.php?cat-id=' . $id;
        validateCategoryTitle($categoryName, $messages, $redirectPageOnFalse);

        $categoryName = mysqli_real_escape_string($connection, $categoryName);

        if (categoryExist($connection, $categoryName)) {
            $_SESSION['messages'] = $messages['categoryExist'];
            header('Location: ../' . $redirectPageOnFalse);
            exit();
        } else {
            changeCategoryName($connection, $id, $categoryName, $messages);
        }
    } else {
        $_SESSION['messages'] = $messages['noSuchCategory'];
        header('Location: ../administration.php');
        exit();
    }
}

if (isset($_POST['cancel-category-change'])) {
    header('Location: ../administration.php');
    exit();
}