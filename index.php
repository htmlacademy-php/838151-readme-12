<?php

session_start();

$connect = mysqli_connect('127.0.0.1', 'root', 'root', 'readme');
mysqli_set_charset($connect, "utf8");

require_once('helpers.php');

require_once('helpers.php');

/**
 * return input text
 * @param string $name
 * @return string
 */
function getPostVal(string $name): string
{
    return $_POST[$name] ?? "";
};

/**
 * validate empty inputs
 * @param string $name
 * @return string
 */
function validateFilled(string $name)
{
    if (empty($_POST[$name])) {
        return 'Это поле должно быть заполнено';
    };
};

/**
 * validate login
 * @param [type] $name
 * @return string
 */
function validateLogin($name): string
{
    $sql = "SELECT login FROM users WHERE login = '{$_POST['login']}' ";
    if (empty($_POST[$name])) {
        return validateFilled($name);
    } else if (!requestDb($sql)) {
        return 'Неверный логин';
    }
};

/**
 * validate password
 *
 * @param [type] $name
 * @return string
 */
function validatePassword($name)
{
    $sql = "SELECT password FROM users WHERE login = '{$_POST['login']}' ";
    if (empty($_POST[$name])) {
        return validateFilled($name);
    } else {
        $passwordDb = requestDb($sql)[0]['password'];
        if (!password_verify($_POST['password'], $passwordDb)) {
            return 'неверный пароль';
        }
    };
};

$errors = [];

$rules = [
    'login' => function () {
        return validateLogin('login');
    },
    'password' => function () {
        return validatePassword('password');
    }
];

foreach ($_POST as $key => $value) {
    if (isset($rules[$key])) {
        $rule = $rules[$key];
        $errors[$key] = $rule();
    }
};

$errors = array_filter($errors);

if ($_POST && empty($errors)) {
    $sql = "SELECT id FROM users WHERE login = '{$_POST['login']}' ";
    session_start();
    $_SESSION['id'] = requestDb($sql)[0]['id'];
    $_SESSION['user'] = $_POST['login'];
};

if (isset($_SESSION['id'])) {
    header("Location: /feed.php");
}

$layout_content = include_template('/layout_index.php', ['errors' => $errors]);

print($layout_content);
