# laravel-test-e2e-integration-assignment-2

Laravel Dusk End-to-End Browser Testing for Authentication process flow verification

---

### Breeze Authentication (Blade with Alpine)

This project utilizes Laravel Breeze for authentication, providing a robust and easy-to-use scaffolding with Blade templates and Alpine.js.

#### Installation Steps:

-   **Install Laravel Breeze:**

    ```bash
    composer require laravel/breeze --dev
    ```

-   **Scaffold Breeze Components:**

    ```bash
    php artisan breeze:install
    ```

-   **Run Database Migrations:**

    ```bash
    php artisan migrate
    ```

-   **Generate NPM build:**

    ```bash
    npm run build
    ```

-   **Install Laravel Dusk:**
    ```bash
    composer require --dev laravel/dusk
    ```
-   **Scaffold Dusk Components:**
    ```bash
    php artisan dusk:install
    ```
-   **Create .env.dusk.local:**
    ```bash
    cp .env .env.dusk.local
    ```
-   **Edit .env.dusk.local:**

    ```bash
    APP_NAME=DuskIntegrationE2ETesting
    APP_ENV=dusk.local
    APP_KEY=base64:fUUR4u1gv1UOnUWmc1KvBbrdc/Y5Uv6IDDDIAZRixNQ=
    APP_DEBUG=true
    APP_URL=http://localhost:8000

    mysql lite test database
    DB_CONNECTION=sqlite
    DB_DATABASE=/absolute/path/to/database/database.sqlite

    mysql test database
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1 # or your MySQL host
    DB_PORT=3306 # default MySQL port
    DB_DATABASE=test_database_dusk # dedicated test database
    DB_USERNAME=root # or your MySQL username
    DB_PASSWORD=123456 # your MySQL password

    SESSION_DRIVER=array
    CACHE_DRIVER=array
    QUEUE_CONNECTION=sync
    MAIL_MAILER=array

    ChromeDriver specific

    DUSK_DRIVER_URL=http://localhost:9515
    CHROME_PATH=/usr/bin/google-chrome # google chrome browser path,
    DUSK_HEADLESS=false # Set false for actual web browser opening and interacting in real-time and type something and true for hidden integration or end 2 end testing without web browser opening

````

-   **Laravel Optimize Clear Once:**

    ```bash
    php artisan optimize:clear
    ```

-   **Run in one terminal Laravel Server:**
    ```bash
    php artisan serve
    ```
-   **Run another terminal Laravel Dusk:**
    ```bash
    php artisan dusk
    ```

### Laravel Dusk Authentication Test Flow Steps

## This project utilizes Laravel Breeze for authentication, providing a robust and easy-to-use scaffolding with Blade templates and Alpine.js.

-   **make RegisterTest:** tests/Browser/RegisterTest.php
    ```bash
    php artisan dusk:make RegisterTest
    ```
````
