<?php
/**
 * Created by Semen Kamenetskiy.
 * Date: 26/08/15
 */

namespace skamenetskiy\yii\cart;

/**
 * Interface ProductInterface
 *
 * @package skamenetskiy\yii\cart
 */
interface ProductInterface
{

    /**
     * Returns unique product id
     *
     * @return int
     */
    public function getId();

    /**
     * Returns product price
     *
     * @return float
     */
    public function getPrice();

    /**
     * Returns product name
     *
     * @return string
     */
    public function getName();

}