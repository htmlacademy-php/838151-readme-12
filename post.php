<?php

session_start();

require_once('helpers.php');

if ($_SESSION['id'] == "") {
    header("Location: /");
};

$ind = $_GET['id'] ?? '';

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");

/**
 * return post from db
 * @param string $id
 * @return array
 */
function getPost(string $id): array
{
    $sql = "SELECT post.title, text, likes, name, picture, video, link, content_id, avatar, class_name, count_view, user_id FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id WHERE post.id = $id ORDER BY post.count_view DESC ";
    return requestDb($sql);
};

function getComments($id)
{
    $sql = "SELECT comment.comment_date, comment.comment_text, comment.user_id, comment.post_id, users.name, users.avatar FROM comment INNER JOIN users ON comment.user_id = users.id WHERE comment.post_id=$id";
    return requestDb($sql);
};

// print_r(getComments($id));

function publicationCount($id)
{
    $sql = "SELECT COUNT(*) FROM post WHERE user_id = $id";
    return  requestDb($sql);
};

$errors = [];

function checkComment()
{
    $sql = "SELECT id FROM post WHERE post.id = '{$_GET['id']}'";
    if (empty($_POST['comment'])) {
        return "Комментарий не должен быть пустым";
    } else if (strlen($_POST['comment']) < 5) {
        return "Комментарий должен быть длинее 4 символов";
    } else if (empty(requestDb($sql)[0]['id'])) {
        return "Такого поста не существует";
    };
};

function addComment($connect)
{
    $sql = "INSERT INTO `comment` (comment_date, comment_text, user_id, post_id) VALUES (NOW(), '{$_POST['comment']}', '{$_SESSION['id']}', '{$_GET['id']}')";
    return mysqli_query($connect, $sql);
};



$rules = [
    'comment' => function () {
        return checkComment();
    }
];

foreach ($_POST as $key => $value) {
    if (isset($rules[$key])) {
        $rule = $rules[$key];
        $errors[$key] = $rule();
    }
};


if ($_POST && empty($errors['comment'])) {
    addComment($connect);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = getPost($ind)[0]['user_id'];
        header("Location: /profile.php?id=$user");
    }
};



addLike();

$post_text = include_template('/post_text.php', ['post' => getPost($ind)]);
$post_link = include_template('/post_link.php', ['post' => getPost($ind)]);
$post_photo = include_template('/post_photo.php', ['post' => getPost($ind)]);
$post_video = include_template('/post_video.php', ['post' => getPost($ind)]);
$post_quote = include_template('/post_quote.php', ['post' => getPost($ind)]);

$page_content = include_template('/post_main.php', ['post' => getPost($ind), 'connect' => $connect, 'post_text' => $post_text, 'post_video' => $post_video, 'post_photo' => $post_photo, 'post_quote' => $post_quote, 'post_link' => $post_link, 'comments' => getComments($ind), 'publication_count' => publicationCount($ind), 'errors' => $errors, 'like' => isLike($_GET['id'])]);

$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное']);

print($layout_content);
