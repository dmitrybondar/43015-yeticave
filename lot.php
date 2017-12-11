<?php
include "authorization.php";
include "functions.php";
include "mysql_helper.php";
include "init.php";

$lotId = (isset($_GET['lot_id'])) ? intval($_GET['lot_id']) : null;
try {
    $categories = fetchAll($con, 'SELECT * FROM `categories`');
    $lot = fetchOne($con, "SELECT l.`title`, `img`, `description`, `price`, `end_date`, `bet_step`, `user_id`, c.`title` AS `category` FROM lots l JOIN categories c ON l.`category_id` = c.`id` WHERE `winner_id` IS NULL AND l.`id` = '$lotId'");
    $bets = fetchAll($con, "SELECT `date`, `value`, `name` FROM `bets` JOIN users ON `user_id` = users.`id` WHERE `lot_id` = '$lotId' ORDER BY `date` DESC");
    $maxBet = fetchOne($con, "SELECT MAX(value) as value FROM bets WHERE lot_id='$lotId'");
} catch (Exception $e) {
    renderErrorTemplate($e->getMessage(), $currentUser);
}

//Блок добавления ставки не показывается если: пользователь не авторизован, срок размещения лота истёк, лот создан текущим пользователем, пользователь уже добавлял ставку для этого лота
if (!$currentUser || time() >= strtotime($lot['end_date']) || $lot['user_id'] == $currentUser['id'] || mysqli_num_rows(mysqli_query($con, "SELECT `user_id` FROM `bets` WHERE `lot_id` = '$lotId' AND `user_id` = '$currentUser[id]'")) > 0) {
    $canAddNewBet = false;
} else {
    $canAddNewBet = true;
}
$betError = null;
if ($maxBet['value'] > $lot['price']) {
    $lot['price'] = $maxBet['value'];
}
$minBet = $lot['price'] + $lot['bet_step'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['value'])) {
        if(intval($_POST['value']) >= $minBet && is_numeric($_POST['value']) && is_int($_POST['value']+0)) {
            mysqli_report(MYSQLI_REPORT_ALL);
            try {
                mysqli_query($con, "INSERT INTO bets (lot_id, user_id, value, date) VALUES ('$lotId', '$currentUser[id]', '$_POST[value]', NOW())");
            } catch (Exception $e) {
                renderErrorTemplate($e->getMessage(), $currentUser);
            }
            header("Refresh:0");
            exit();
        } else {
            $betError = 'Введите целое число не меньше минимальной ставки';
        }
    } else {
        $betError = 'Это поле надо заполнить';
    }
}

$page_content = renderTemplate('templates/view.php', [
    'categories' => $categories,
    'bets' => $bets,
    'lot' => $lot,
    'canAddNewBet' => $canAddNewBet,
    'betError' => $betError,
    'minBet' => $minBet,
    'currentUser' => $currentUser
]);

$layout_content = renderTemplate('templates/layout.php', [
    'categories' => $categories,
    'content' => $page_content,
    'title' => 'yeticave - Просмотр лота',
    'mainClass' => '',
    'currentUser' => $currentUser
]);

echo $layout_content;