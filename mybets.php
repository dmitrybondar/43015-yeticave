<?php
include "authorization.php";
include "functions.php";
include "mysql_helper.php";
include "init.php";

redirectTo();

$array_my_bets = [];
if(isset($_COOKIE['my_bets'])) {
    $array_my_bets = json_decode($_COOKIE['my_bets'], true);
}

$page_content = renderTemplate('templates/my_bets.php', [
    'array_my_bets' => $array_my_bets,
    'categories' => $categories,
    'lots' => $lots,
]);

$layout_content = renderTemplate('templates/layout.php', [
    'content' => $page_content,
    'title' => 'Мои лоты',
    'mainClass' => '',
    'currentUser' => $currentUser
]);

echo $layout_content;