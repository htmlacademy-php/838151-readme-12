<div class="adding-post__textarea-wrapper form__textarea-wrapper <?php if (!empty($errors['post-text'])) {
    print(' form__input-section--error');
} ?>">
    <label class="adding-post__label form__label" for="post-text">Текст поста <span
            class="form__input-required">*</span></label>
    <div class="form__input-section">
                                        <textarea class="adding-post__textarea form__textarea form__input"
                                                  id="post-text" placeholder="Введите текст публикации" name="post-text"><?= getPostVal('post-text')?></textarea>
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $errors['post-text']; ?></p>
        </div>
    </div>
</div>
