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

$category = (isset($_GET['category'])) ? trim($_GET['category']) : null;
$category = mysqli_real_escape_string($con, $category);
if($category) {
    $pagination = pagination($con, 'category', $category, 1, "SELECT COUNT(l.`id`) as `cnt` FROM `lots` l JOIN categories c ON l.`category_id` = c.`id` WHERE c.`title` = '$category' AND `end_date` > NOW() AND `winner_id` IS NULL");
    try {
        $lots = fetchAll($con, "SELECT l.`id`, l.`title`, `img`, `price`, `end_date`, c.`title` AS `category` FROM lots l JOIN categories c ON l.`category_id` = c.`id` WHERE c.`title` = '$category' AND `end_date` > NOW() AND `winner_id` IS NULL ORDER BY id DESC LIMIT " . $pagination['pageItems'] . " OFFSET " . $pagination['offset']);
    } catch (Exception $e) {
        renderErrorTemplate($e->getMessage(), $currentUser);
    }

    $page_content = renderTemplate('templates/category.php', [
        'categories' => $categories,
        'currentCategory' => $category,
        'lots' => $lots,
        'pagination' => $pagination
    ]);
} else {
    $page_content = renderTemplate('templates/category.php', [
        'categories' => $categories,
        'currentCategory' => $category,
        'lots' => null,
    ]);
}

$layout_content = renderTemplate('templates/layout.php', [
    'categories' => $categories,
    'currentCategory' => $category,
    'content' => $page_content,
    'title' => 'yeticave - Главная',
    'mainClass' => '',
    'currentUser' => $currentUser
]);

echo $layout_content;