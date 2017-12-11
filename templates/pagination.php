<?php if ($pages_count > 1): ?>
    <ul class="pagination-list">
        <?php foreach ($pages as $page): ?>
            <li class="pagination-item <?php if ($page == $cur_page): ?>pagination-item-active<?php endif; ?>">
                <a href="/?page=<?=$page;?>"><?=$page;?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>