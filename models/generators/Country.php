<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Zone as ZoneModel,
    gplcart\core\models\Country as CountryModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to countries
 */
class Country extends FakerModuleGenerator
{

    /**
     * Zone model class instance
     * @var \gplcart\core\models\Zone $zone
     */
    protected $zone;

    /**
     * Country model class instance
     * @var \gplcart\core\models\Country $country
     */
    protected $country;

    /**
     * @param ZoneModel $zone
     * @param CountryModel $country
     */
    public function __construct(ZoneModel $zone, CountryModel $country)
    {
        parent::__construct();

        $this->zone = $zone;
        $this->country = $country;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->translation->text('Country');
    }

    /**
     * Generate a single country
     * @return bool
     */
    public function create()
    {
        $countries = $this->country->getIso();
        $code = array_rand($countries);

        if ($this->country->get($code)) {
            return false;
        }

        $data = array(
            'code' => $code,
            'name' => $countries[$code]['name'],
            'format' => $this->getFormat(),
            'zone_id' => $this->getZoneId(),
            'native_name' => $countries[$code]['name'],
            'status' => $this->faker->boolean(),
            'weight' => $this->faker->numberBetween(0, 20)
        );

        return (bool) $this->country->add($data);
    }

    /**
     * Returns a random country format
     * @return array
     */
    protected function getFormat()
    {
        $format = $this->country->getDefaultFormat();
        foreach ($format as &$data) {
            foreach ($data as $key => &$value) {
                if (in_array($key, array('status', 'required'))) {
                    $value = (int) $this->faker->boolean();
                } else if ($key === 'weight') {
                    $value = $this->faker->numberBetween(0, 20);
                }
            }
        }
        return $format;
    }

    /**
     * Return a random zone ID
     * @return integer
     */
    protected function getZoneId()
    {
        static $zones = null;

        if (!isset($zones)) {
            $zones = $this->zone->getList(array('limit' => array(0, 300)));
        }

        return (int) array_rand($zones);
    }

}
