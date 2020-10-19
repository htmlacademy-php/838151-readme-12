<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: /");
};

/**
 * cut post text
 * @param string $text
 * @param int $len
 * @return mixed
 */
function cutText(string $text, int $len = 300)
{
    if (strlen($text) < $len) {
        echo '<p>' . $text . '</p>';
    } else {
        $words = explode(" ", $text);
        $new_text = [];
        $count = 0;
        for ($i = 0; $count < $len; $i++) {
            $count += (strlen($words[$i]));
            $new_text[] = $words[$i];
        };
        echo '<p>' . implode(" ", $new_text) . " ..." . '</p>
              <a class="post-text__more-link" href="#">Читать далее</a>';
    };
};

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");

$ind = $_GET['id'] ?? '';

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

require_once('helpers.php');

$page_content = include_template('/main.php', ['posts' => getPosts($ind), 'type_cont' => getContent($connect), 'ind' => $ind, 'post_index' => $ind]);
$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'user_name' => 'Кирилл', 'is_auth' => $is_auth]);
print($layout_content);
