<div class="page__main-section">
    <div class="container">
        <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
    </div>
    <div class="adding-post container">
        <div class="adding-post__tabs-wrapper tabs">
            <div class="adding-post__tabs filters">
                <ul class="adding-post__tabs-list filters__list tabs__list">
                    <?php foreach ($type_cont as $key => $val): ?>
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--<?= $val['class_name'] ?> filters__button--active tabs__item tabs__item--active button">
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-<?= $val['class_name'] ?>"></use>
                                </svg>
                                <span><?= $val['title'] ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="adding-post__tab-content">
                <?php foreach ($type_cont as $key => $val): ?>
                    <section
                        class="adding-post__<?= $val['title'] ?> tabs__content tabs__content--<?php if ($key == 0) {
                            print('active');
                        }; ?>">
                        <h2 class="visually-hidden">
                            <?php switch ($val['id']): ?><?php case 1: ?>
                                Форма добавления текста
                                <? break; ?>
                            <?php case 2: ?>
                                Форма добавления цитата
                                <? break; ?>
                            <?php case 3: ?>
                                Форма добавления фото
                                <? break; ?>
                            <?php case 4: ?>
                                Форма добавления видео
                                <? break; ?>
                            <?php case 5: ?>
                                Форма добавления ссылки
                                <? break; ?>
                            <? endswitch; ?>
                        </h2>
                        <form class="adding-post__form form" action="add.php" method="post" enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= $post_title; ?>
                                    <?php switch ($val['class_name']): ?><?php case 'text': ?>
                                        <?= $post_text; ?>
                                        <?php break; ?>
                                    <?php case 'quote': ?>
                                        <?= $post_quote; ?>
                                        <?= $post_author; ?>
                                        <?php break; ?>
                                    <?php case 'photo': ?>
                                        <div class="adding-post__input-wrapper form__input-wrapper">
                                            <label class="adding-post__label form__label" for="photo-url">Ссылка из
                                                интернета</label>
                                            <div class="form__input-section">
                                                <input class="adding-post__input form__input" id="photo-url" type="text"
                                                       name="photo-heading" placeholder="Введите ссылку">
                                                <button class="form__error-button button" type="button">!<span
                                                        class="visually-hidden">Информация об ошибке</span></button>
                                                <div class="form__error-text">
                                                    <h3 class="form__error-title">Заголовок сообщения</h3>
                                                    <p class="form__error-desc">Текст сообщения об ошибке, подробно
                                                        объясняющий,
                                                        что не так.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php break; ?>
                                    <?php case 'video': ?>
                                        <div class="adding-post__input-wrapper form__input-wrapper">
                                            <label class="adding-post__label form__label" for="video-url">Ссылка youtube
                                                <span
                                                    class="form__input-required">*</span></label>
                                            <div class="form__input-section">
                                                <input class="adding-post__input form__input" id="video-url" type="text"
                                                       name="post-video" placeholder="Введите ссылку">
                                                <button class="form__error-button button" type="button">!<span
                                                        class="visually-hidden">Информация об ошибке</span></button>
                                                <div class="form__error-text">
                                                    <h3 class="form__error-title">Заголовок сообщения</h3>
                                                    <p class="form__error-desc">Текст сообщения об ошибке, подробно
                                                        объясняющий,
                                                        что не так.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php break; ?>
                                    <?php case 'link': ?>
                                        <div class="adding-post__textarea-wrapper form__input-wrapper">
                                            <label class="adding-post__label form__label" for="post-link">Ссылка <span
                                                    class="form__input-required">*</span></label>
                                            <div class="form__input-section">
                                                <input class="adding-post__input form__input" id="post-link" type="text"
                                                       name="post-link">
                                                <button class="form__error-button button" type="button">!<span
                                                        class="visually-hidden">Информация об ошибке</span></button>
                                                <div class="form__error-text">
                                                    <h3 class="form__error-title">Заголовок сообщения</h3>
                                                    <p class="form__error-desc">Текст сообщения об ошибке, подробно
                                                        объясняющий,
                                                        что не так.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php break; ?>
                                    <?php endswitch; ?>


                                    <?= $post_tags ?>

                                </div>
                                <div class="form__invalid-block">
                                    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                                    <ul class="form__invalid-list">
                                        <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li>
                                    </ul>
                                </div>
                            </div>
                            <?php if ($val['class_name'] == 'photo'): ?>
                                <div
                                    class="adding-post__input-file-container form__input-container form__input-container--file">
                                    <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                                        <div
                                            class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                                            <input class="adding-post__input-file form__input-file"
                                                   id="userpic-file-photo"
                                                   type="file" name="userpic-file-photo" title=" ">
                                            <div class="form__file-zone-text">
                                                <span>Перетащите фото сюда</span>
                                            </div>
                                        </div>
                                        <button
                                            class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button"
                                            type="button">
                                            <span>Выбрать фото</span>
                                            <svg class="adding-post__attach-icon form__attach-icon" width="10"
                                                 height="20">
                                                <use xlink:href="#icon-attach"></use>
                                            </svg>
                                        </button>
                                    </div>
                                    <div
                                        class="adding-post__file adding-post__file--photo form__file dropzone-previews">

                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать
                                </button>
                                <a class="adding-post__close" href="#">Закрыть</a>
                            </div>
                            <input type="hidden" name="post-type" value="<?= $val['id'] ?>">
                        </form>

                    </section>

                <?php endforeach; ?>


            </div>
        </div>
    </div>
</div>
