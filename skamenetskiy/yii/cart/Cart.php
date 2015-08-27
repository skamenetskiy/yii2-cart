<?php
/**
 * Created by Semen Kamenetskiy.
 * Date: 26/08/15
 */

namespace skamenetskiy\yii\cart;

use yii\base\Component;
use yii\di\Instance;
use yii\web\Session;

/**
 * Class Cart
 *
 * @package skamenetskiy\yii\cart
 */
class Cart
    extends Component
{

    const OPTION_STORE_SESSION = 'session';
    const OPTION_STORE_DATABASE = 'database';
    const OPTION_STORE_CACHE_MEMCACHED = 'memcached';

    /**
     * Cart id. For database and memcached storage types, it has to be unique.
     *
     * @var string
     */
    public $id = 'default_cart_id';

    /**
     * @var string
     */
    public $storage = self::OPTION_STORE_SESSION;

    /**
     * @var bool
     */
    public $initialize = true;

    /**
     * @var ProductInterface[]|ProductTrait[]
     */
    protected $products = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var null
     */
    private static $session = null;

    /**
     * @var CartModel
     */
    private static $db = null;

    /**
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    protected static function getSession()
    {
        if (is_null(static::$session)) {
            static::$session = Instance::ensure(static::$session, Session::className());
        }
        return static::$session;
    }

    /**
     * @param $id
     *
     * @return CartModel
     */
    protected static function getDb($id)
    {
        if (is_null(static::$db)) {
            static::$db = CartModel::findOne(['id' => $id]);
        }
        if (is_null(static::$db)) {
            static::$db = new CartModel;
            static::$db->id = $id;
        }
        return static::$db;
    }

    /**
     * Initializer
     */
    public function init()
    {
        if ($this->initialize) {
            $this->load();
        }
    }

    /**
     * Load data from storage
     *
     * @return $this
     */
    protected function load()
    {
        switch ($this->storage) {
            case self::OPTION_STORE_SESSION:
                if (isset(static::getSession()[$this->id])) {
                    $this->setSerialized(static::getSession()[$this->id]);
                }
                break;
            case self::OPTION_STORE_DATABASE:
                if (!is_null(static::getDb($this->id)->data)) {
                    $this->setSerialized(static::getDb($this->id)->data);
                }
                break;
            case self::OPTION_STORE_CACHE_MEMCACHED:

                break;
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function save()
    {
        switch ($this->storage) {
            case self::OPTION_STORE_SESSION:
                static::getSession()[$this->id] = $this->getSerialized();
                break;
            case self::OPTION_STORE_DATABASE:
                static::getDb($this->id)->data = $this->getSerialized();
                static::getDb($this->id)->save();
                break;
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function getSerialized()
    {
        $serializedObject = new \stdClass;
        $serializedObject->products = $this->products;
        $serializedObject->options = $this->options;
        return serialize($serializedObject);
    }

    /**
     * @param $serialized
     *
     * @return Cart
     */
    protected function setSerialized($serialized)
    {
        $unserializedObject = unserialize($serialized);
        if ($unserializedObject instanceof \stdClass) {
            if (isset($unserializedObject->products)) {
                $this->products = $unserializedObject->products;
            }
            if (isset($unserializedObject->options)) {
                $this->options = $unserializedObject->options;
            }
        }
        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return Cart
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getOption($key)
    {
        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }
        return null;
    }

    /**
     * @param ProductInterface $product
     *
     * @return Cart
     */
    public function add(ProductInterface $product)
    {
        /** @var ProductInterface|ProductTrait $product */
        if (array_key_exists($product->getId(), $this->products)) {
            $this->products[$product->getId()]->setQuantity(
                $this->products[$product->getId()]->getQuantity() + $product->getQuantity()
            );
        } else {
            $this->products[$product->getId()] = $product;
        }
        return $this->save();
    }

    /**
     * @param $productId
     *
     * @return bool
     */
    public function has($productId)
    {
        return array_key_exists($productId, $this->products);
    }

    /**
     * @param $productId
     *
     * @return null|ProductInterface|ProductTrait
     */
    public function get($productId)
    {
        if ($this->has($productId)) {
            return $this->products[$productId];
        }
        return null;
    }

    /**
     * @param $productId
     *
     * @return bool
     */
    public function delete($productId)
    {
        if ($this->has($productId)) {
            unset($this->products[$productId]);
            return true;
        }
        return false;
    }

    /**
     * @param $productId
     * @param $quantity
     *
     * @return bool
     */
    public function setQuantity($productId, $quantity)
    {
        if ($this->has($productId)) {
            $this->get($productId)->setQuantity($quantity);
            return true;
        }
        return false;
    }

    /**
     * @param $productId
     *
     * @return int
     */
    public function getQuantity($productId)
    {
        if ($this->has($productId)) {
            return $this->get($productId)->getQuantity();
        }
        return 0;
    }

}