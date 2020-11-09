<?php
session_start();
require_once('helpers.php');

$post_index = $_GET['id'] ?? '';

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");

if ($_SESSION['id'] == "") {
    header("Location: /");
};

/**
 * search posts from words and hashtag
 * @return mixed
 */
function searchPosts () {
    $search_string = '';
    if ((substr($_GET['search'], 0, 1)) == '#') {
        $search_string = substr($_GET['search'], 1);
        $sql = "SELECT * FROM post INNER JOIN users ON post.user_id = users.id WHERE post.id IN (SELECT post_id FROM post_hashtag WHERE hashtag_id IN (SELECT hashtag.id FROM hashtag WHERE hashtag.title = '$search_string')) ORDER BY post.date DESC";
    } else {
        $search_string = $_GET['search'];
        $sql = "SELECT * FROM post INNER JOIN users ON post.user_id = users.id WHERE MATCH(title, text) AGAINST('{$_GET['search']}')";
    };
    return requestDb($sql);
};

$page_content = include_template('/search_main.php', ['posts' => searchPosts()]);
$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное']);
print($layout_content);
