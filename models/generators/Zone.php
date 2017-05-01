<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Zone as ZoneModel,
    gplcart\core\models\Language as LanguageModel;
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
     * Language model instance
     * @var \gplcart\core\models\Language $language
     */
    protected $language;

    /**
     * @param ZoneModel $zone
     * @param LanguageModel $language
     */
    public function __construct(ZoneModel $zone, LanguageModel $language)
    {
        parent::__construct();

        $this->zone = $zone;
        $this->language = $language;
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
