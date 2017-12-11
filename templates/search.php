<?= renderTemplate('templates/nav.php', ['categories' => $categories]); ?>
<section class="lots container">
    <div class="lots__header">
        <h2>Результаты поиска по запросу <?=$search;?></h2>
    </div>
    <?php if(count($lots)): ?>
        <?=renderTemplate('templates/list_lots.php', ['lots' => $lots]); ?>
        <?=renderTemplate('templates/pagination.php', ['pagination' => $pagination]); ?>
    <?php else: ?>
        <div>По вашему запросу ничего не найдено</div>
    <?php endif; ?>
</section>