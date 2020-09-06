<?php


$is_auth = rand(0, 1);

$user_name = 'Кирилл';

require_once('helpers.php');

$ind = $_GET['id'] ?? '';

$link = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($link, "utf8");

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

function type_content($type)
{
    switch ($type) {
        case '1':
            return "INSERT INTO post (title, TEXT, DATE, user_id, content_id) VALUES ('{$_POST['post-title']}', '{$_POST['post-text']}', NOW(), '1', '{$_POST['post-type']}');";
            break;
        case '2':
            return "INSERT INTO post (title, TEXT, DATE, user_id, content_id, quote_author) VALUES ('{$_POST['post-title']}', '{$_POST['post-quote-text']}', NOW(), '1', '{$_POST['post-type']}', '{$_POST['post-quote-author']}');";
            break;
        case '3':
            return "INSERT INTO post (title, DATE, user_id, content_id) VALUES ('{$_POST['post-title']}', NOW(), '1', '{$_POST['post-type']}');";
            break;
        case '4':
            return "INSERT INTO post (title, DATE, user_id, content_id, video) VALUES ('{$_POST['post-title']}', NOW(), '1', '{$_POST['post-type']}', '{$_POST['post-video']}');";
            break;
        case '5':
            return "INSERT INTO post (title, DATE, user_id, content_id, link) VALUES ('{$_POST['post-title']}', NOW(), '1', '{$_POST['post-type']}', '{$_POST['post-link']}');";
            break;
    }
}

;


function write_hashtags($str, $link, $last_id)
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
}

;


function download_photo()
{
    if ($_FILES['post-photo']) {
        $file_name = $_FILES['post-photo']['name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url = '/uploads/' . $file_name;

        move_uploaded_file($_FILES['post-photo']['tmp_name'], $file_path . $file_name);

        print("<a href='$file_url'>$file_name</a>");
    }
}

;

function write($link)
{
    if (!empty($_POST)) {
        if (!$link) {
            $error = mysqli_connect_error();
            print($error);
        } else {
            //print_r($_FILES);
            //download_photo();
            $sql = type_content("{$_POST['post-type']}");
            $result = mysqli_query($link, $sql);
            $last_id = mysqli_insert_id($link);
            write_hashtags($_POST['post-tags'], $link, $last_id);
            if (!$result) {

                print(mysqli_error($link));
            };
        };
    }
}

;


//Проверяем поля на заполненность и соответствие

$errors = [];

function validateFilled($name)
{
    if (empty($_POST[$name])) {
        return "Это поле должно быть заполнено";
    }
}

;

function checkVideo($name)
{
    if (!filter_var($_POST[$name], FILTER_VALIDATE_URL)) {
        return check_youtube_url($_POST[$name]);
    }
};

function validateURL($name) {
    if (!filter_var($_POST[$name], FILTER_VALIDATE_URL)) {
        return "Введите корректную ссылку";
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
    }
];

foreach ($_POST as $key => $value) {
    if (isset($rules[$key])) {
        $rule = $rules[$key];
        $errors[$key] = $rule();
    }
}

$errors = array_filter($errors);



if ($_POST && empty($errors)) {
    write($link);
    $new_post_id = mysqli_insert_id($link);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        header("Location: /post.php?id=$new_post_id");
    }
}



print('ERRORS ');
print_r($errors);
print('<br>');
print_r(content($link));
print('<br>');
print('POST ');
print_r($_POST);
print('<br>');
print('FILES ');
print_r($_FILES);


function getPostVal($name)
{
    return $_POST[$name] ?? "";
}

;

$post_title = include_template('/add_post_title.php', ['getPostVal' => getPostVal, 'errors' => $errors]);
$post_tags = include_template('/add_post_tags.php', ['getPostVal' => getPostVal, 'errors' => $errors]);
$post_text = include_template('/add_post_text.php', ['getPostVal' => getPostVal, 'errors' => $errors]);
$post_quote = include_template('/add_post_quote.php', ['getPostVal' => getPostVal, 'errors' => $errors]);
$post_author = include_template('/add_post_author.php', ['getPostVal' => getPostVal, 'errors' => $errors]);


$page_content = include_template('/add_main.php', ['type_cont' => content($link), 'errors' => $errors, 'getPostVal' => getPostVal, 'post_title' => $post_title, 'post_tags' => $post_tags, 'post_text' => $post_text, 'post_quote' => $post_quote, 'post_author' => $post_author]);

$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'user_name' => 'Кирилл', 'is_auth' => $is_auth]);

print($layout_content);
