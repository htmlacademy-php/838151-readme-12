<?php
session_start();

require_once('helpers.php');

$ind = $_GET['id'] ?? '';

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");

if ($_SESSION['id'] == "") {
    header("Location: /");
};

/**
 * return content type from db
 * @param object $link
 * @return array
 */
function getContent(object $link)
{
    $sql = 'SELECT id, title, class_name FROM content';
    return requestDb($sql);
};

/**
 * @param $id
 * @return array
 */
function getPost($id): array
{
    $sql = "";
    if ($id) {
        $sql = "SELECT post.id as post_id, post.title, DATE, user_id, text, (SELECT COUNT(*) FROM comment WHERE comment.post_id = post.id) AS comment, likes, name, picture, video, link, content_id, avatar, class_name, count_view FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = $id WHERE user_id IN (SELECT subscribed_user1 FROM subscription WHERE subscribed_user = '{$_SESSION['id']}')  ORDER BY post.date DESC";
    } else {
        $sql = "SELECT post.id as post_id, post.title, DATE, user_id, text, (SELECT COUNT(*) FROM comment WHERE comment.post_id = post.id) AS comment, likes, name, picture, video, link, content_id, avatar, class_name, count_view FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id WHERE user_id IN (SELECT subscribed_user1 FROM subscription WHERE subscribed_user = '{$_SESSION['id']}')  ORDER BY post.date DESC";
    };
    return requestDb($sql);
}; 

date_default_timezone_set('Europe/Moscow');

$page_content = include_template('/feed_main.php', ['posts' => getPost($ind), 'post_index' => $ind, 'type_cont' => getContent($connect)]);
$layout_content = include_template('/layout.php', ['content' => $page_content]);
print($layout_content);
