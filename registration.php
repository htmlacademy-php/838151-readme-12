<?php
$is_auth = 0;

$user_name = 'Кирилл'; // укажите здесь ваше имя


$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");

$ind = $_GET['id'] ?? '';

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
}

;

/**
 * validate email
 * @param string $email
 * @return string|null
 */

function validateEmail(string $email)
{
    $connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
    if (empty($_POST[$email])) {
        return validateFilled($email);
    } else if (!filter_var($_POST[$email], FILTER_VALIDATE_EMAIL)) {
        return 'Некорректный адрес электронной почты';
    }
    if (!empty(mysqli_fetch_all(mysqli_query($connect, "SELECT email FROM users WHERE email = '{$_POST['email']}'"))[0])) {
        return 'Email занят';
    }
}

;

/**
 * validate password
 * @return string
 */

function validatePassword()
{
    if (!($_POST['password'] == $_POST['password-repeat'])) {
        return 'Введенные пароли не совпадают';
    }
}

;

/**
 * validate avatar
 * @param $name
 * @return string
 */

function checkFilePhoto($name)
{
    if (!($_FILES[$name]['type'] == 'image/png') && !($_FILES[$name]['type'] == 'image/jpeg') && !($_FILES[$name]['type'] == 'image/gif')) {
        return 'Некорректный формат фото';
    }
}

;

/**
 * download avatar
 * @return mixed
 */
function downloadPhoto()
{
    $file_name = $_FILES['userpic-file']['name'];
    $file_path = __DIR__ . '/uploads/';

    move_uploaded_file($_FILES['userpic-file']['tmp_name'], $file_path . $file_name);
    return $file_name;
}

;

/**
 * hash password before write in db
 * @return false|string|null
 */

function hashPassword(){
    return password_hash($_POST['password'], PASSWORD_DEFAULT);
};


$errors = [];

$rules = [
    'email' => function () {
        return validateEmail('email');
    },
    'login' => function () {
        return validateFilled('login');
    },
    'password' => function () {
        return validateFilled('password');
    },
    'password-repeat' => function () {
        if (empty($_POST['password-repeat'])) {
            return validateFilled('password-repeat');
        } else if (!empty($_POST['password']) && !empty($_POST['password-repeat'])) {
            return validatePassword();
        }
    },
    'userpic-file' => function () {
    if(!empty($_FILES['userpic-file']['name'])){
        return checkFilePhoto('userpic-file');
    }
    },
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

/**
 * write new user in db
 * @param object $link
 * @param $funcPhoto
 * @param $funcPassword
 */

function addNewUser(object $link, $funcPhoto, $funcPassword)
{
    if (!empty($_POST) && empty($errors)) {
        if (!$link) {
            $error = mysqli_connect_error();
            print($error);
        } else {
            if(empty($_FILES['userpic-file']['name'])){
                $sql = "INSERT INTO users (registration_date, name, email, login, password) VALUES (NOW(), '{$_POST['login']}', '{$_POST['email']}', '{$_POST['login']}', '$funcPassword');";
                mysqli_query($link, $sql);

            } else {
                $sql = "INSERT INTO users (registration_date, name, email, login, password, avatar) VALUES (NOW(), '{$_POST['login']}', '{$_POST['email']}', '{$_POST['login']}', '$funcPassword', '$funcPhoto');";
                mysqli_query($link, $sql);

            }
        };
    }
}

;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)) {
    header("Location: /login.php");
}


function getPostVal(string $name): string
{
    return $_POST[$name] ?? "";
}

;

addNewUser($connect, downloadPhoto(), hashPassword());

require_once('helpers.php');


$page_content = include_template('/registration_main.php', ['errors' => $errors]);

$layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'user_name' => 'Кирилл', 'is_auth' => $is_auth]);

print($layout_content);











