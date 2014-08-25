<?php

session_start();

require_once '../includes/config.php';
require_once '../includes/connection.php';
require_once '../includes/functions.php';
require_once '../includes/messages.php';

// If the form is not submitted forward the user to the index page
if (!isset($_POST['filter'])) {
    header('Location: ../posts.php');
    exit();
}

$categoryId = $_POST['category'];
$authorId = $_POST['author'];
$sort = $_POST['sort'];

if ($categoryId == 'all' && $authorId == 'all') {
    header('Location: ../posts.php?sort=' . $sort);
} else if ($categoryId == 'all' && $authorId != 'all') {
    header('Location: ../posts.php?author=' . $authorId . '&sort=' . $sort);
} else if ($categoryId != 'all' && $authorId == 'all') {
    header('Location: ../posts.php?cat=' . $categoryId . '&sort=' . $sort);
} else {
    header('Location: ../posts.php?cat=' . $categoryId . '&author=' . $authorId . '&sort=' . $sort);
}

exit();