<?= renderTemplate('templates/nav.php', ['categories' => $categories, 'currentCategory' => $currentCategory]); ?>
<section class="lots container">
    <div class="lots__header">
        <h2>Все лоты в категории <?=$currentCategory;?></h2>
    </div>
    <?php if(count($lots)): ?>
        <?=renderTemplate('templates/list_lots.php', ['lots' => $lots]); ?>
        <?=renderTemplate('templates/pagination.php', ['pagination' => $pagination]); ?>
    <?php else: ?>
        <div>По вашему запросу ничего не найдено</div>
    <?php endif; ?>
</section>