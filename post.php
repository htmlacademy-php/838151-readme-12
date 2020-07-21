<?php

$is_auth = rand(0, 1);

$user_name = 'Кирилл';

require_once('helpers.php');

$ind = $_GET['id'] ?? '';

$link = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($link, "utf8");

function post($link, $id)
{
    if (!$link) {
        return [];
    } else {
        if ($id) {
            $sql = "SELECT post.title, text, likes, author, picture, video, link, content_id, avatar, class_name, count_view FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id WHERE post.id = $id ORDER BY post.count_view DESC ";
            $result = mysqli_query($link, $sql);
            if (!$result) {
                return [];
            } else {
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
        }
    };
}

;

$post_text = include_template('/post_text.php', ['post' => post($link, $ind)]);
$post_link = include_template('/post_link.php', ['post' => post($link, $ind)]);
$post_photo = include_template('/post_photo.php', ['post' => post($link, $ind)]);
$post_video = include_template('/post_video.php', ['post' => post($link, $ind)]);
$post_quote = include_template('/post_quote.php', ['post' => post($link, $ind)]);


$page_content = include_template('/post_main.php',  ['post' => post($link, $ind), 'post_text' => $post_text, 'post_video' => $post_video, 'post_photo' => $post_photo, 'post_quote' => $post_quote, 'post_link' => $post_link]);

$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'user_name' => 'Кирилл', 'is_auth' => $is_auth]);

print($layout_content);
