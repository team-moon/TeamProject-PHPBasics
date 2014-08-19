<?php

session_start();

require '../includes/functions.php';

if (!existLoggedUser()) {
    header('Location: ../index.php');
    exit();
}

session_unset();
session_destroy();
header('Location: ../index.php');
exit();