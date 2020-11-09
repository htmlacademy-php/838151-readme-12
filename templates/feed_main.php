<main class="page__main page__main--feed">
<div class="container">
    <h1 class="page__title page__title--feed">Моя лента</h1>
</div>
<div class="page__main-wrapper container">
    <section class="feed">
        <h2 class="visually-hidden">Лента</h2>
        <div class="feed__main-wrapper">
            <div class="feed__wrapper">
                <?php foreach ($posts
                    as $key => $val) : ?>
                    <?php switch ($val['content_id']):
                        case 1: ?>
                            <article class="feed__post post post-text">
                                <?php break; ?>
                            <?php
                        case 2: ?>
                                <article class="feed__post post post-quote">
                                    <?php break; ?>
                                <?php
                            case 3: ?>
                                    <article class="feed__post post post-photo">
                                        <?php break; ?>
                                    <?php
                                case 4: ?>
                                        <article class="feed__post post post-video">
                                            <?php break; ?>
                                        <?php
                                    case 5: ?>
                                            <article class="feed__post post post-link">
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                        <header class="post__header post__author">
                                            <a class="post__author-link" href="/profile.php?id=<?= $val['user_id']?>" title="Автор">
                                                <div class="post__avatar-wrapper">
                                                    <img class="post__author-avatar" src="img/<?= $val['avatar'] ?>" alt="Аватар пользователя" width="60px" height="60px">
                                                </div>
                                                <div class="post__info">
                                                    <b class="post__author-name"><?= $val['name'] ?></b>
                                                    <span class="post__time"><?= checkTime($val['DATE']); ?></span>
                                                </div>
                                            </a>
                                        </header>
                                        <?php switch ($val['content_id']):
                                            case 1: ?>
                                                <div class="post__main">
                                                    <h2><a href="#"><a href="#"><?= $val['title'] ?></a></h2>
                                                    <p>
                                                        <?= $val['text'] ?>
                                                    </p>
                                                    <a class="post-text__more-link" href="#">Читать далее</a>
                                                </div>
                                                <?php break; ?>
                                            <?php
                                            case 2: ?>
                                                <div class="post__main">
                                                    <blockquote>
                                                        <p>
                                                            <?= $val['text'] ?>
                                                        </p>
                                                        <cite><?= $val['author'] ?></cite>
                                                    </blockquote>
                                                </div>
                                                <?php break; ?>
                                            <?php
                                            case 3: ?>
                                                <div class="post__main">
                                                    <h2><a href="#"><?= $val['title'] ?></a></h2>
                                                    <div class="post-photo__image-wrapper">
                                                        <img src="uploads/<?= $val['picture'] ?>" alt="Фото от пользователя" width="760" height="396">
                                                    </div>
                                                </div>
                                                <?php break; ?>
                                            <?php
                                            case 4: ?>
                                                <div class="post__main">
                                                    <div class="post-video__block">
                                                        <div class="post-video__preview">
                                                            <img src="img/coast.jpg" alt="Превью к видео" width="760" height="396">
                                                        </div>
                                                        <div class="post-video__control">
                                                            <button class="post-video__play post-video__play--paused button button--video" type="button"><span class="visually-hidden">Запустить видео</span></button>
                                                            <div class="post-video__scale-wrapper">
                                                                <div class="post-video__scale">
                                                                    <div class="post-video__bar">
                                                                        <div class="post-video__toggle"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video" type="button"><span class="visually-hidden">Полноэкранный режим</span></button>
                                                        </div>
                                                        <button class="post-video__play-big button" type="button">
                                                            <svg class="post-video__play-big-icon" width="27" height="28">
                                                                <use xlink:href="#icon-video-play-big"></use>
                                                            </svg>
                                                            <span class="visually-hidden">Запустить проигрыватель</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <?php break; ?>
                                            <?php
                                            case 5: ?>
                                                <div class="post__main">
                                                    <div class="post-link__wrapper">
                                                        <a class="post-link__external" href="http://www.vitadental.ru" title="Перейти по ссылке">
                                                            <div class="post-link__icon-wrapper">
                                                                <img src="img/logo-vita.jpg" alt="Иконка">
                                                            </div>
                                                            <div class="post-link__info">
                                                                <h3>Стоматология «Вита»</h3>
                                                                <p>Семейная стоматология в Адлере</p>
                                                                <span><?= $val['link'] ?></span>
                                                            </div>
                                                            <svg class="post-link__arrow" width="11" height="16">
                                                                <use xlink:href="#icon-arrow-right-ad"></use>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                        <footer class="post__footer post__indicators">
                                            <div class="post__buttons">
                                                <a class="post__indicator post__indicator--likes<?php if(isLike($val['post_id'])){print('-active');}?> button" href="/post.php?id=<?= $val['post_id'];?>&like=1" title="Лайк">
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
                                                    <span><?= $val['comment']?></span>
                                                    <span class="visually-hidden">количество комментариев</span>
                                                </a>
                                                <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                                                    <svg class="post__indicator-icon" width="19" height="17">
                                                        <use xlink:href="#icon-repost"></use>
                                                    </svg>
                                                    <span>5</span>
                                                    <span class="visually-hidden">количество репостов</span>
                                                </a>
                                            </div>
                                        </footer>
                                            </article>
                                        <?php endforeach; ?>
            </div>
        </div>
        <ul class="feed__filters filters">
            <li class="feed__filters-item filters__item">
                <a class="filters__button  <?php if (!$post_index) {
                                                print('filters__button--active');
                                            } ?>" href="<?php print("feed.php") ?>">
                    <span>Все</span>
                </a>
            </li>
            <?php foreach ($type_cont as $key => $val) : ?>
                <li class="feed__filters-item filters__item">
                    <a class="filters__button filters__button--<?= $val['class_name'] ?> <?php if ($post_index == $val['id']) {
                                                                                                print(' filters__button--active');
                                                                                            } ?> button" href="<?php print("feed.php?" . "id=" . $val['id']) ?>">
                        <span class="visually-hidden"><?= $val['title'] ?></span>
                        <svg class="filters__icon" width="22" height="18">
                            <use xlink:href="#icon-filter-<?= $val['class_name'] ?>"></use>
                        </svg>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <aside class="promo">
        <article class="promo__block promo__block--barbershop">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
                Все еще сидишь на окладе в офисе? Открой свой барбершоп по нашей франшизе!
            </p>
            <a class="promo__link" href="#">
                Подробнее
            </a>
        </article>
        <article class="promo__block promo__block--technomart">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
                Товары будущего уже сегодня в онлайн-сторе Техномарт!
            </p>
            <a class="promo__link" href="#">
                Перейти в магазин
            </a>
        </article>
        <article class="promo__block">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
                Здесь<br> могла быть<br> ваша реклама
            </p>
            <a class="promo__link" href="#">
                Разместить
            </a>
        </article>
    </aside>
</div>
<main>