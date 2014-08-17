<?php
session_start();

require 'includes/config.php';
require 'includes/connection.php';
require 'includes/functions.php';

if (!existLoggedUser()) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Post';

require 'includes/header.php';

if (isset($_GET['id'])) {
    $messageId = (int) $_GET['id'];
    $messageId = mysqli_real_escape_string($connection, $messageId);
}
if(isset($_POST['comment'])){
        $error = false;
        $comment_content=trim($_POST['comment_content']);
        $comment_content=mysqli_real_escape_string($connection, $comment_content);
        
        if(mb_strlen($comment_content) < 5) {
            echo '<div class="error">Прекалено къс коментар!</div>';
            $error = true;
        }
        
        if(!$error) {
            $userId=$_SESSION['userId'];
            $result = mysqli_query($connection, "INSERT INTO comments (message_id,user_id,comment_content) VALUES ('$messageId','$userId','$comment_content')");
            echo '<div class="success">Успешно коментирахте тази книга!</div>';
        }
    }
$sql = 'SELECT * FROM messages WHERE message_id=' . $messageId;
    $result = mysqli_query($connection, $sql);
    if ($result->num_rows <= 0) {
        header('Location: index.php');
        exit;
    } else {
        $row = $result->fetch_assoc();
    }

    // заявка към базата
    if(!$sql){
        echo 'Грешка в базата данни';
    }
    echo'<article id="home-article">   
    <header>       
        <h2>Въпрос: '.$row['title'].'</h2>   
    </header>
    <p>
        '.$row['body'].'
    </p>
    </article>';
    echo '<div id="messages-content">';
    echo '<hr><span class="message-author"><h5>Коментари:</h5> <br>';
    
    $sql = 'SELECT * FROM comments
        LEFT JOIN users
        ON comments.user_id = users.user_id
        WHERE message_id=' . (int) $_GET['id'];
    $result = mysqli_query($connection, $sql);
    
    if ($result->num_rows <= 0) {
        echo '<div class="error">Няма коментари към този въпрос!</div>';
    }
    else{
        $counter = 1;
        while ($row = $result->fetch_assoc()) {
        echo '<div class="comment-holder">';
            echo  $counter .'. <a href="user.php?user=' . $row['user_id'] . '">' . $row['name'] . '</a> | ' . $row['date'] . '
        <br><span class="comment">' . $row['comment_content'] . '</span><br>
        </div>
        ';
            $counter++;
        }
        echo '</span></p>';
    }

    echo '</div>';
    if (existLoggedUser()) {
        echo '<form method="POST" class="styledForm" action="#" >
            <fieldset>
                <legend>Коментар</legend>
                Коментар: <input type="text" name="comment_content" /><br>
                <input type="submit" name="comment" value="Изпрати" />
            </fieldset>
        </form>';
    }
    else{
        echo '<div style="text-align: center;"><a href="login.php" style="color: red!important;font-size: 28px;">За да напишете коментар <br/>Влезте си в профила!</a></div>';
    }
require 'includes/footer.php';