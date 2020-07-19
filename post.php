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
        $error = mysqli_connect_error();
        print($error);
    } else {
        if ($id) {
            $sql = "SELECT post.title, text, author, picture, video, link, content_id, avatar, class_name FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id WHERE post.id = $id ORDER BY post.count_view DESC ";
            $result = mysqli_query($link, $sql);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            print('Страница не найдена! 404');
        }
    };
}

;



$page_content = include_template('/post_main.php', ['post' => post($link, $ind)]);

$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'user_name' => 'Кирилл', 'is_auth' => $is_auth]);

print($layout_content);
