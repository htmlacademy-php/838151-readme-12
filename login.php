<?php
$is_auth = 0;

$user_name = 'Кирилл'; // укажите здесь ваше имя

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");

$ind = $_GET['id'] ?? '';
print_r($ind);

require_once('helpers.php');

$page_content = include_template('/login_main.php');

$layout_content = include_template('/layout.php', ['content' => $page_content]);

print($layout_content);
