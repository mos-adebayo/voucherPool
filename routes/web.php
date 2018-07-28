<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*
 * Recipient Actions...
 *
 */
$router->get('recipients', 'RecipientController@showAll');
$router->post('recipient', 'RecipientController@create');

/*
 * Offer Actions...
 *
 */
$router->get('offers', 'OfferController@showAll');
$router->post('offer', 'OfferController@create');

/*
 * Voucher Actions...
 *
 */
$router->get('vouchers', 'VoucherController@showAll');
$router->post('voucher', 'VoucherController@create');
$router->get('vouchers/recipient/{id}', 'VoucherController@showAllVouchersByRecipientId');
$router->post('vouchers/recipient/email', 'VoucherController@showAllVouchersByEmail');
$router->post('vouchers/validate', 'VoucherController@validateVoucher');
