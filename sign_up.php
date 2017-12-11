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

    $required = [
        'email',
        'name',
        'password',
        'contacts'
    ];
    $errors = [];

    foreach ($required as $name) {
        if (!array_key_exists($name, $form) || empty($form[$name])) {
            $errors[$name] = 'Это поле надо заполнить';
        }
    }

    if (!isset($errors['email']) && !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите валидный E-mail';
    }

    if (!empty($_FILES['avatar']['name'])) {
        $tmpName = $_FILES['avatar']['tmp_name'];
        $path = 'img/avatars/' . $_FILES['avatar']['name'];
        $fileType = mime_content_type($tmpName);
        if ($fileType !== "image/jpeg" && $fileType !== "image/png") {
            $errors['avatar'] = 'Загрузите картинку в формате jpg или png';
        } else {
            move_uploaded_file($tmpName, $path);
            $form['avatar'] = $path;
        }
    }

    if (!count($errors)) {
        mysqli_report(MYSQLI_REPORT_ALL);

        $email = mysqli_real_escape_string($con, $form['email']);
        try {
            $emailExists = mysqli_num_rows(mysqli_query($con, "SELECT `id` FROM `users` WHERE `email` = '$email'"));
        } catch (Exception $e) {
            renderErrorTemplate($e->getMessage(), $currentUser);
        }

        if ($emailExists) {
            $errors['email'] = 'Такой E-mail уже существует';
        } else {
            $passwordHash = password_hash($form['password'], PASSWORD_DEFAULT);
            try {
                $sql = "INSERT INTO users (`registration_date`, `email`, `name`, `password`, `avatar`, `contacts`) VALUES (NOW(), ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, 'sssss', $email, $form['name'], $passwordHash, $form['avatar'], $form['contacts']);
                mysqli_stmt_execute($stmt);
            } catch (Exception $e) {
                renderErrorTemplate($e->getMessage(), $currentUser);
            }

            redirectTo('/login.php');
        }
    }

    if (count($errors)) {
        $page_content = renderTemplate('templates/sign_up.php', [
            'form' => $form,
            'errors' => $errors,
            'categories' => $categories,
        ]);
    }
}
else {
    $page_content = renderTemplate('templates/sign_up.php', [
        'categories' => $categories,
    ]);
}

$layout_content = renderTemplate('templates/layout.php', [
    'categories' => $categories,
    'content' => $page_content,
    'title' => 'Регистрация аккаунта',
    'mainClass' => '',
    'currentUser' => $currentUser
]);

echo $layout_content;