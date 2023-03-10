# Тестовое задание для компании "Мокрый нос"

## Текст задания

Разработать небольшой новостной сайт-визитку. На главной странице выводятся 3 новости (отображаем заголовок, краткий текст) отсортированных по дате добавления, с пагинатором и возможностью сортировки по дате в прямом и обратном порядке. Выводятся только активные новости.

В качестве меню реализовать список категорий в которых есть новости. Вложенность
категорий не ограничена. Ссылка на страницу новости должна быть вида /news/news_title.

Страница /news/news_title должна отображать заголовок новости, текст новости, дату
создания новости, а также форму с комментариями под новостью.
Страница /admin должна проверять авторизацию пользователя. Логин login, пароль
password

Администратор может:
1. Просматривать список новостей, добавлять/редактировать/удалять новость.
2. Просматривать список категорий, добавлять/редактировать/удалять категорию.

При добавлении категории нужно указать:
1. Название
2. Родительская категория

При добавлении новости нужно указать:
1. заголовок
2. категорию
3. анонс
4. подробный текст


## Реализация

Проект реализован на основе Yii2 (использование в качестве микрофреймворка) с использованием последней версии PHP. В качестве базы данных была использована PostgreSQL. Весь проект запускается в сборке  докера из 4 контейнеров.

## Запуск

1. Сделать копию репозитария   ```git clone ```
2. В корне склонированного репозитория запустить ```docker compose up -d ```
3. Зайти в контейнер php (wnr-back) ``` docker exec -ti  wnr-back sh ```  и внутри выполнить команды ```composer i ```  и ``` ./yii migrate ```
4. Зайти в контейнер node (wnr-front)  ``` docker exec -ti  wnr-front sh ```, подтянуть нужные скрипты запустив на выполнение команду ```npm i```  и собрать стили проектеа ``` npm run build ```
5. В браузере открыть [адрес](http://127.0.0.1:8080), Открыть страницу Вход. Авторизоваться как администратор (логин *admin* и пароль *admin*).
6. Проверить проект на соответствие ТЗ.