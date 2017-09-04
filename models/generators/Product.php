<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Product as ProductModel,
    gplcart\core\models\Language as LanguageModel,
    gplcart\core\models\ProductClass as ProductClassModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to products
 */
class Product extends FakerModuleGenerator
{

    /**
     * Product model class instance
     * @var \gplcart\core\models\Product $product
     */
    protected $product;

    /**
     * Product model class instance
     * @var \gplcart\core\models\ProductClass $product_class
     */
    protected $product_class;

    /**
     * Language model instance
     * @var \gplcart\core\models\Language $language
     */
    protected $language;

    /**
     * @param ProductModel $product
     * @param ProductClassModel $product_class
     * @param LanguageModel $language
     */
    public function __construct(ProductModel $product,
            ProductClassModel $product_class, LanguageModel $language)
    {
        parent::__construct();

        $this->product = $product;
        $this->language = $language;
        $this->product_class = $product_class;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('Product');
    }

    /**
     * Generate a single product
     * @return bool
     */
    public function create()
    {
        $size_units = $this->product->getSizeUnits();
        $weight_units = $this->product->getWeightUnits();

        $product = array(
            'user_id' => $this->getUserId(),
            'store_id' => $this->getStoreId(),
            'title' => $this->faker->text(100),
            'description' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->boolean(),
            'subtract' => $this->faker->boolean(),
            'sku' => strtoupper($this->faker->word()),
            'stock' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->numberBetween(1, 1000),
            'product_class_id' => $this->getProductClassId(),
            'brand_category_id' => $this->getCategoryId('brand'),
            'category_id' => $this->getCategoryId('catalog'),
            'length' => $this->faker->numberBetween(1, 100),
            'width' => $this->faker->numberBetween(1, 100),
            'height' => $this->faker->numberBetween(1, 100),
            'weight' => $this->faker->numberBetween(1, 100),
            'size_unit' => array_rand($size_units),
            'weight_unit' => array_rand($weight_units),
            'meta_title' => $this->faker->text(60),
            'meta_description' => $this->faker->text(160),
            'alias' => $this->getAlias(),
            'images' => $this->getImages(),
        );

        return (bool) $this->product->add($product);
    }

    /**
     * Returns a random product class ID
     * @return integer
     */
    protected function getProductClassId()
    {
        static $classes = null;

        if (!isset($classes)) {
            $classes = $this->product_class->getList(array('limit' => array(0, 100)));
        }

        return array_rand($classes);
    }

}
