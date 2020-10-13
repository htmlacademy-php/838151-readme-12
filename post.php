<?php

session_start();

require_once('helpers.php');

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
    $sql = "SELECT post.title, text, likes, name, picture, video, link, content_id, avatar, class_name, count_view FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id WHERE post.id = $id ORDER BY post.count_view DESC ";
    return requestDb($sql);
}

;

$post_text = include_template('/post_text.php', ['post' => getPost($ind)]);
$post_link = include_template('/post_link.php', ['post' => getPost($ind)]);
$post_photo = include_template('/post_photo.php', ['post' => getPost($ind)]);
$post_video = include_template('/post_video.php', ['post' => getPost($ind)]);
$post_quote = include_template('/post_quote.php', ['post' => getPost($ind)]);


$page_content = include_template('/post_main.php', ['post' => getPost($ind), 'post_text' => $post_text, 'post_video' => $post_video, 'post_photo' => $post_photo, 'post_quote' => $post_quote, 'post_link' => $post_link]);

$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное']);

print($layout_content);
