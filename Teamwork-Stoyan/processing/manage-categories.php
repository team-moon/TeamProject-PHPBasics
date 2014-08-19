<?php

session_start();

require '../includes/config.php';
require '../includes/connection.php';
require '../includes/functions.php';
require '../includes/messages.php';

// If the form is not submitted or if the user does not have 
// enough access level forward the user to the index page
if (!isset($_POST['add-category']) || $_SESSION['accessLevel'] < 2) {
    header('Location: ../index.php');
    exit();
}

$categoryName = $_POST['category'];

// Check for empty field
if (trim($categoryName) == '') {
    $_SESSION['messages'] = $messages['emptyFields'];
    header('Location: ../add-category.php');
    exit();
}

// Validate category
if (mb_strlen($categoryName) < 2 || mb_strlen($categoryName) > 16) {
    $_SESSION['messages'] = $messages['categoryNotValidLength'];
    header('Location: ../add-category.php');
    exit();
}

$categoryName = safeInput($categoryName);
$categoryName = mysqli_real_escape_string($connection, $categoryName);

if (categoryExist($connection, $categoryName)) {
    $_SESSION['messages'] = $messages['categoryExist'];
    header('Location: ../add-category.php');
    exit();
} else {
    insertCategory($connection, $categoryName, $messages);
}