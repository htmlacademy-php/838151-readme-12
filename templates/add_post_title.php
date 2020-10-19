<div class="adding-post__input-wrapper form__input-wrapper <?php if (!empty($errors['post-title'])) {
                                                                print(' form__input-section--error');
                                                            } ?> ">
    <label class="adding-post__label form__label" for="photo-heading">Заголовок
        <span class="form__input-required">*</span></label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="photo-heading" type="text" name="post-title" placeholder="Введите заголовок" value="<?= getPostVal('post-title') ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $errors['post-title']; ?></p>
        </div>
    </div>
</div>