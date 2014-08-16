<?php

// Local
define('SQL_HOST', 'localhost');
define('SQL_USER', 'root');
define('SQL_PASS', 'localhost');
define('SQL_DB', 'message_board_db');

$connection = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

// Check connection
if (mysqli_connect_errno()) {    
    if (DEBUG) {
        printf('Connect failed: %s', mysqli_connect_error());
    }
    
    exit;
}

mysqli_set_charset($connection, 'utf8');