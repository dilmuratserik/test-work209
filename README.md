# Инструкция по установке и запуску проекта

## Шаги для запуска проекта:

1. Установите зависимости с помощью Composer:
   composer install
2. Настройте файл `.env`:
- Скопируйте `.env.example` и переименуйте в `.env`.
- Задайте настройки вашей базы данных и другие переменные окружения.
3. Выполните миграции и заполните базу данных начальными данными:
   php artisan migrate --seed
4. Запустите локальный сервер:
   php artisan serve


