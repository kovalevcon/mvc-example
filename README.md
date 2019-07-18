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

1. Generate `20` products:

    Request:

    ```bash
    curl --request POST \
      --url http://locahost:8080/products
    ```

    Response `JSON`:

    ```json
    {
      "success": true,
      "payload": {
        "ids": [
          1,
          2,
          3,
          4,
          5,
          6,
          7,
          8,
          9,
          10,
          11,
          12,
          13,
          14,
          15,
          16,
          17,
          18,
          19,
          20
        ],
        "count": 20
      },
      "error": null
    }
    ```

2. Get all available products:

    Request:

    ```bash
    curl --request GET \
      --url http://locahost:8080/products
    ```

    Response `JSON`:

    ```json
    {
      "success": true,
      "payload": {
        "items": [
          {
            "id": 1,
            "name": "Product1048321442",
            "cost": 1.4218,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 2,
            "name": "Product1574974314",
            "cost": 5.3577,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 3,
            "name": "Product699813728",
            "cost": 29.531,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 4,
            "name": "Product759397603",
            "cost": 19.5822,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 5,
            "name": "Product1060588159",
            "cost": 61.1964,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 6,
            "name": "Product31496202",
            "cost": 18.5478,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 7,
            "name": "Product1203172434",
            "cost": 31.0397,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 8,
            "name": "Product901697980",
            "cost": 47.1942,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 9,
            "name": "Product74356551",
            "cost": 37.1686,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 10,
            "name": "Product293849036",
            "cost": 5.0367,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 11,
            "name": "Product1498939259",
            "cost": 45.1783,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 12,
            "name": "Product1644555470",
            "cost": 34.8452,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 13,
            "name": "Product1731486760",
            "cost": 0.2986,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 14,
            "name": "Product1491275424",
            "cost": 35.69,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 15,
            "name": "Product858609397",
            "cost": 60.7129,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 16,
            "name": "Product1811476809",
            "cost": 12.9055,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 17,
            "name": "Product1860850042",
            "cost": 44.3276,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 18,
            "name": "Product362245409",
            "cost": 19.0833,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 19,
            "name": "Product454329010",
            "cost": 19.0937,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          },
          {
            "id": 20,
            "name": "Product1878096569",
            "cost": 18.6188,
            "created_at": "2019-07-18 19:02:03",
            "updated_at": null
          }
        ],
        "count": 20
      },
      "error": null
    }
    ```

3. Create new order:

    Request:

    ```bash
    curl --request POST \
      --url http://locahost:8080/orders \
      --header 'content-type: application/json' \
      --data '{
        "product_ids": [1, 2, 3]
    }'
    ```

    Response `JSON`:

    ```json
    {
      "success": true,
      "payload": {
        "id": 5,
        "sum": 36.3105
      },
      "error": null
    }
    ```

4. Pay order:

    Request:

    ```bash
    curl --request PUT \
      --url http://mvc-example.loc:8080/orders \
      --header 'content-type: application/json' \
      --data '{
    	"id": 1,
    	"sum": 36.3105
    }'
    ```

    Response `JSON`:

    ```json
    {
      "success": true,
      "payload": {
        "id": 1,
        "status": "paid"
      },
      "error": null
    }
    ```

-- <cite>Kovalev Constantine</cite>