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
    APP_ENV=dusk.local
    APP_URL=http://localhost:8000
    APP_DEBUG=true # for production deploy change to false

    DB_CONNECTION=sqlite
    DB_DATABASE=:memory:

    SESSION_DRIVER=array
    QUEUE_CONNECTION=sync
    MAIL_MAILER=array
    ```

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

---
