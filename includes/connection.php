<?php

// Local
define('SQL_HOST', 'XXXXXXXX');
define('SQL_USER', 'XXXXXXXX');
define('SQL_PASS', 'XXXXXXXX');
define('SQL_DB', 'XXXXXXXX');

$connection = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

// Check connection
if (mysqli_connect_errno()) {    
    if (DEBUG) {
        printf('Connect failed: %s', mysqli_connect_error());
    }
    
    exit;
}

mysqli_set_charset($connection, 'utf8');