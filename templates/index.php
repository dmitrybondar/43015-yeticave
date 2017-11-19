<?php
// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

$tomorrow = strtotime('tomorrow midnight');
$now = strtotime('now');
$remaining_seconds = $tomorrow - $now;

$hours = floor(($remaining_seconds % 86400) / 3600);
$minutes = floor(($remaining_seconds % 3600) / 60);

$lot_time_remaining = $hours . ":" . $minutes;
?>

<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach($categories as $category): ?>
            <li class="promo__item promo__item--<?=$category['class']?>">
                <a class="promo__link" href="all-lots.html"><?=$category['title']?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach($lots as $lot): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$lot['img']?>" width="350" height="260" alt="Сноуборд">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$lot['category']?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.html"><?=$lot['title']?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=$lot['price']?><b class="rub">р</b></span>
                        </div>
                        <div class="lot__timer timer">
                            <?=$lot_time_remaining;?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>