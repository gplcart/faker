<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Page as PageModel,
    gplcart\core\models\Product as ProductModel,
    gplcart\core\models\Language as LanguageModel,
    gplcart\core\models\Collection as CollectionModel,
    gplcart\core\models\CollectionItem as CollectionItemModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to collection items
 */
class CollectionItem extends FakerModuleGenerator
{

    /**
     * Product model class instance
     * @var \gplcart\core\models\Product $product
     */
    protected $product;

    /**
     * Page model class instance
     * @var \gplcart\core\models\Page $page
     */
    protected $page;

    /**
     * Collection model class instance
     * @var \gplcart\core\models\Collection $collection
     */
    protected $collection;

    /**
     * Collection item model class instance
     * @var \gplcart\core\models\CollectionItem $collection_item
     */
    protected $collection_item;

    /**
     * Language model instance
     * @var \gplcart\core\models\Language $language
     */
    protected $language;

    /**
     * @param LanguageModel $language
     * @param CollectionModel $collection
     * @param CollectionItemModel $collection_item
     * @param ProductModel $product
     * @param PageModel $page
     */
    public function __construct(LanguageModel $language,
            CollectionModel $collection, CollectionItemModel $collection_item,
            ProductModel $product, PageModel $page)
    {
        parent::__construct();

        $this->page = $page;
        $this->product = $product;
        $this->language = $language;
        $this->collection = $collection;
        $this->collection_item = $collection_item;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('Collection item');
    }

    /**
     * Generate a single collection
     * @return bool
     */
    public function create()
    {
        $collection = $this->getCollection();

        if (empty($collection)) {
            return false;
        }

        $data = array(
            'status' => $this->faker->boolean(),
            'value' => $this->getEntityId($collection),
            'collection_id' => $collection['collection_id'],
            'weight' => $this->faker->numberBetween(0, 20)
        );

        return (bool) $this->collection_item->add($data);
    }

    /**
     * Returns a random entity ID
     * @staticvar array|null $items
     * @param array $collection
     * @return integer
     */
    protected function getEntityId(array $collection)
    {
        static $items = array();
        if (!isset($items[$collection['type']])) {
            $options = array('limit' => array(0, 100));
            switch ($collection['type']) {
                case 'page':
                    $items[$collection['type']] = $this->page->getList($options);
                    break;
                case 'product':
                    $items[$collection['type']] = $this->product->getList($options);
                    break;
                case 'file':
                    $items[$collection['type']] = $this->file->getList($options);
                    break;
            }
        }

        if (empty($items[$collection['type']])) {
            return 0;
        }

        return (int) array_rand($items[$collection['type']]);
    }

    /**
     * Returns a random collection
     * @staticvar array|null $collections
     * @return array
     */
    protected function getCollection()
    {
        static $collections = null;
        if (!isset($collections)) {
            $collections = $this->collection->getList(array('limit' => array(0, 100)));
        }
        return $collections[array_rand($collections)];
    }

}
