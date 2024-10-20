# Тестове завдання для backend-розробника

## Опис завдання
Необхідно реалізувати **upgrade** і **downgrade** підписки, щоб була можливість змінювати:
- Тарифний план
- Кількість користувачів
- Періодичність оплати

Реалізація має бути виконана на **Laravel 9+**.

### Тарифні плани:
| Тариф      | Ціна за користувача на місяць |
|------------|------------------------------|
| Lite       | 4 євро                       |
| Starter    | 6 євро                       |
| Premium    | 10 євро                      |

### Можлива періодичність оплати:
- **Щомісяця** (за замовчуванням)
- **Щороку** (з 20% знижкою)

### Приклад поточного стану підписки:
- **Тариф**: Lite
- **Кількість користувачів**: 7
- **Загальна вартість**: 28 євро
- **Періодичність оплати**: щомісяця
- **Діє до**: 20.10.2024

### Вимоги:
1. Відобразити поточний стан підписки та загальну вартість.
2. Додати можливість змінювати тарифний план через форму. Обов'язково виконати валідацію даних перед збереженням.
3. Після зміни підписки (upgrade/downgrade):
    - Поточна підписка продовжує діяти до кінця оплачуваного періоду.
    - Наступна оплата здійснюватиметься за новим тарифом.
    - Зміни щодо нового тарифу також потрібно відобразити на сторінці.

### Додаткові вимоги:
- Візуальна частина неважлива, головне — правильність відображення даних.
- Рішення необхідно надати у вигляді публічного **git-репозиторію**.

## Як використовувати

### Встановлення
1. Клонуйте репозиторій:
   ```bash
   git clone https://github.com/WladGin/subscription-test.git
2. Перейдіть у папку проекту:
   ```bash
   cd your-repository
3. Встановіть залежності:
   ```bash
    composer install
4. Скопіюйте файл `.env.example` у `.env`:
5. Згенеруйте ключ програми:
   ```bash
   php artisan key:generate
6. Створіть базу даних та вкажіть налаштування у файлі `.env`:
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
7. Виконайте міграції:
    ```bash
    php artisan migrate

8. Заповніть базу даних тестовими даними:
    ```bash
    php artisan db:seed
9. Запустіть сервер:
    ```bash
    php artisan serve
