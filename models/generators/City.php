<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\City as CityModel,
    gplcart\core\models\State as StateModel,
    gplcart\core\models\Language as LanguageModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to cities
 */
class City extends FakerModuleGenerator
{

    /**
     * City model class instance
     * @var \gplcart\core\models\City $city
     */
    protected $city;

    /**
     * State model class instance
     * @var \gplcart\core\models\State $state
     */
    protected $state;

    /**
     * Language model instance
     * @var \gplcart\core\models\Language $language
     */
    protected $language;

    /**
     * @param CityModel $city
     * @param StateModel $state
     * @param LanguageModel $language
     */
    public function __construct(CityModel $city, StateModel $state,
            LanguageModel $language)
    {
        parent::__construct();

        $this->city = $city;
        $this->state = $state;
        $this->language = $language;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('City');
    }

    /**
     * Generate a single city
     * @return bool
     */
    public function create()
    {
        $state = $this->getState();

        if (empty($state)) {
            return false;
        }

        $data = array(
            'name' => $this->faker->city(),
            'country' => $state['country'],
            'zone_id' => $state['zone_id'],
            'state_id' => $state['state_id'],
            'status' => $this->faker->boolean(),
        );

        return (bool) $this->city->add($data);
    }

    /**
     * Returns a random state
     * @staticvar array $states
     * @return array
     */
    protected function getState()
    {
        static $states = null;
        if (!isset($states)) {
            $states = $this->state->getList(array('limit' => array(0, 300)));
        }
        return $states[array_rand($states)];
    }

}
