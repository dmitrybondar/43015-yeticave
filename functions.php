<?php
/**
 * Возвращает содержимое шаблона с подставленными параметрами
 *
 * @param string $file путь к файлу
 * @param array $vars массив с данными
 * @return string
 */
function renderTemplate($file, $vars) {
    if(file_exists($file)) {
        ob_start();
        extract($vars);
        include $file;
        return ob_get_clean();
    }
}
/**
 * Возвращает время в формате "ч часов назад", "м минут назад", "только что" или "дд.мм.гг в чч:мм"
 *
 * @param string $date время в формате временной метки
 * @return string
 */
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
/**
 * Возвращает оставшееся время до указанной даты в формате "дд:чч:мм"
 *
 * @param string $date время в формате временной метки
 * @return string
 */
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
/**
 * Перенаправляет на указанную страницу либо на главную страницу, если в функцию ничего не передается
 *
 * @param string $path путь к странице
 */
function redirectTo($path = "/") {
    header("Location: {$path}");
    exit();
}
/**
 * Отображает блок с переданной в функцию ошибкой
 *
 * @param string $error текст ошибки
 * @param array $currentUser массив, содержащий данные о пользователе
 */
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
/**
 * Возвращает результат sql запроса в виде массива, содержащего ассоциативные массивы
 *
 * @param object $con Идентификатор соединения
 * @param string $sql SQL-запрос
 * @return array|null
 * @throws Exception
 */
function fetchAll($con, $sql) {
    if ($result = mysqli_query($con, $sql)) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        throw new Exception(mysqli_error($con));
    }
}
/**
 * Возвращает результат sql запроса в виде ассоциативного массива
 *
 * @param object $con Идентификатор соединения
 * @param string $sql SQL-запрос
 * @return array|null
 * @throws Exception
 */
function fetchOne($con, $sql) {
    if ($result = mysqli_query($con, $sql)) {
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        throw new Exception(mysqli_error($con));
    }
}