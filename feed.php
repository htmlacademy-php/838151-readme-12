<?php
session_start();

require_once('helpers.php');

$ind = $_GET['id'] ?? '';

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");


if (!isset($_SESSION['id'])) {
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
}

;

/**
 * @return string
 */
function getSubscribedUser()
{
    $sql = "SELECT subscribed_user1 FROM subscription WHERE subscribed_user = '{$_SESSION['id']}'";
    $red = requestDb($sql);
    $text = " ";
    foreach ($red as $key => $value) {
        if ($key + 1 != count($red)) {
            $text = $text . 'user_id = ' . $red[$key]['subscribed_user1'] . ' OR ';
        } else {
            $text = $text . 'user_id = ' . $red[$key]['subscribed_user1'] . ' ';
        }

    }
    return $text;
}

;

/**
 * @param $func
 * @param $id
 * @return array
 */

function getPost($func, $id): array
{
    $sql = "";
    if ($id) {
        $sql = "SELECT post.title, DATE, user_id, text, likes, name, picture, video, link, content_id, avatar, class_name, count_view FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = $id WHERE $func  ORDER BY post.date DESC";
    } else {
        $sql = "SELECT post.title, DATE, user_id, text, likes, name, picture, video, link, content_id, avatar, class_name, count_view FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id WHERE $func  ORDER BY post.date DESC";
    };
    return requestDb($sql);
}

;

date_default_timezone_set('Europe/Moscow');


$page_content = include_template('/feed_main.php', ['posts' => getPost(getSubscribedUser(), $ind), 'post_index' => $ind, 'type_cont' => getContent($connect)]);

$layout_content = include_template('/layout.php', ['content' => $page_content]);

print($layout_content);
