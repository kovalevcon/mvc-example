# MVC Example

This project contains the implementation of MVC pattern.

# Requirements

* **PHP** >= `7.2`;
* **MySQL** >= `5.7` or **MariaDB** >= `10.3`. Configure connection in `config/db.php` file. 

# Install

1. Install dependencies:

    ```bash
    composer install
    ```

2. Execute dump-autoload:

    ```bash
    composer dump-autoload -o
    ```

3. Run copy config command and edit MySQL config (`config/db.php`) if needed:

    ```bash
    composer copy-config
    ```

4. Run migrations command:

    ```bash
    composer start-migrations
    ```
    * Migrations create default database name is `mvc_example` and change it in config file.

5. Run web server:

    ```bash
    composer server-start
    ```

# Testing



-- <cite>Kovalev Constantine</cite>