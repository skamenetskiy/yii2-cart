<?php
/**
 * Created by Semen Kamenetskiy.
 * Date: 26/08/15
 */

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

Yii::$app = new \yii\console\Application(
    [
        'id'         => 'Example',
        'basePath'   => __DIR__,

        'components' => [
            'db'   => [
                'class' => 'yii\db\Connection',
                'dsn'   => 'sqlite:' . __DIR__ . '/.db',
                'charset' => 'utf8',
            ],
            'cart' => [
                'class' => 'skamenetskiy\yii\cart\Cart',
            ]
        ]
    ]
);