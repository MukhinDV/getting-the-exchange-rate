## Развёртывание

### 1) Устанавливаем пакеты

    composer install

### 2) Настройка локальных конфигов

Скопировать примеры и изменить:

    config\db.test.php
### 3) Применяем миграции

    php yii migrate
    php yii migrate --migrationPath=@yii/rbac/migrations  

### 4) Cоздаём/обновляем правила rbac

    php yii rbac/init


##### Обновить/получить данные валют

    php yii currency/update-currency
    
##### Запросы: Первый получение всех валют, 2ой получение по id

    domen/api/currency/get-all-currency
    domen/api/currency/get-currency/{id}