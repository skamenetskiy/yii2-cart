<?php
/**
 * Created by Semen Kamenetskiy.
 * Date: 27/08/15
 */

namespace skamenetskiy\yii\cart;

use yii\db\ActiveRecord;

/**
 * Class CartModel
 *
 * @package skamenetskiy\yii\cart
 *
 * @property mixed id
 * @property Cart  data
 */
class CartModel
    extends ActiveRecord
{

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'cart';
    }

}