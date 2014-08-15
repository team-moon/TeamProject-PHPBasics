<?php

session_start();

require '../includes/config.php';
require '../includes/connection.php';
require '../includes/functions.php';
require '../includes/messages.php';

// If the form is not submitted or if the user does not have 
// enough access level forward the user to the index page
if (!isset($_GET['post']) || $_SESSION['accessLevel'] < 2) {
    header('Location: ../index.php');
    exit();
}

$messageId = (int) $_GET['post'];
$messageId = mysqli_real_escape_string($connection, $messageId);

$sql = "DELETE FROM `messages`
        WHERE `message_id` = '" . $messageId . "'
        LIMIT 1";

$query = mysqli_query($connection, $sql);

$_SESSION['messages'] = $messages['successfullDelete'];
header('Location: ../posts.php');
exit();