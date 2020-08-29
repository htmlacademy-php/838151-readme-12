<?php
$is_auth = rand(0, 1);

$user_name = 'Кирилл'; // укажите здесь ваше имя

function cut_text($text, $len = 300)
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
}

;

$link = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($link, "utf8");

$ind = $_GET['id'] ?? '';

function content($link)
{
    if (!$link) {
        $error = mysqli_connect_error();
        print($error);
    } else {
        $sql = 'SELECT id, title, class_name FROM content';
        $result = mysqli_query($link, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    };
}

;


function posts($link, $id)
{
    if (!$link) {
        $error = mysqli_connect_error();
        print($error);
    } else {
        if ($id) {
            $sql = "SELECT post.title, post.id as post_id, text, picture, video, link, content_id, avatar, class_name, name FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id WHERE content.id = $id ORDER BY post.count_view DESC ";
        } else {
            $sql = "SELECT post.title, post.id as post_id, text, picture, video, link, content_id, avatar, class_name, name FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id  ORDER BY post.count_view DESC ";
        }
        $result = mysqli_query($link, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    };
}

;


require_once('helpers.php');


$page_content = include_template('/main.php', ['posts' => posts($link, $ind), 'type_cont' => content($link), 'ind' => $ind]);

$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'user_name' => 'Кирилл', 'is_auth' => $is_auth]);

print($layout_content);

date_default_timezone_set('Europe/Moscow');

function check_time($some_date)
{
    $current_date = date_create("now");
    $publication_date = date_create($some_date);
    $diff = date_diff($current_date, $publication_date);

    switch ($diff) {
        case $diff->m > 0:
            print($diff->m . ' ' . get_noun_plural_form($diff->m, 'месяц', 'месяца', 'месяцев') . ' назад');
            break;
        case $diff->d >= 7 && $diff->d <= 35:
            $week = floor(($diff->d) / 7);
            print($week . ' ' . get_noun_plural_form($week, 'неделю', 'недели', 'недель') . ' назад');
            break;
        case $diff->d > 0:
            print($diff->d . ' ' . get_noun_plural_form($diff->m, 'день', 'дня', 'дней') . ' назад');
            break;
        case $diff->h > 0:
            print($diff->h . ' ' . get_noun_plural_form($diff->m, 'час', 'часа', 'часов') . ' назад');
            break;
        case $diff->i > 0:
            print($diff->i . ' ' . get_noun_plural_form($diff->m, 'минуту', 'минуты', 'минут') . ' назад');
            break;


    };

}

;









