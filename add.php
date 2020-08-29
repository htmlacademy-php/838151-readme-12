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

function type_content($type) {
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
};

function download_photo(){
    if (isset($_FILES['post-photo'])) {
        $file_name = $_FILES['post-photo']['name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url = '/uploads/' . $file_name;

        move_uploaded_file($_FILES['post-photo']['tmp_name'], $file_path . $file_name);

        print("<a href='$file_url'>$file_name</a>");
    }
};

function write($link)
{
    if(!empty($_POST)){
        if (!$link) {
            $error = mysqli_connect_error();
            print($error);
        } else {

            $sql = type_content("{$_POST['post-type']}");
            $result = mysqli_query($link, $sql);
            if(!$result){
                print(mysqli_error($link));
            };
        };
    }
}

;




write($link);



print_r(content($link));
print('POST ');
print_r($_POST);
print_r($_FILES);


$post_title = include_template('/add_post_title.php');
$post_tags = include_template('/add_post_tags.php');
$post_text = include_template('/add_post_text.php');
$post_quote = include_template('/add_post_quote.php');
$post_author = include_template('/add_post_author.php');


$page_content = include_template('/add_main.php', ['type_cont' => content($link), 'post_title' => $post_title, 'post_tags' => $post_tags, 'post_text' => $post_text, 'post_quote' => $post_quote, 'post_author' => $post_author]);

$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'user_name' => 'Кирилл', 'is_auth' => $is_auth]);

print($layout_content);