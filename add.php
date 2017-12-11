<?php
include "authorization.php";
include "functions.php";
include "mysql_helper.php";
include "init.php";

if (!$currentUser) {
    redirectTo('/login.php');
}

try {
    $categories = fetchAll($con, 'SELECT * FROM `categories`');
} catch (Exception $e) {
    renderErrorTemplate($e->getMessage(), $currentUser);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    $required = [
        'title',
        'description',
        'category',
        'price',
        'bet_step',
        'end_date',
    ];
    $is_numeric = [
        'price',
        'bet_step'
    ];

    $errors = [];

    foreach ($required as $name) {
        if (!array_key_exists($name, $lot) || empty($lot[$name])) {
            $errors[$name] = 'Это поле надо заполнить';
        }
    }

    foreach ($is_numeric as $name) {
        if (array_key_exists($name, $lot) && $lot[$name] && (!is_numeric($lot[$name]) || intval($lot[$name]) <= 0)) {
            $errors[$name] = 'Введите число больше нуля';
        }
    }

    if (!isset($errors['bet_step']) && !is_int($lot['bet_step']+0)) { //+0 позволяет конвертировать строку в число
        $errors['bet_step'] = 'Введите целое число';
    }

    if(strtotime($lot['end_date']) < strtotime('tomorrow')) {
        $errors['end_date'] = 'Введите дату больше текущей даты';
    }

    if (!empty($_FILES['img']['name'])) {
        $tmpName = $_FILES['img']['tmp_name'];
        $path = 'img/uploads/' . $_FILES['img']['name'];
        $fileType = mime_content_type($tmpName);
        if ($fileType !== "image/jpeg" && $fileType !== "image/png") {
            $errors['img'] = 'Загрузите картинку в формате jpg или png';
        } else {
            move_uploaded_file($tmpName, $path);
            $lot['img'] = $path;
        }
    } else {
        $errors['img'] = 'Вы не загрузили файл';
    }

    if (count($errors)) {
        $page_content = renderTemplate('templates/add_lot.php', [
            'errors' => $errors,
            'lot' => $lot,
            'categories' => $categories,
        ]);
    } else {
        mysqli_report(MYSQLI_REPORT_ALL);
        try {
            $sql = "INSERT INTO lots (`start_date`, `category_id`, `user_id`, `title`, `description`, `end_date`, `price`, `bet_step`, `img`) VALUES (NOW(), ?, '$currentUser[id]', ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'isssiis', $lot['category'], $lot['title'], $lot['description'], $lot['end_date'], $lot['price'], $lot['bet_step'], $lot['img']);
            mysqli_stmt_execute($stmt);
        } catch (Exception $e) {
            renderErrorTemplate($e->getMessage(), $currentUser);
        }

        $lot_id = mysqli_insert_id($con);
        redirectTo("/lot.php?lot_id=" . $lot_id);
    }
} else {
    $page_content = renderTemplate('templates/add_lot.php', [
        'categories' => $categories,
    ]);
}

$layout_content = renderTemplate('templates/layout.php', [
    'categories' => $categories,
    'content' => $page_content,
    'title' => 'Добавить лот',
    'mainClass' => '',
    'currentUser' => $currentUser
]);

echo $layout_content;