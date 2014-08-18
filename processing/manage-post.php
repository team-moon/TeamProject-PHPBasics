<?php

session_start();

require '../includes/config.php';
require '../includes/connection.php';
require '../includes/functions.php';
require '../includes/messages.php';

// If the form is not submitted forward the user to the index page
if (!isset($_POST['add-post'])) {
    header('Location: ../index.php');
    exit();
}

$title = $_POST['title'];
$categoryId = $_POST['category'];
$message = $_POST['message'];
$tags = $_POST['tags'];

// Keep entries for the user in case of not valid data
$_SESSION['temp-title'] = $title;
$_SESSION['temp-categoryId'] = $categoryId;
$_SESSION['temp-message'] = $message;
$_SESSION['temp-tags'] = $tags;

// Check for empty field
if (trim($title) == '' || trim($message) == '') {
    $_SESSION['messages'] = $messages['emptyFields'];
    header('Location: ../add-post.php');
    exit();
}

if (trim($categoryId) == '') {
    $_SESSION['messages'] = $messages['chooseCategory'];
    header('Location: ../add-post.php');
    exit();
}

$title = safeInput($title);
$categoryId = safeInput($categoryId);
$message = safeInput($message);
$tags = safeInput($tags);

validateTitle($title, $messages);
validateMessage($message, $messages);
validateCategory($connection, $categoryId, $messages);
validateTags($tags, $messages);

$title = mysqli_real_escape_string($connection, $title);
$message = mysqli_real_escape_string($connection, $message);
$categoryId = mysqli_real_escape_string($connection, $categoryId);
$tags = mysqli_real_escape_string($connection, $tags);

// Insert message
$sql = "INSERT INTO `messages`
        VALUES (NULL, '" . $categoryId . "', '" . $_SESSION['userId'] . "',
                NOW(), '" . $title . "', '" . $tags . "', '" . $message . "')";

$query = mysqli_query($connection, $sql);
$_SESSION['messages'] = $messages['successfullPublish'];

header('Location: ../add-post.php');
exit();