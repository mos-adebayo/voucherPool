**Voucher Pool**
 
 A voucher pool is a collection of (voucher) codes that can be used by customers (recipients) to get discounts in a web shop.

**Requirements**

`php 7` `composer` `MySQL` 

**Installation**
* git clone ---
* Composer install
* Create a .env file  using `.env.example` as template
* Create a Database with the name `voucherPool`
* composer dump-autoload
* php artisan migrate:refresh --seed
* php -S localhost:8000 -t public

**Routes**

 -  **_Create Recipient_** 
 `POST http://localhost:8000/recipient` 
 
    Example Request body:
    ```javascript
        {
            "name" : "John Smith",
            "email" : "joh.smith@gmail.com"
        }
    ```

**Test**
Run `vendor/bin/phpunit` from your terminal
