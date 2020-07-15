<?php
$is_auth = rand(0, 1);

$user_name = 'Кирилл'; // укажите здесь ваше имя
/*$posts_array = [
    [
        'title' => 'Цитата',
        'type' => 'post-quote',
        'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'user' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg'
    ],
    [
        'title' => 'Игра престолов',
        'type' => 'post-text',
        'content' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
        'user' => 'Владик',
        'avatar' => 'userpic.jpg'
    ],
    [
        'title' => 'Наконец, обработал фотки!',
        'type' => 'post-photo',
        'content' => 'rock-medium.jpg',
        'user' => 'Виктор',
        'avatar' => 'userpic-mark.jpg'
    ],
    [
        'title' => 'Моя мечта',
        'type' => 'post-photo',
        'content' => 'coast-medium.jpg',
        'user' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg'
    ],
    [
        'title' => 'Лучшие курсы',
        'type' => 'post-link',
        'content' => 'www.htmlacademy.ru',
        'user' => 'Владик',
        'avatar' => 'userpic.jpg'
    ]
];*/

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

function content($link)
{
    if (!$link) {
        $error = mysqli_connect_error();
        print($error);
    } else {
        $sql = 'SELECT `*` FROM content';
        $result = mysqli_query($link, $sql);
        $type_content = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $type_content;
    };
}

;

$type_content = content($link);

function posts($link)
{
    if (!$link) {
        $error = mysqli_connect_error();
        print($error);
    } else {
        $sql = 'SELECT `*` FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id ORDER BY post.count_view DESC';
        $result = mysqli_query($link, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    };
}

;

$posts_array = posts($link);
print_r($posts_array);


require_once('helpers.php');

$page_content = include_template('/main.php', ['posts' => $posts_array, 'type_cont' => $type_content]);

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


([0] => array([id] => 5 [date] => 2015 - 12 - 05 12:05:14 [title] => Ссылка [text] => [author] => Владик [picture] => [video] => [link] => www . htmlacademy . ru [count_view] => 12 [likes] => 0 [user_id] => 2 [content_id] => 5 [hashtag_id] => [registration_date] => 2017 - 05 - 09 13:06:14 [email] => vladik@mail . ru [login] => Vladik [password] => 654321 [avatar] => userpic . jpg [class_name] => link )
[1] => array([id] => 3 [date] => 2015 - 12 - 05 12:05:14 [title] => Картинка [text] => [author] => Лариса [picture] => coast - medium . jpg [video] => [link] => [count_view] => 12 [likes] => 0 [user_id] => 1 [content_id] => 3 [hashtag_id] => [registration_date] => 2014 - 12 - 05 12:05:14 [email] => larisa@mail . ru [login] => Larisa [password] => 123456 [avatar] => userpic - larisa - small . jpg [class_name] => photo ) [2] => array([id] => 1 [date] => 2015 - 12 - 05 12:05:14 [title] => Текст [text] => Не могу дождаться начала финального сезона своего любимого сериала![author] => Владик [picture] => [video] => [link] => [count_view] => 8 [likes] => 0 [user_id] => 2 [content_id] => 1 [hashtag_id] => [registration_date] => 2017 - 05 - 09 13:06:14 [email] => vladik@mail . ru [login] => Vladik [password] => 654321 [avatar] => userpic . jpg [class_name] => text ) [3] => array([id] => 3 [date] => 2015 - 12 - 05 12:05:14 [title] => Картинка [text] => [author] => Виктор [picture] => rock - medium . jpg [video] => [link] => [count_view] => 6 [likes] => 0 [user_id] => 3 [content_id] => 3 [hashtag_id] => [registration_date] => 2017 - 05 - 09 13:06:14 [email] => viktor@mail . ru [login] => Viktor [password] => 654321 [avatar] => userpic - mark . jpg [class_name] => photo ) [4] => array([id] => 2 [date] => 2015 - 12 - 05 12:05:14 [title] => Цитата [text] => Мы в жизни любим только раз, а после ищем лишь похожих [author] => Лариса [picture] => [video] => [link] => [count_view] => 5 [likes] => 1 [user_id] => 1 [content_id] => 2 [hashtag_id] => [registration_date] => 2014 - 12 - 05 12:05:14 [email] => larisa@mail . ru [login] => Larisa [password] => 123456 [avatar] => userpic - larisa - small . jpg [class_name] => quote ) )




