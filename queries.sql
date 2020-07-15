-- список типов контента для поста
INSERT INTO readme.content
    (title, class_name)
VALUES ('Текст', 'text'),
       ('Цитата', 'quote'),
       ('Картинка', 'photo'),
       ('Видео', 'video'),
       ('Ссылка', 'link');


-- придумайте пару пользователей
INSERT INTO readme.users
    (registration_date, email, login, password, avatar)
VALUES ('2014-12-05 12:05:14', 'vasya@mail.ru', 'Vasya', '123456', 'avatar1.jpg'),
       ('2017-05-09 13:06:14', 'ivan@mail.ru', 'Ivan', '654321', 'avatar2.jpg');


-- придумайте пару комментариев к разным постам
INSERT INTO `comment` (`id`, `comment_date`, `comment_text`, `user_id`, `post_id`)
VALUES (1, '2020-07-12 19:49:10', 'Прикольное фото', 1, 3);
INSERT INTO `comment` (`id`, `comment_date`, `comment_text`, `user_id`, `post_id`)
VALUES (2, '2020-07-12 19:49:10', 'Дождались!', 3, 2);


-- существующий список постов
INSERT INTO `post` (`id`, `date`, `title`, `text`, `author`, `picture`, `video`, `link`, `count_view`, `user_id`,
                    `content_id`, `hashtag_id`)
VALUES (1, '2015-12-05 12:05:14', 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Лариса', '', '',
        '', 5, 1, 2, NULL);
INSERT INTO `post` (`id`, `date`, `title`, `text`, `author`, `picture`, `video`, `link`, `count_view`, `user_id`,
                    `content_id`, `hashtag_id`)
VALUES (2, '2015-12-05 12:05:14', 'Игра престолов',
        'Не могу дождаться начала финального сезона своего любимого сериала!', 'Владик', '', '', '', 8, 2, 1, NULL);
INSERT INTO `post` (`id`, `date`, `title`, `text`, `author`, `picture`, `video`, `link`, `count_view`, `user_id`,
                    `content_id`, `hashtag_id`)
VALUES (3, '2015-12-05 12:05:14', 'Наконец, обработал фотки!', '', 'Виктор', 'rock-medium.jpg', '', '', 6, 3, 3, NULL);
INSERT INTO `post` (`id`, `date`, `title`, `text`, `author`, `picture`, `video`, `link`, `count_view`, `user_id`,
                    `content_id`, `hashtag_id`)
VALUES (4, '2015-12-05 12:05:14', 'Моя мечта', '', 'Лариса', 'coast-medium.jpg', '', '', 12, 1, 3, NULL);
INSERT INTO `post` (`id`, `date`, `title`, `text`, `author`, `picture`, `video`, `link`, `count_view`, `user_id`,
                    `content_id`, `hashtag_id`)
VALUES (5, '2015-12-05 12:05:14', 'Лучшие курсы', '', 'Владик', '', '', 'www.htmlacademy.ru', 12, 2, 5, NULL);


-- получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента
SELECT *
FROM readme.post
         INNER JOIN readme.users ON users.id = post.user_id
         INNER JOIN readme.content ON post.content_id = content.id
ORDER BY count_view;

-- получить список постов для конкретного пользователя
SELECT *
FROM readme.post
         INNER JOIN readme.users ON post.user_id = users.id
WHERE login = 'Larisa';

-- получить список комментариев для одного поста, в комментариях должен быть логин пользователя
SELECT *
FROM readme.comment
         INNER JOIN readme.users ON comment.user_id = users.id
WHERE post_id = 2;

-- добавить лайк к посту
UPDATE post SET likes = likes + 1 WHERE id = 1;

-- подписаться на пользователя
INSERT INTO  subscription (subscribed_user, subscribed_user1)
VALUES (2, 1);