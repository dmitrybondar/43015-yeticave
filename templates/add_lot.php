<?= renderTemplate('templates/nav.php', ['categories' => $categories]); ?>
<form class="form form--add-lot container <?=isset($errors)? 'form--invalid' : '';?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?=isset($errors['title'])? "form__item--invalid" : "";?>">
            <label for="title">Наименование</label>
            <input id="title" type="text" name="title" placeholder="Введите наименование лота" value="<?=isset($lot['title'])? $lot['title'] : '';?>">
            <span class="form__error"><?=isset($errors['title'])? $errors['title'] : "";?></span>
        </div>
        <div class="form__item <?=isset($errors['category'])? "form__item--invalid" : "";?>">
            <label for="category">Категория</label>
            <select id="category" name="category">
                <option value="">Выберите категорию</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?=$category['id'];?>" <?=(isset($lot['category']) && $lot['category'] == $category['id'])? 'selected' : '';?>><?=$category['title'];?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error"><?=isset($errors['category'])? $errors['category'] : "";?></span>
        </div>
    </div>
    <div class="form__item form__item--wide <?=isset($errors['description'])? "form__item--invalid" : "";?>">
        <label for="message">Описание</label>
        <textarea id="message" name="description" placeholder="Напишите описание лота"><?=isset($lot['description'])? $lot['description'] : '';?></textarea>
        <span class="form__error"><?=isset($errors['description'])? $errors['description'] : "";?></span>
    </div>
    <div class="form__item form__item--file <?=isset($errors['img'])? "form__item--invalid" : "";?> <?=isset($lot['img'])? 'form__item--uploaded' : '';?>">
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="<?=isset($lot['img'])? $lot['img'] : '';?>" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="img" id="photo2">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
        <span class="form__error"><?=isset($errors['img'])? $errors['img'] : "";?></span>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?=isset($errors['price'])? "form__item--invalid" : "";?>">
            <label for="price">Начальная цена</label>
            <input id="price" type="number" name="price" placeholder="0" value="<?=isset($lot['price'])? $lot['price'] : '';?>">
            <span class="form__error"><?=isset($errors['price'])? $errors['price'] : "";?></span>
        </div>
        <div class="form__item form__item--small <?=isset($errors['bet_step'])? "form__item--invalid" : "";?>">
            <label for="bet_step">Шаг ставки</label>
            <input id="bet_step" type="number" name="bet_step" placeholder="0" value="<?=isset($lot['bet_step'])? $lot['bet_step'] : '';?>">
            <span class="form__error"><?=isset($errors['bet_step'])? $errors['bet_step'] : "";?></span>
        </div>
        <div class="form__item <?=isset($errors['end_date'])? "form__item--invalid" : "";?>">
            <label for="date">Дата окончания торгов</label>
            <input class="form__input-date" id="date" type="date" name="end_date" value="<?=isset($lot['end_date'])? $lot['end_date'] : '';?>">
            <span class="form__error"><?=isset($errors['end_date'])? $errors['end_date'] : "";?></span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
