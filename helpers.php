<?php

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } else {
                if (is_string($value)) {
                    $type = 's';
                } else {
                    if (is_double($value)) {
                        $type = 'd';
                    }
                }
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Функция проверяет доступно ли видео по ссылке на youtube
 * @param string $url ссылка на видео
 *
 * @return string Ошибку если валидация не прошла
 */
function check_youtube_url($url)
{
    $id = extract_youtube_id($url);
    $headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $id);

    if (!is_array($headers)) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    $err_flag = strpos($headers[0], '200') ? 200 : 404;

    if ($err_flag !== 200) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    return true;
}

/**
 * Возвращает код iframe для вставки youtube видео на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_video($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);
    if ($id) {
        $src = "https://www.youtube.com/embed/" . $id;
        $res = '<iframe width="760" height="400" src="' . $src . '" frameborder="0"></iframe>';
    }
    return $res;
}

/**
 * Возвращает img-тег с обложкой видео для вставки на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_cover($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);
    if ($id) {
        $src = sprintf("https://img.youtube.com/vi/%s/mqdefault.jpg", $id);
        $res = '<img alt="youtube cover" width="320" height="120" src="' . $src . '" />';
    }
    return $res;
}

/**
 * Извлекает из ссылки на youtube видео его уникальный ID
 * @param string $youtube_url Ссылка на youtube видео
 * @return array
 */
function extract_youtube_id($youtube_url)
{
    $id = false;
    $parts = parse_url($youtube_url);
    if ($parts) {
        if ($parts['path'] == '/watch') {
            parse_str($parts['query'], $vars);
            $id = $vars['v'] ?? null;
        } else {
            if ($parts['host'] == 'youtu.be') {
                $id = substr($parts['path'], 1);
            }
        }
    }
    return $id;
}

/**
 * @param $index
 * @return false|string
 */
function generate_random_date($index)
{
    $deltas = [['minutes' => 59], ['hours' => 23], ['days' => 6], ['weeks' => 4], ['months' => 11]];
    $dcnt = count($deltas);
    if ($index < 0) {
        $index = 0;
    }
    if ($index >= $dcnt) {
        $index = $dcnt - 1;
    }
    $delta = $deltas[$index];
    $timeval = rand(1, current($delta));
    $timename = key($delta);
    $ts = strtotime("$timeval $timename ago");
    $dt = date('Y-m-d H:i:s', $ts);
    return $dt;
};

/**
 * request from db
 * @param string $sql
 * @return mixed
 */
function requestDb($sql)
{
    $connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
    if (!$connect) {
        return [];
    } else {
        $result = mysqli_query($connect, $sql);
        if (!$result) {
            return [];
        } else {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
};

/**
 * return string date
 * @param date $some_date
 * @return mixed
 */
function checkTime($some_date)
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
};

/**
 * return posts from db
 * @param string $id
 * @return mixed
 */
function getPosts(string $id)
{
    $sql = "";
    if ($id) {
        $sql = "SELECT date, post.title, post.id as post_id, likes, (SELECT COUNT(*) FROM comment WHERE comment.post_id = post.id) AS comment, text, picture, video, link, content_id, avatar, class_name, users.id as user_id, name FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id WHERE content.id = $id ORDER BY post.count_view DESC ";
    } else {
        $sql = "SELECT date,  post.title, post.id as post_id, likes, (SELECT COUNT(*) FROM comment WHERE comment.post_id = post.id) AS comment, text, picture, video, link, content_id, avatar, class_name, users.id as user_id, name FROM post INNER JOIN users ON post.user_id = users.id INNER JOIN content ON post.content_id = content.id  ORDER BY post.count_view DESC ";
    };
    return requestDb($sql);
};

/**
 * checks for likes
 *
 * @param [type] $connect
 * @return boolean
 */
function isLike($id)
{
    $connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
    $sql = "SELECT * FROM `like` WHERE like.user = '{$_SESSION['id']}' AND like.post = $id";
    $result = mysqli_query($connect, $sql);
    return mysqli_num_rows($result);
};

function addLike()
{
    $connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
    $is_like = isLike($_GET['id']);
    $is_post = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `post` WHERE post.id = '{$_GET['id']}'"));
    if ($is_like == 0 && $_GET['like'] == 1 && $is_post != 0) {
        $res1 = mysqli_query($connect, "INSERT `like` (user, post) VALUES ('{$_SESSION['id']}', '{$_GET['id']}')");
        $res2 = mysqli_query($connect, "UPDATE `post` SET post.likes = post.likes + 1 WHERE post.id = '{$_GET['id']}'");
        if ($res1 && $res2) {
            mysqli_query($connect, "COMMIT");
            $referer = $_SERVER['HTTP_REFERER'];
            header("Location: $referer");
        } else {
            mysqli_query($connect, "ROLLBACK");
            $referer = $_SERVER['HTTP_REFERER'];
            header("Location: $referer");
        };
    } else if (isset($_GET['like'])) {
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
    };
};