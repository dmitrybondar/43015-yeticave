<?= renderTemplate('templates/nav.php', ['categories' => $categories]); ?>
<form class="form container" action="" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?=isset($errors['email'])? "form__item--invalid" : "";?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=isset($form['email'])? $form['email'] : '';?>">
        <span class="form__error"><?=isset($errors['email'])? $errors['email'] : "";?></span>
    </div>
    <div class="form__item <?=isset($errors['password'])? "form__item--invalid" : "";?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=isset($form['password'])? $form['password'] : '';?>">
        <span class="form__error"><?=isset($errors['password'])? $errors['password'] : "";?></span>
    </div>
    <div class="form__item <?=isset($errors['name'])? "form__item--invalid" : "";?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=isset($form['name'])? $form['name'] : '';?>">
        <span class="form__error"><?=isset($errors['name'])? $errors['name'] : "";?></span>
    </div>
    <div class="form__item <?=isset($errors['contacts'])? "form__item--invalid" : "";?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться"><?=isset($form['contacts'])? $form['contacts'] : '';?></textarea>
        <span class="form__error"><?=isset($errors['contacts'])? $errors['contacts'] : "";?></span>
    </div>
    <div class="form__item form__item--file form__item--last <?=isset($errors['avatar'])? "form__item--invalid" : "";?> <?=isset($form['avatar'])? 'form__item--uploaded' : '';?>">
        <label>Аватар</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="<?=isset($form['avatar'])? $form['avatar'] : '';?>" width="113" height="113" alt="Ваш аватар">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="avatar" id="photo2">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
        <span class="form__error"><?=isset($errors['avatar'])? $errors['avatar'] : "";?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="/login.php">Уже есть аккаунт</a>
</form>