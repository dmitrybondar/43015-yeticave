<?php
define('DB_HOST','localhost');
define('DB_LOGIN','root');
define('DB_PASS','');
define('DB_NAME','yeticave');

$con = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
if (!$con) {
    renderErrorTemplate(mysqli_connect_error(), $currentUser);
}
mysqli_set_charset($con, "utf8");