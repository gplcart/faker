<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

// Parent
use gplcart\core\Config,
    gplcart\core\Library;
use gplcart\core\models\User as UserModel,
    gplcart\core\models\File as FileModel,
    gplcart\core\models\Store as StoreModel,
    gplcart\core\models\Alias as AliasModel,
    gplcart\core\models\Category as CategoryModel,
    gplcart\core\models\Language as LanguageModel;
// New
use gplcart\core\models\Review as ReviewModel,
    gplcart\core\models\Product as ProductModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to reviews
 */
class Review extends FakerModuleGenerator
{

    /**
     * Review model instance
     * @var \gplcart\core\models\Review $review
     */
    protected $review;

    /**
     * Product model instance
     * @var \gplcart\core\models\Product $product
     */
    protected $product;

    /**
     * @param Config $config
     * @param Library $library
     * @param LanguageModel $language
     * @param UserModel $user
     * @param FileModel $file
     * @param StoreModel $store
     * @param AliasModel $alias
     * @param CategoryModel $category
     * @param ReviewModel $review
     * @param ProductModel $product
     */
    public function __construct(Config $config, Library $library, LanguageModel $language,
            UserModel $user, FileModel $file, StoreModel $store, AliasModel $alias,
            CategoryModel $category, ReviewModel $review, ProductModel $product)
    {
        parent::__construct($config, $library, $language, $user, $file, $store, $alias, $category);

        $this->review = $review;
        $this->product = $product;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('Review');
    }

    /**
     * Generate a single review
     * @return bool
     */
    public function create()
    {
        $created = $this->faker->dateTimeBetween('-1 year')->getTimestamp();

        $data = array(
            'created' => $created,
            'modified' => $created + 86400,
            'user_id' => $this->getUserId(),
            'text' => $this->faker->text(1000),
            'status' => $this->faker->boolean(),
            'product_id' => $this->getProductId()
        );

        return (bool) $this->review->add($data);
    }

    /**
     * Get a random product ID
     * @staticvar array|null $products
     * @return integer
     */
    protected function getProductId()
    {
        static $products = null;
        if (!isset($products)) {
            $products = $this->product->getList(array('limit' => array(0, 100)));
        }
        return (int) array_rand($products);
    }

}
