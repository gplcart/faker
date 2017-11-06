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
use gplcart\core\models\Zone as ZoneModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to geo zones
 */
class Zone extends FakerModuleGenerator
{

    /**
     * Zone model class instance
     * @var \gplcart\core\models\Zone $zone
     */
    protected $zone;

    /**
     * @param Config $config
     * @param Library $library
     * @param LanguageModel $language
     * @param UserModel $user
     * @param FileModel $file
     * @param StoreModel $store
     * @param AliasModel $alias
     * @param CategoryModel $category
     * @param ZoneModel $zone
     */
    public function __construct(Config $config, Library $library, LanguageModel $language,
            UserModel $user, FileModel $file, StoreModel $store, AliasModel $alias,
            CategoryModel $category, ZoneModel $zone)
    {
        parent::__construct($config, $library, $language, $user, $file, $store, $alias, $category);

        $this->zone = $zone;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('Zone');
    }

    /**
     * Generate a single zone
     * @return bool
     */
    public function create()
    {
        $data = array(
            'status' => $this->faker->boolean(),
            'title' => $this->faker->country() . ', ' . $this->faker->state()
        );
        return (bool) $this->zone->add($data);
    }

}
