# Веб-програма для зберігання інформації про фільми (PHP Movie App)

## Опис
Цей проект є веб-додатком для зберігання, управління та відображення інформації про фільми. Система дозволяє користувачам додавати, видаляти, переглядати фільми, а також імпортувати список фільмів із текстового файлу.

## Функціональність
- Авторизація користувача
- Додавання фільму
- Видалення фільму
- Перегляд інформації про фільм
- Показ фільмів, відсортованих за назвою в алфавітному порядку
- Пошук фільмів за назвою
- Пошук фільмів за іменем актора
- Імпорт фільмів із текстового файлу через веб-інтерфейс

## Налаштування

Перед запуском проекту:

1. Скопіюйте файл `.env.example` в новий файл, який називається `.env`.
2. Оновіть налаштування в файлі `.env`, щоб вони відповідали вашому середовищу або залиште як є за замовчуванням.

## Технології
Проект реалізовано на PHP без використання фреймворків. Використовувалась база даних MySQL. Також використовувалися такі пакети:

- `vlucas/phpdotenv`: для завантаження змінних оточення з файлу `.env`.
- `illuminate/routing`: для маршрутизації.
- `jenssegers/blade`: для шаблонізації.
- `illuminate/database`: для роботи з базою даних.
- `middlewares/utils`, `illuminate/pipeline`: для роботи з middleware.
- `nyholm/psr7`: для реалізації PSR-7.
- `autoprefixer`, `postcss`, `postcss-cli`, `tailwindcss`: для роботи з CSS.

## База Даних

У папці `database` знаходиться файл з дампом бази даних (`movies_db.sql`), який буде автоматично розгорнутий. Це створить всі необхідні таблиці та структури у вашій базі даних. Також база буде заповнена початковими даними.

## Доступ до бази даних через phpMyAdmin

- **URL**: http://localhost:8080
- **Логін**: root
- **Пароль**: root

## Встановлення та запуск
1. Клонуйте репозиторій: `git clone https://github.com/bachinsky1/php-movies-app`
2. Перейдіть до директорії проекту: `cd php-movies-app`
3. Встановіть необхідні бібліотеки `composer install`, `npm install`  (Не обов'язково).
4. Запустіть додаток за допомогою Docker: `docker-compose up -d`
5. Перейдіть на `http://localhost` у вашому веб-браузері, щоб відкрити веб-інтерфейс програми.


## Доступ до адміністративної панелі

- **Email**: admin@admin.com
- **Пароль**: password

## Імпорт даних

В кореневій папці проекту знаходиться файл `sample_movies.txt`, який містить зразки даних для фільмів. Ви можете використовувати цей файл для імпорту початкових даних до вашої бази даних через веб-інтерфейс, після запуску додатку. Слід зазначити, що дані цього файлу вже знаходяться в БД. Повторний імпорт не відбудеться.
Для того що протестувати імпорт необхідно очистити таблиці бази з даними про фільми (всі, або хоча б один).

## Що можна покращити

1. Валідація реквестів користувача (клієнтська та серверна).
2. Відправка в браузер повідомлень про помилки.
3. Оптимізація коду контроллера шляхом перенесення бізнес логіки в моделі або сервіси.
4. Валідація структури вхідного текстового файлу.
5. Додати механізм перевірки CSRF-токена на всі форми через окремий мідлвар (зараз перевіряється тільки форма логіну).
6. Додати vite або webpack для збірки фронтенду (зараз використовується тільки postcss для збірки tailwindcss)





