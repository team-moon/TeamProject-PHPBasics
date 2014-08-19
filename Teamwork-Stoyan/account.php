<?php
session_start();

require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';

if (!existLoggedUser()) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Account';

require 'includes/header.php';
?>

<h2>Manage Account</h2>

<div id="change-passwd-form">
    <form method="POST" action="processing/manage-account.php" role="form">
        <p>
            <label for="old-password">Old password: </label>
            <input id="password" type="password" name="old-password" required />
        </p>
        <p>
            <label for="new-password">New password: </label>
            <input id="reenter-password" type="password" name="new-password" required />
        </p>
        <p>
            <input type="submit" name="change-password" value="Change" />
        </p>
    </form>
</div><!-- #change-passwd-form -->

<?php
require 'includes/footer.php';