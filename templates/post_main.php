<main class="page__main page__main--publication">
    <?php if (!$post == []) : ?>
        <div class="container">
            <h1 class="page__title page__title--publication"><?php print($post[0]['title']); ?></h1>
            <section class="post-details">
                <h2 class="visually-hidden">Публикация</h2>
                <div class="post-details__wrapper post-<?php print($post[0]['class_name']); ?>">
                    <div class="post-details__main-block post post--details">
                        <?php switch ($post[0]['content_id']):
                            case 1: ?>
                                <?= $post_text; ?>
                                <?php break; ?>
                            <?php
                            case 2: ?>
                                <?= $post_quote; ?>
                                <?php break; ?>
                            <?php
                            case 3: ?>
                                <?= $post_photo; ?>
                                <?php break; ?>
                            <?php
                            case 4: ?>
                                <?= $post_video; ?>
                                <?php break; ?>
                            <?php
                            case 5: ?>
                                <?= $post_link; ?>
                                <?php break; ?>
                        <?php endswitch; ?>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes<?php if($like) {print('-active');} else {print(' ');}; ?> button" href="/post.php?id=<?= $_GET['id']?>&like=<?php if(!$like) {print(1);} else {print(0);}?>" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span><?php print($post[0]['likes']); ?></span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span><?php print(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `comment` WHERE comment.post_id = '{$_GET['id']}'")))?></span>
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
                            <span class="post__view"><?php print($post[0]['count_view']); ?> просмотров</span>
                        </div>
                        <div class="comments">
                            <form class="comments__form form" action="#" method="post">
                                <div class="comments__my-avatar">
                                    <img class="comments__picture" src="uploads/<?= (requestDb("SELECT avatar FROM users WHERE users.id = '{$_SESSION['id']}'"))[0]['avatar'] ?>" alt="Аватар пользователя">
                                </div>
                                <div class="form__input-section <?php if (!empty($errors['comment'])) {
                                                                    print('form__input-section--error');
                                                                } ?>">
                                    <textarea class="comments__textarea form__textarea form__input" placeholder="Ваш комментарий" name="comment"></textarea>
                                    <label class="visually-hidden">Ваш комментарий</label>
                                    <button class="form__error-button button" type="button">!</button>
                                    <div class="form__error-text">
                                        <h3 class="form__error-title">Ошибка валидации</h3>
                                        <p class="form__error-desc"><?= $errors['comment'] ?></p>
                                    </div>
                                </div>
                                <button class="comments__submit button button--green" type="submit">Отправить</button>
                            </form>
                            <div class="comments__list-wrapper">
                                <ul class="comments__list">
                                    <?php foreach ($comments as $key => $val) : ?>
                                        <li class="comments__item user">
                                            <div class="comments__avatar">
                                                <a class="user__avatar-link" href="#">
                                                    <img class="comments__picture" src="uploads/<?= $val['avatar'] ?>" alt="Аватар пользователя">
                                                </a>
                                            </div>
                                            <div class="comments__info">
                                                <div class="comments__name-wrapper">
                                                    <a class="comments__user-name" href="#">
                                                        <span><?= $val['name'] ?></span>
                                                    </a>
                                                    <time class="comments__time" datetime="2019-03-20"><?php checkTime($val['comment_date']); ?></time>
                                                </div>
                                                <p class="comments__text">
                                                    <?= $val['comment_text'] ?>
                                                </p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <!-- <a class="comments__more-link" href="#">
                                <span>Показать все комментарии</span>
                                <sup class="comments__amount">45</sup>
                            </a> -->
                            </div>
                        </div>
                    </div>
                    <div class="post-details__user user">
                        <div class="post-details__user-info user__info">
                            <div class="post-details__avatar user__avatar">
                                <a class="post-details__avatar-link user__avatar-link" href="#">
                                    <img class="post-details__picture user__picture" src="img/<?php print($post[0]['avatar']); ?>" alt="Аватар пользователя">
                                </a>
                            </div>
                            <div class="post-details__name-wrapper user__name-wrapper">
                                <a class="post-details__name user__name" href="#">
                                    <span><?php print($post[0]['name']); ?></span>
                                </a>
                                <time class="post-details__time user__time" datetime="2014-03-20">5 лет на сайте</time>
                            </div>
                        </div>
                        <div class="post-details__rating user__rating">
                            <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
                                <span class="post-details__rating-amount user__rating-amount">1856</span>
                                <span class="post-details__rating-text user__rating-text">подписчиков</span>
                            </p>
                            <p class="post-details__rating-item user__rating-item user__rating-item--publications">
                                <span class="post-details__rating-amount user__rating-amount"><?= $publication_count[0]['COUNT(*)'] ?></span>
                                <span class="post-details__rating-text user__rating-text">публикаций</span>
                            </p>
                        </div>
                        <div class="post-details__user-buttons user__buttons">
                            <button class="user__button user__button--subscription button button--main" type="button">
                                Подписаться
                            </button>
                            <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php else : ?>
        <h1>404 страница не найдена</h1>
    <?php endif; ?>
</main>