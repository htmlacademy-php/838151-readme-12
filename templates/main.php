<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="<?php print("index.php?sort=popular"); ?>">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="<?php print("index.php?" . "sort=likes"); ?>">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="<?php print("index.php?" . "sort=date"); ?>">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?php if (!$post_index) {
                                                                                                    print('filters__button--active');
                                                                                                } ?>" href="popular.php">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($type_cont as $key => $val) : ?>
                        <li class="popular__filters-item filters__item">
                            <a class="filters__button filters__button--<?= $val['class_name'] ?> <?php if ($post_index == $val['id']) {
                                                                                                        print(' filters__button--active');
                                                                                                    } ?> button" href="<?php print("popular.php?" . "id=" . $val['id']) ?>">
                                <span class="visually-hidden"><?= $val['title'] ?></span>
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-<?= $val['class_name'] ?>"></use>
                                </svg>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts as $key => $val) : ?>
                <article class="popular__post post post-<?= $val['class_name'] ?>">
                    <header class="post__header">
                        <h2>
                            <a href="<?php print('post.php?id=' . $val['post_id']); ?>"><?= htmlspecialchars($val['title']); ?></a>
                        </h2>
                    </header>
                    <div class="post__main">
                        <?php switch ($val['content_id']):
                            case '2': ?>
                                <blockquote>
                                    <p>
                                        <?= htmlspecialchars($val['text']); ?>
                                    </p>
                                    <cite><?= htmlspecialchars($val['quote-author']); ?></cite>
                                </blockquote>
                                <?php break; ?>
                            <?php
                            case '1': ?>
                                <?php cutText(htmlspecialchars($val['text'])); ?>
                                <?php break; ?>
                            <?php
                            case '3': ?>
                                <div class="post-photo__image-wrapper">
                                    <img src="uploads/<?= htmlspecialchars($val['picture']); ?>" alt="Фото от пользователя" width="360" height="240">
                                </div>
                                <?php break; ?>
                            <?php
                            case '5': ?>
                                <div class="post-link__wrapper">
                                    <a class="post-link__external" href="http://" title="Перейти по ссылке">
                                        <div class="post-link__info-wrapper">
                                            <div class="post-link__icon-wrapper">
                                                <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                                            </div>
                                            <div class="post-link__info">
                                                <h3><?= htmlspecialchars($val['title']) ?></h3>
                                            </div>
                                        </div>
                                        <span><?= htmlspecialchars($val['link']); ?></span>
                                    </a>
                                </div>
                                <?php break; ?>
                            <?php
                            case '4': ?>
                                <div class="post-video__block">
                                    <div class="post-video__preview">
                                        <?= embed_youtube_cover($val['video']); ?>
                                        <!--                                <img src="img/coast-medium.jpg" alt="Превью к видео" width="360" height="188">-->
                                    </div>
                                    <a href="post-details.html" class="post-video__play-big button">
                                        <svg class="post-video__play-big-icon" width="14" height="14">
                                            <use xlink:href="#icon-video-play-big"></use>
                                        </svg>
                                        <span class="visually-hidden">Запустить проигрыватель</span>
                                    </a>
                                </div>
                                <?php break; ?>
                        <?php endswitch; ?>
                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="/profile.php?id=<?= $val['user_id'] ?>" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <!--укажите путь к файлу аватара-->
                                    <img class="post__author-avatar" src="uploads/<?= $val['avatar'] ?>" alt="Аватар пользователя">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"><?= $val['name'] ?></b>
                                    <time class="post__time" datetime="<?php print($val['date']); ?>"><?php checkTime($val['date']); ?></time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes<?php if (isLike($val['post_id'])) {
                                                                                    print('-active');
                                                                                } ?> button" href="/post.php?id=<?= $val['post_id']; ?>&like=1" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span><?= $val['likes'] ?></span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span><?= $val['comment'] ?></span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="popular__page-links">
            <a class="popular__page-link popular__page-link--prev button button--gray" href="#">Предыдущая страница</a>
            <a class="popular__page-link popular__page-link--next button button--gray" href="#">Следующая страница</a>
        </div>
    </div>
</section>