<?= renderTemplate('templates/nav.php', ['categories' => $categories]); ?>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <? if (count($array_my_bets)) :?>
            <?php foreach ($array_my_bets as $key => $bet): ?>
                <tr class="rates__item <?=$itemStatus;?>">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="<?=$bet['img'];?>" width="54" height="40" alt="Сноуборд">
                        </div>
                        <h3 class="rates__title"><a href="/lot.php?lot_id=<?=$key?>"><?=$bet['title'];?></a></h3>
                    </td>
                    <td class="rates__category">
                        <?=$bet['category'];?>
                    </td>
                    <td class="rates__timer">
                        <div class="timer"><?=timeRemaining($bet['lot_date']);?></div> <!-- timer--finishing -->
                    </td>
                    <td class="rates__price">
                        <?=$bet['value'];?> р
                    </td>
                    <td class="rates__time">
                        <?=formatTime($bet['bet_date']);?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <div>Вы еще не сделали ни одной ставки</div>
        <?php endif; ?>

        <!-- <tr class="rates__item rates__item--win">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="img/rate3.jpg" width="54" height="40" alt="Крепления">
                </div>
                <div>
                    <h3 class="rates__title"><a href="lot.html">Крепления Union Contact Pro 2015 года размер L/XL</a></h3>
                    <p>Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20</p>
                </div>
            </td>
            <td class="rates__category">
                Крепления
            </td>
            <td class="rates__timer">
                <div class="timer timer--win">Ставка выиграла</div>
            </td>
            <td class="rates__price">
                10 999 р
            </td>
            <td class="rates__time">
                Час назад
            </td>
        </tr> -->
    </table>
</section>