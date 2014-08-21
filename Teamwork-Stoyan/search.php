<?php
session_start();

require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';
require 'includes/messages.php';

if (!existLoggedUser()) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Search';

require 'includes/header.php';

if (!isset($_POST['search'])) {
    header('Location: index.php');
    exit;
}

if (trim($_POST['searchText']) == '') {
    $_SESSION['messages'] = $messages['emptySearchField'];
    header('Location: index.php');
    exit;
}

$searchText = safeInput($_POST['searchText']);
$searchText = mysqli_escape_string($connection, $searchText);
?>

<h2>Search results for <span>"<?php echo $searchText; ?>"</span></h2>

<?php
if (existSearchResults($connection, $searchText, $messages)) {
    $sql = "
        SELECT *
        FROM `messages` AS bks

        LEFT JOIN `users` AS aut
        ON bks.author_id = aut.user_id

        WHERE bks.title
        LIKE '%$searchText%'
        ORDER BY bks.title ASC
    ";

    $query = mysqli_query($connection, $sql);

    if (!$query) {
        $_SESSION['messages'] = $messages['wrongQueryExecution'];
        header('Location: index.php');
        exit;
    }

    while ($row = $query->fetch_assoc()) {
        $allInfo[$row['message_id']]['title'] = $row['title'];
        $allInfo[$row['message_id']]['author_id'] = $row['author_id'];
        $allInfo[$row['message_id']]['name'] = $row['name'];
    }
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>№</th>
                <th>Question</th>
                <th>User</th>
            </tr>
        </thead>

        <tbody>
            <?php $qustionCounter = 0; ?>
            <?php foreach ($allInfo as $key => $value) { // $key is not used yet ?>
                <?php $qustionCounter++; ?>
                <tr>
                    <td><?php echo $qustionCounter; ?>.</td>
                    <td>
                        <a href="post.php?id=<?php echo $key; ?>" title="More info about &quot;<?php echo $value['title']; ?>&quot;"><?php echo $value['title']; ?></a>
                    </td>
                    <td>
                        <a href='index.php?post=<?php echo $value['author_id']; ?>' title='question from <?php echo $value['name']; ?>'><?php echo $value['name']; ?></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php } else { ?>
    <p>There was no any question matching your search.</p>
<?php } ?>

<?php
require 'includes/footer.php';