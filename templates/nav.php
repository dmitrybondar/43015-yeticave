<nav class="nav">
    <ul class="nav__list container">
        <?php foreach($categories as $category): ?>
            <li class="nav__item <?php if (isset($currentCategory) && $currentCategory == $category['title']): ?>nav__item--current<?php endif; ?>">
                <a href="/category.php?category=<?=$category['title'];?>"><?=$category['title'];?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>