<?php
/**
 * Created by Semen Kamenetskiy.
 * Date: 26/08/15
 */

use skamenetskiy\yii\cart\ProductInterface;
use skamenetskiy\yii\cart\ProductTrait;
use yii\db\ActiveRecord;


/**
 * Class ProductExample
 *
 * @property int    id
 * @property float  price
 * @property string name
 */
class ProductExample
    extends ActiveRecord
    implements ProductInterface
{

    use ProductTrait;

    public static function tableName()
    {
        return 'product';
    }

    /**
     * Returns unique product id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns product price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Returns product name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}