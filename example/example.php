<?php
/**
 * Created by Semen Kamenetskiy.
 * Date: 26/08/15
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/.application.php';
require_once __DIR__ . '/models/ProductExample.php';

/**
 * Lets load all the products we have in database
 *
 * @var ProductExample[] $products
 */
$products = ProductExample::find()->all();

/** Lets add them all to the cart */
foreach ($products as $product) {
    /** @var ProductExample $product */
    Yii::$app->cart->add($product);
}

var_dump(Yii::$app->cart);