<?= renderTemplate('templates/nav.php', ['categories' => $categories]); ?>
<section class="lot-item container">
    <?php if (isset($lot)): ?>
        <h2><?=$lot['title'];?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=$lot['img'];?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lot['category'];?></span></p>
                <?php if($lot['description']): ?>
                    <p class="lot-item__description"><?=$lot['description'];?></p>
                <?php endif; ?>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?=timeRemaining($lot['end_date']);?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=$lot['price'];?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?=$minBet;?> р</span>
                        </div>
                    </div>
                    <?php if($canAddNewBet): ?>
                        <form class="lot-item__form" method="post">
                            <p class="lot-item__form-item <?=isset($betError)? "form__item--invalid" : "";?>">
                                <label for="value">Ваша ставка</label>
                                <input id="value" type="number" name="value" placeholder="<?=$minBet;?>" value="<?=isset($_POST['value'])? $_POST['value'] : '';?>">
                                <span class="form__error"><?=isset($betError)? $betError : "";?></span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    <?php endif; ?>
                </div>
                <?php if(count($bets)): ?>
                    <div class="history">
                        <h3>История ставок (<span><?=count($bets)?></span>)</h3>
                        <table class="history__list">
                            <?php foreach ($bets as $bet): ?>
                                <tr class="history__item">
                                    <td class="history__name"><?=$bet['name'];?></td>
                                    <td class="history__price"><?=$bet['value'];?> р</td>
                                    <td class="history__time"><?=formatTime($bet['date']);?></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <h1>Лот с этим ID не найден</h1>
    <?php endif; ?>
</section>