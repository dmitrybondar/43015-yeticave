<?php
include "authorization.php";
include "functions.php";
include "mysql_helper.php";
include "init.php";

try {
    $categories = fetchAll($con, 'SELECT * FROM `categories`');
} catch (Exception $e) {
    renderErrorTemplate($e->getMessage(), $currentUser);
}

$search = (isset($_GET['q'])) ? trim($_GET['q']) : null;
$search = mysqli_real_escape_string($con, $search);
if($search) {
    $pagination = pagination($con, 'q', $search, 1, "SELECT COUNT(id) as `cnt` FROM `lots` WHERE (`title` LIKE '%$search%' OR `description` LIKE '%$search%') AND `end_date` > NOW() AND `winner_id` IS NULL");
    try {
        $lots = fetchAll($con, "SELECT l.`id`, l.`title`, `img`, `price`, `end_date`, c.`title` AS `category` FROM lots l JOIN categories c ON l.`category_id` = c.`id` WHERE (l.`title` LIKE '%$search%' OR `description` LIKE '%$search%') AND `end_date` > NOW() AND `winner_id` IS NULL ORDER BY id DESC LIMIT " . $pagination['pageItems'] . " OFFSET " . $pagination['offset']);
    } catch (Exception $e) {
        renderErrorTemplate($e->getMessage(), $currentUser);
    }

    $page_content = renderTemplate('templates/search.php', [
        'categories' => $categories,
        'lots' => $lots,
        'pagination' => $pagination,
        'search' => $search
    ]);
} else {
    $page_content = renderTemplate('templates/search.php', [
        'categories' => $categories,
        'lots' => null,
        'search' => $search
    ]);
}

$layout_content = renderTemplate('templates/layout.php', [
    'categories' => $categories,
    'content' => $page_content,
    'title' => 'yeticave - Главная',
    'mainClass' => '',
    'currentUser' => $currentUser
]);

echo $layout_content;