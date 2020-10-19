<?php
session_start();
require_once('helpers.php');

$post_index = $_GET['id'] ?? '';

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");

/**
 * return type content from db
 * @param object $link
 * @return array
 */
function getContent(object $link): array
{
    $sql = 'SELECT id, title, class_name FROM content';
    requestDb($sql);
};

/**
 * download photo and return download file name
 * @return string
 */
function downloadPhoto()
{
    if (!empty($_FILES['file-photo']['name']) || !empty($_POST['post-photo-link'])) {
        if (!empty($_FILES['file-photo']['name'])) {
            $file_name = $_FILES['file-photo']['name'];
            $file_path = __DIR__ . '/uploads/';
            move_uploaded_file($_FILES['file-photo']['tmp_name'], $file_path . $file_name);
            return $file_name;
        } else {
            $url = $_POST['post-photo-link'];
            $file_name = basename($url);
            $file = file_get_contents($url);
            $ext = pathinfo($url, PATHINFO_EXTENSION);
            file_put_contents(__DIR__ . '/uploads/' . $file_name . '.' . $ext, $file);
            return $file_name;
        }
    }
};

/**
 * return sql request for content type
 * @param int $type
 * @return string
 */
function returnSqlRequest(int $type, $func): string
{
    switch ($type) {
        case '1':
            return "INSERT INTO post (title, TEXT, DATE, user_id, content_id) VALUES ('{$_POST['post-title']}', '{$_POST['post-text']}', NOW(), '1', '{$_POST['post-type']}');";
            break;
        case '2':
            return "INSERT INTO post (title, TEXT, DATE, user_id, content_id, quote_author) VALUES ('{$_POST['post-title']}', '{$_POST['post-quote-text']}', NOW(), '1', '{$_POST['post-type']}', '{$_POST['post-quote-author']}');";
            break;
        case '3':
            return "INSERT INTO post (title, DATE, user_id, content_id, picture) VALUES ('{$_POST['post-title']}', NOW(), '1', '{$_POST['post-type']}', '$func');";
            break;
        case '4':
            return "INSERT INTO post (title, DATE, user_id, content_id, video) VALUES ('{$_POST['post-title']}', NOW(), '1', '{$_POST['post-type']}', '{$_POST['post-video']}');";
            break;
        case '5':
            return "INSERT INTO post (title, DATE, user_id, content_id, link) VALUES ('{$_POST['post-title']}', NOW(), '1', '{$_POST['post-type']}', '{$_POST['post-link']}');";
            break;
    }
};

/**
 * write hashtag in db
 * @param object $link
 * @param int $last_id
 * @return mixed
 */
function writeHashtags($str, object $link, int $last_id)
{
    if (!empty($_POST['post-tags'])) {
        $tags_array = array_diff(explode(' ', $str), array(''));
        foreach ($tags_array as $val) {
            $exist_sql = "SELECT * FROM hashtag WHERE title = '$val'";
            $res = mysqli_fetch_all(mysqli_query($link, $exist_sql), MYSQLI_ASSOC);
            if ($res[0]['id']) {
                $hashtag_id = $res[0]['id'];
                $sql = "INSERT INTO post_hashtag (post_id, hashtag_id) VALUES ('$last_id', '$hashtag_id')";
                mysqli_query($link, $sql);
            } else {
                $sql = "INSERT INTO hashtag (title) VALUES ('$val')";
                mysqli_query($link, $sql);
                $new_hashtag_id = mysqli_insert_id($link);
                $sql = "INSERT INTO post_hashtag (post_id, hashtag_id) VALUES ('$last_id', '$new_hashtag_id')";
                mysqli_query($link, $sql);
            }
        }
    }
};

/**
 * @param object $link
 * @return mixed
 */
function write(object $link)
{
    if (!empty($_POST)) {
        if (!$link) {
            $error = mysqli_connect_error();
            print($error);
        } else {
            $sql = returnSqlRequest("{$_POST['post-type']}", downloadPhoto());
            $result = mysqli_query($link, $sql);
            $last_id = mysqli_insert_id($link);
            writeHashtags($_POST['post-tags'], $link, $last_id);
            if (!$result) {
                print(mysqli_error($link));
            };
        };
    }
};

