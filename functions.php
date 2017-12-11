<?php
function renderTemplate($file, $vars) {
    if(file_exists($file)) {
        ob_start();

        extract($vars);
        include $file;

        return ob_get_clean();
    }
}

function formatTime($date) {
    $date = strtotime($date);
    $secondsPassed = strtotime('now') - $date;
    $hoursPassed = $secondsPassed / 3600;
    $minutesPassed = $secondsPassed / 60;

    if ($hoursPassed >= 24) {
        return date("d.m.Y \в H:i", $date);
    } else if ($hoursPassed >= 1) {
        return floor($hoursPassed) . " часов назад";
    } else if ($minutesPassed >= 1) {
        return floor($minutesPassed) . " минут назад";
    } else {
        return "только что";
    }
}

function timeRemaining($date) {
    $end_date = strtotime($date);
    $now = strtotime('now');
    $remainingSeconds = $end_date - $now;
    if ($remainingSeconds > 0) {
        $days = floor(($remainingSeconds / 86400));
        $hours = floor(($remainingSeconds % 86400) / 3600);
        $minutes = floor(($remainingSeconds % 3600) / 60);
        $timeRemaining = $days . ":" . $hours . ":" . $minutes;
    } else {
        $timeRemaining = "Время вышло";
    }
    return $timeRemaining;
}

function searchUserByEmail($email, $users) {
    $result = null;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;
            break;
        }
    }

    return $result;
}

function redirectTo($path = "/") {
    header("Location: {$path}");
    exit();
}

function renderErrorTemplate($error, $currentUser) {
    $page_content = renderTemplate('templates/error.php', [
        'error' => $error
    ]);

    $layout_content = renderTemplate('templates/layout.php', [
        'content' => $page_content,
        'title' => 'Ошибка',
        'mainClass' => 'container',
        'currentUser' => $currentUser
    ]);

    echo $layout_content;
    exit();
}

function fetchAll($con, $sql) {
    if ($result = mysqli_query($con, $sql)) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        throw new Exception(mysqli_error($con));
    }
}

function fetchOne($con, $sql) {
    if ($result = mysqli_query($con, $sql)) {
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        throw new Exception(mysqli_error($con));
    }
}

function pagination($con, $query, $queryValue, $pageItems, $sql) {
    $pagination = [];
    $pagination['curPage'] = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
    $pagination['pageItems'] = $pageItems;
    $pagination['result'] = mysqli_query($con, $sql);
    $pagination['itemsCount'] = mysqli_fetch_assoc($pagination['result'])['cnt'];
    $pagination['pagesCount'] = ceil($pagination['itemsCount'] / $pagination['pageItems']);
    $pagination['offset'] = ($pagination['curPage'] - 1) * $pagination['pageItems'];
    $pagination['pages'] = range(1, $pagination['pagesCount']);

    if ($query) {
        $pagination['firstPage'] = $_SERVER['SCRIPT_NAME'] . "?" . $query . "=" . $queryValue;
        $pagination['numberPage'] = $_SERVER['SCRIPT_NAME'] . "?" . $query . "=" . $queryValue . "&";
    } else {
        $pagination['firstPage'] = '/';
        $pagination['numberPage'] = "?";
    }

    return $pagination;
}