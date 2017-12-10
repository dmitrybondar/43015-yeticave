<?php
include "authorization.php";
include "functions.php";
include "mysql_helper.php";
include "init.php";

if($currentUser) {
    redirectTo();
}

try {
    $categories = fetchAll($con, 'SELECT * FROM `categories`');
} catch (Exception $e) {
    renderErrorTemplate($e->getMessage(), $currentUser);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required = ['email', 'password'];
    $errors = [];

    foreach ($required as $name) {
        if (!array_key_exists($name, $form) || empty($form[$name])) {
            $errors[$name] = 'Это поле надо заполнить';
        }
    }

    if (!count($errors)) {
        $email = mysqli_real_escape_string($con, $form['email']);
        $password = mysqli_real_escape_string($con, $form['password']);

        try {
            $user = fetchOne($con, "SELECT * FROM users WHERE email = '$email'");
        } catch (Exception $e) {
            renderErrorTemplate($e->getMessage(), $currentUser);
        }

        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            redirectTo();
        } else {
            $errors['all'] = 'Вы ввели неверный E-mail/пароль';
        }
    }

    if (count($errors)) {
        $page_content = renderTemplate('templates/login.php', [
            'form' => $form,
            'errors' => $errors,
            'categories' => $categories,
        ]);
    }
}
else {
    $page_content = renderTemplate('templates/login.php', [
        'categories' => $categories,
    ]);
}

$layout_content = renderTemplate('templates/layout.php', [
    'categories' => $categories,
    'content' => $page_content,
    'title' => 'Вход на сайт',
    'mainClass' => '',
    'currentUser' => $currentUser
]);

echo $layout_content;