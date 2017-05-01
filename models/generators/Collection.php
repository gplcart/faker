<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Language as LanguageModel,
    gplcart\core\models\Collection as CollectionModel;
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
     * Language model instance
     * @var \gplcart\core\models\Language $language
     */
    protected $language;

    /**
     * @param LanguageModel $language
     * @param CollectionModel $collection
     */
    public function __construct(LanguageModel $language,
            CollectionModel $collection)
    {
        parent::__construct();

        $this->language = $language;
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
