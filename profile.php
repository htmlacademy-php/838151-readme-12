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
function getUser()
{
    $sql = "SELECT users.id, name, email, registration_date, login, avatar, (SELECT COUNT(*) FROM post WHERE post.user_id = '{$_GET['id']}') AS count_post, (SELECT COUNT(subscribed_user) FROM subscription WHERE subscription.subscribed_user1 = '{$_GET['id']}') AS count_subs  FROM users WHERE users.id='{$_GET['id']}'";
    return requestDb($sql);
};

function getUserPosts()
{
    $sql = "SELECT *
    FROM post
    WHERE post.user_id = '{$_GET['id']}'";
    return requestDb($sql);
};

function subscription()
{
    $sql = "SELECT COUNT(*) AS count FROM subscription WHERE subscription.subscribed_user = '{$_SESSION['id']}' AND subscription.subscribed_user1 = {$_GET['id']}";
    return requestDb($sql);
};

//print_r(subscription());

//print_r(getUser());

print_r(getUserPosts());

$page_content = include_template('/profile_main.php', ['user' => getUser(), 'posts' => getUserPosts(), 'subscription' => subscription()]);
$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: профиль пользователя']);
print($layout_content);
