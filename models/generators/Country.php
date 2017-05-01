<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Zone as ZoneModel,
    gplcart\core\models\Country as CountryModel,
    gplcart\core\models\Language as LanguageModel;
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
     * Language model instance
     * @var \gplcart\core\models\Language $language
     */
    protected $language;

    /**
     * @param ZoneModel $zone
     * @param CountryModel $country
     * @param LanguageModel $language
     */
    public function __construct(ZoneModel $zone, CountryModel $country,
            LanguageModel $language)
    {
        parent::__construct();

        $this->zone = $zone;
        $this->country = $country;
        $this->language = $language;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('Country');
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
            'name' => $countries[$code],
            'format' => $this->getFormat(),
            'zone_id' => $this->getZoneId(),
            'native_name' => $countries[$code],
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
                } else if ($key == 'weight') {
                    $value = $this->faker->numberBetween(0, 20);
                }
            }
        }
        return $format;
    }

    /**
     * Return a random zone ID
     * @staticvar array|null $zones
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
