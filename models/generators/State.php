<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

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
     * @param ZoneModel $zone
     * @param StateModel $state
     * @param CountryModel $country
     */
    public function __construct(ZoneModel $zone, StateModel $state, CountryModel $country)
    {
        parent::__construct();

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
        return $this->translation->text('State');
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
