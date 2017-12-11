<?= renderTemplate('templates/nav.php', ['categories' => $categories]); ?>
<form class="form container" action="" method="post">
    <h2>Вход</h2>
    <div style="color: red;"><?=isset($errors['all'])? $errors['all'] : "";?></div>
    <div class="form__item <?=isset($errors['email'])? "form__item--invalid" : "";?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=isset($form['email'])? $form['email'] : '';?>">
        <span class="form__error"><?=isset($errors['email'])? $errors['email'] : "";?></span>
    </div>
    <div class="form__item form__item--last <?=isset($errors['password'])? "form__item--invalid" : "";?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=isset($errors['password'])? $errors['password'] : "";?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>