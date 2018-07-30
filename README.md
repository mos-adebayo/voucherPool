**Voucher Pool**
 
 A voucher pool is a collection of (voucher) codes that can be used by customers (recipients) to get discounts in a web shop.

**Requirements**

`php 7` `composer` `MySQL` 

**Installation**
* git clone https://github.com/mos-adebayo/voucherPool.git
* Run `composer install` from terminal
* Create a .env file  with your local development details using `.env.example` as template
* Create a Database with the name `voucherPool` on Mysql
* Run `composer dump-autoload`
* Run `php artisan migrate:refresh --seed`
* Run `php -S localhost:8000 -t public`

**Routes**

 -  **_Create Recipient_** 
 `POST http://localhost:8000/recipient` 
 
    Example Request body:
    ```application/json
        {
            "name" : "John Smith",
            "email" : "joh.smith@gmail.com"
        }
    ```
 
 -  **_Get Recipients_** 
 `GET http://localhost:8000/recipients` 
 
    Example Response body:
    ```application/json
        {
            "data": [
                    {
                        "id": 1,
                        "name": "Moses Adebayo",
                        "email": "mos.adebayo@gmail.com",
                        "created_at": "2018-07-28 02:56:31"
                    },
                    {
                        "id": 2,
                        "name": "Adeola Shina",
                        "email": "adeola.shina@gmail.com",
                        "created_at": "2018-07-28 14:56:58"
                    }
                ]
        }
    ```

 
 -  **_Create Offer_** 
 `POST http://localhost:8000/offer` 
 
    Example Request body:
    ```application/json
        {
            	"name" : "Naija Jersey",
            	"description": "World cup rush",
            	"fixed_discount" : 30,
            	"expiry_date" : "2018-10-10"
        }
    ```
 
 -  **_Get Offers_** 
 `GET http://localhost:8000/offers` 
 
    Example Response body:
    ```application/json
        {
            "data": [
                    {
                        "id": 1,
                        "name": "Moses Adebayo",
                        "email": "mos.adebayo@gmail.com",
                        "created_at": "2018-07-28 02:56:31"
                    },
                    {
                        "id": 2,
                        "name": "Adeola Shina",
                        "email": "adeola.shina@gmail.com",
                        "created_at": "2018-07-28 14:56:58"
                    }
                ]
        }
    ```

 
 -  **_Get Vouchers By Recipient email_** 
 `POST http://localhost:8000/vouchers/recipient/email` 
 
    Example Request body:
    ```application/json
        {
            "email" : "joh.smith@gmail.com",
        }
    ```
 
 
 -  **_Validate Voucher_** 
 `POST http://localhost:8000/vouchers/validate` 
 
    Example Request body:
    ```application/json
        {
            "email" : "mos.adebayo@gmail.com",
            "voucher" : "5b5be0b51821f"
        }
    ```

 
 -  **_Get All Vouchers_** 
 `GET http://localhost:8000/vouchers` 
 
    Example Response body:
    ```application/json
        {
            "data": [
                    {
                        "id": 9,
                        "code": "5b5ed32c59c00",
                        "recipient_id": 1,
                        "expiry_date": "2018-10-10",
                        "used_on": null,
                        "offer_id": 5,
                        "status_id": 1,
                        "created_at": "2018-07-30 08:58:20",
                        "updated_at": "2018-07-30 08:58:20",
                        "recipient": {
                            "id": 1,
                            "name": "Moses Adebayo",
                            "email": "mos.adebayo@gmail.com",
                            "created_at": "2018-07-28 02:56:31"
                        }
                    }
                ]
        }
    ```

**Test**

Run `vendor/bin/phpunit` from your terminal


**Database Schema**

View schema via https://github.com/mos-adebayo/voucherPool/blob/master/docs/DB_Schema.png 

**Postman Collection**

View schema via https://github.com/mos-adebayo/voucherPool/blob/master/docs/Voucher%20Pool.postman_collection.json
