<?php if ($pagination['pagesCount'] > 1): ?>
    <ul class="pagination-list">
        <?php foreach ($pagination['pages'] as $page): ?>
            <li class="pagination-item <?php if ($page == $pagination['curPage']): ?>pagination-item-active<?php endif; ?>">
                <?php if ($page == 1): ?>
                    <a href="<?=$pagination['firstPage'];?>"><?=$page;?></a>
                <?php else: ?>
                    <a href="<?=$pagination['numberPage'];?>page=<?=$page;?>"><?=$page;?></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>