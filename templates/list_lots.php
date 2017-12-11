<ul class="lots__list">
    <?php foreach($lots as $lot): ?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=$lot['img'];?>" width="350" height="260" alt="Сноуборд">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?=$lot['category'];?></span>
                <h3 class="lot__title"><a class="text-link" href="/lot.php?lot_id=<?=$lot['id'];?>"><?=$lot['title'];?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost"><?=$lot['price'];?><b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer">
                        <?=timeRemaining($lot['end_date']);?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>