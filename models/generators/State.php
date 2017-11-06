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
use gplcart\core\models\Zone as ZoneModel,
    gplcart\core\models\State as StateModel,
    gplcart\core\models\Country as CountryModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to country states
 */
class State extends FakerModuleGenerator
{

    /**
     * Zone model class instance
     * @var \gplcart\core\models\Zone $zone
     */
    protected $zone;

    /**
     * State model class instance
     * @var \gplcart\core\models\State $state
     */
    protected $state;

    /**
     * Country model class instance
     * @var \gplcart\core\models\Country $country
     */
    protected $country;

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
     * @param StateModel $state
     * @param CountryModel $country
     */
    public function __construct(Config $config, Library $library, LanguageModel $language,
            UserModel $user, FileModel $file, StoreModel $store, AliasModel $alias,
            CategoryModel $category, ZoneModel $zone, StateModel $state, CountryModel $country)
    {
        parent::__construct($config, $library, $language, $user, $file, $store, $alias, $category);

        $this->zone = $zone;
        $this->state = $state;
        $this->country = $country;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('State');
    }

    /**
     * Generate a single country state
     * @return bool
     */
    public function create()
    {
        $data = array(
            'name' => $this->faker->state(),
            'zone_id' => $this->getZoneId(),
            'status' => $this->faker->boolean(),
            'code' => $this->faker->stateAbbr(),
            'country' => $this->getCountryCode()
        );

        return (bool) $this->state->add($data);
    }

    /**
     * Returns a random country code
     * @return string
     */
    protected function getCountryCode()
    {
        $countries = $this->country->getList(array('limit' => array(0, 100)));
        return array_rand($countries);
    }

    /**
     * Returns a random zone ID
     * @staticvar array|null $zones
     * @return integer
     */
    protected function getZoneId()
    {
        static $zones = null;
        if (!isset($zones)) {
            $zones = $this->zone->getList(array('limit' => array(0, 100)));
        }
        return (int) array_rand($zones);
    }

}