$errors = [];

/**
 * check input for fullness
 * @param string $name
 * @return string|null
 */
function validateFilled(string $name)
{
    if (empty($_POST[$name])) {
        return 'Это поле должно быть заполнено';
    };
};

/**
 * check video from youtube
 * @param string $name
 * @return string
 */
function checkVideo(string $name): string
{
    if (!filter_var($_POST[$name], FILTER_VALIDATE_URL)) {
        return check_youtube_url($_POST[$name]);
    }
};

/**
 * check link
 * @param string $name
 * @return string
 */
function validateURL(string $name)
{
    if (!filter_var($_POST[$name], FILTER_VALIDATE_URL)) {
        return "Введите корректную ссылку";
    }
};

/**
 * check photo link
 * @param string $name
 * @return string
 */
function checkPhotoLink(string $name): string
{
    if (!empty($_POST[$name])) {
        if (validateURL($name)) {
            return validateURL($name);
        } else if (file_get_contents($_POST['post-photo-link']) == 'false' || file_get_contents($_POST['post-photo-link']) == "") {
            return 'Некорректная ссылка на изображение';
        };
    }
};

/**
 * check download file photo
 * @param string $name
 */
function checkFilePhoto(string $name)
{
    if (!($_FILES[$name]['type'] == 'image/png') && !($_FILES[$name]['type'] == 'image/jpeg') && !($_FILES[$name]['type'] == 'image/gif')) {
        return 'Некорректный формат фото';
    }
};

$rules = [
    'post-title' => function () {
        return validateFilled('post-title');
    },
    'post-text' => function () {
        return validateFilled('post-text');
    },
    'post-quote-text' => function () {
        return validateFilled('post-quote-text');
    },
    'post-quote-author' => function () {
        return validateFilled('post-quote-author');
    },
    'post-link' => function () {
        if (empty($_POST['post-link'])) {
            return validateFilled('post-link');
        } else {
            return validateURL('post-link');
        }
    },
    'post-video' => function () {
        if (empty($_POST['post-video'])) {
            return validateFilled('post-video');
        } else {
            return checkVideo('post-video');
        }
    },
    'post-photo-link' => function () {
        if (empty($_FILES['file-photo']['name'])) {
            return checkPhotoLink('post-photo-link');
        }
    },
    'file-photo' => function () {
        if (!empty($_FILES['file-photo']['name'])) {
            return checkFilePhoto('file-photo');
        }
    }
];

foreach ($_POST as $key => $value) {
    if (isset($rules[$key])) {
        $rule = $rules[$key];
        $errors[$key] = $rule();
    }
};

foreach ($_FILES as $key => $value) {
    if (isset($rules[$key])) {
        $rule = $rules[$key];
        $errors[$key] = $rule();
    }
};

$errors = array_filter($errors);

if ($_POST && empty($errors)) {
    write($connect);
    $new_post_id = mysqli_insert_id($connect);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        header("Location: /post.php?id=$new_post_id");
    }
}

/**
 * @param string $name
 * @return string
 */
function getPostVal(string $name): string
{
    return $_POST[$name] ?? "";
};

$post_title = include_template('/add_post_title.php', ['errors' => $errors]);
$post_tags = include_template('/add_post_tags.php', ['errors' => $errors]);
$post_text = include_template('/add_post_text.php', ['errors' => $errors]);
$post_quote = include_template('/add_post_quote.php', ['errors' => $errors]);
$post_author = include_template('/add_post_author.php', ['errors' => $errors]);

$page_content = include_template('/add_main.php', ['type_cont' => getContent($connect), 'errors' => $errors, 'post_title' => $post_title, 'post_tags' => $post_tags, 'post_text' => $post_text, 'post_quote' => $post_quote, 'post_author' => $post_author]);
$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'user_name' => 'Кирилл', 'is_auth' => $is_auth]);
print($layout_content);
