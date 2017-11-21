<?php
include "functions.php";
include "data.php";

$page_content = renderTemplate('templates/index.php', [
    'categories' => $categories,
    'lots' => $lots,
    'lotTimeRemaining' => $lotTimeRemaining
]);

$layout_content = renderTemplate('templates/layout.php', [
    'content' => $page_content,
    'title' => 'yeticave - Главная',
    'isAuth' => $isAuth,
    'userName' => $userName,
    'userAvatar' => $userAvatar,
    'mainClass' => 'container'
]);

echo $layout_content;