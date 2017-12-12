<?php
include "authorization.php";
include "functions.php";
include "init.php";

$curPage = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$pageItems = 3;
$result = mysqli_query($con, "SELECT COUNT(id) as `cnt` FROM `lots` WHERE `end_date` > NOW() AND `winner_id` IS NULL");
$itemsCount = mysqli_fetch_assoc($result)['cnt'];
$pages_count = ceil($itemsCount / $pageItems);
$offset = ($curPage - 1) * $pageItems;
$pages = range(1, $pages_count);

try {
    $categories = fetchAll($con, 'SELECT * FROM `categories`');
    $lots = fetchAll($con, "SELECT l.`id`, l.`title`, `img`, `price`, `end_date`, c.`title` AS `category` FROM lots l JOIN categories c ON l.`category_id` = c.`id` WHERE `end_date` > NOW() AND `winner_id` IS NULL ORDER BY id DESC LIMIT " . $pageItems . " OFFSET " . $offset);
} catch (Exception $e) {
    renderErrorTemplate($e->getMessage(), $currentUser);
}

$page_content = renderTemplate('templates/index.php', [
    'categories' => $categories,
    'lots' => $lots,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $curPage
]);

$layout_content = renderTemplate('templates/layout.php', [
    'categories' => $categories,
    'content' => $page_content,
    'title' => 'yeticave - Главная',
    'mainClass' => 'container',
    'currentUser' => $currentUser
]);

echo $layout_content;