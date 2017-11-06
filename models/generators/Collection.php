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
use gplcart\core\models\Collection as CollectionModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to collections
 */
class Collection extends FakerModuleGenerator
{

    /**
     * Collection model class instance
     * @var \gplcart\core\models\Collection $collection
     */
    protected $collection;

    /**
     * @param Config $config
     * @param Library $library
     * @param LanguageModel $language
     * @param UserModel $user
     * @param FileModel $file
     * @param StoreModel $store
     * @param AliasModel $alias
     * @param CategoryModel $category
     * @param CollectionModel $collection
     */
    public function __construct(Config $config, Library $library, LanguageModel $language,
            UserModel $user, FileModel $file, StoreModel $store, AliasModel $alias,
            CategoryModel $category, CollectionModel $collection)
    {
        parent::__construct($config, $library, $language, $user, $file, $store, $alias, $category);

        $this->collection = $collection;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('Collection');
    }

    /**
     * Generate a single collection
     * @return bool
     */
    public function create()
    {
        $types = $this->collection->getTypes();

        $data = array(
            'type' => array_rand($types),
            'title' => $this->faker->text(50),
            'store_id' => $this->getStoreId(),
            'status' => $this->faker->boolean(),
            'description' => $this->faker->text(200)
        );

        return (bool) $this->collection->add($data);
    }

}
