<?php if (empty($posts)) : ?>
    <h1 class="visually-hidden">Страница результатов поиска (нет результатов)</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
                <span>Вы искали:</span>
                <span class="search__query-text"><?php print($_GET['search']); ?></span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <div class="search__no-results container">
                <p class="search__no-results-info">К сожалению, ничего не найдено.</p>
                <p class="search__no-results-desc">
                    Попробуйте изменить поисковый запрос или просто зайти в раздел &laquo;Популярное&raquo;, там живет самый крутой контент.
                </p>
                <div class="search__links">
                    <a class="search__popular-link button button--main" href="/popular.php">Популярное</a>
                    <a class="search__back-link" href="<?php print($_SERVER['HTTP_REFERER']); ?>">Вернуться назад</a>
                </div>
            </div>
        </div>
    </section>
<?php else : ?>

    <h1 class="visually-hidden">Страница результатов поиска</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
                <span>Вы искали:</span>
                <span class="search__query-text"><?php print($_GET['search']); ?></span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <div class="container">
                <div class="search__content">
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
                                                <a class="post__author-link" href="#" title="Автор">
                                                    <div class="post__avatar-wrapper">
                                                        <img class="post__author-avatar" src="img/<?= $val['avatar'] ?>" alt="Аватар пользователя" width="60px" height="60px">
                                                    </div>
                                                    <div class="post__info">
                                                        <b class="post__author-name"><?= $val['name'] ?></b>
                                                        <span class="post__time"><?= checkTime($val['date']); ?></span>
                                                    </div>
                                                </a>
                                            </header>
                                            <?php switch ($val['content_id']):
                                                case 1: ?>
                                                    <div class="post__main">
                                                        <h2><a href="/post.php?id=<?= $val['id'] ?>"><?= $val['title'] ?></a></h2>
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
                                                            <a class="post-link__external" href="<?= $val['link'] ?>" title="Перейти по ссылке">
                                                                <div class="post-link__icon-wrapper">
                                                                    <img src="img/logo-vita.jpg" alt="Иконка">
                                                                </div>
                                                                <div class="post-link__info">
                                                                    <h3><?= $val['title'] ?></h3>
                                                                    <p><?= $val['text'] ?></p>
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
                                                    <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
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
                                                        <span>25</span>
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
        </div>
    </section>

<?php endif; ?>