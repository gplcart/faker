<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\City as CityModel,
    gplcart\core\models\Address as AddressModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to addresses
 */
class Address extends FakerModuleGenerator
{

    /**
     * City model class instance
     * @var \gplcart\core\models\City $city
     */
    protected $city;

    /**
     * Address model class instance
     * @var \gplcart\core\models\Address $address
     */
    protected $address;

    /**
     * @param CityModel $city
     * @param AddressModel $address
     */
    public function __construct(CityModel $city, AddressModel $address)
    {
        parent::__construct();

        $this->city = $city;
        $this->address = $address;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->translation->text('Address');
    }

    /**
     * Generate a single address
     * @return bool
     */
    public function create()
    {
        $city = $this->getCity();

        if (empty($city)) {
            return false;
        }

        $types = $this->address->getTypes();

        $data = array(
            'state_id' => $city['state_id'],
            'country' => $city['country'],
            'city_id' => $city['city_id'],
            'address_1' => $this->faker->address(),
            'address_2' => $this->faker->secondaryAddress(),
            'phone' => $this->faker->phoneNumber(),
            'type' => $types[array_rand($types)],
            'user_id' => $this->getUserId(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'postcode' => $this->faker->postcode(),
            'company' => $this->faker->company(),
            'fax' => $this->faker->tollFreePhoneNumber(),
            'created' => $this->faker->dateTimeBetween('-1 year')->getTimestamp()
        );

        return (bool) $this->address->add($data);
    }

    /**
     * Returns a random city
     * @staticvar array $cities
     * @return array
     */
    protected function getCity()
    {
        static $cities = null;
        if (!isset($cities)) {
            $cities = $this->city->getList(array('limit' => array(0, 300)));
        }
        return $cities[array_rand($cities)];
    }

}
