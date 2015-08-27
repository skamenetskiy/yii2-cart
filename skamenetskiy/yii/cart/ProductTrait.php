<?php
/**
 * Created by Semen Kamenetskiy.
 * Date: 26/08/15
 */

namespace skamenetskiy\yii\cart;

/**
 * Class Product
 *
 * @package skamenetskiy\yii\cart
 *
 * @method getId
 * @method getPrice
 * @method getName
 */
trait ProductTrait
{

    /**
     * @var int
     */
    protected $quantity = 0;

    /**
     * Sets product quantity
     *
     * @param $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * Returns product quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Returns the total price of a product
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->getPrice() * $this->getQuantity();
    }

}