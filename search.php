<?php
session_start();
require_once('helpers.php');

$post_index = $_GET['id'] ?? '';

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");

function searchPosts () {
$sql = "SELECT * FROM post INNER JOIN users ON post.user_id = users.id WHERE MATCH(title, text) AGAINST('{$_GET['search']}')";
return requestDb($sql);
};

$page_content = include_template('/search_main.php', ['posts' => searchPosts()]);
$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное']);
print($layout_content);
