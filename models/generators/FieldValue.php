<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Field as FieldModel,
    gplcart\core\models\FieldValue as FieldValueModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to field values
 */
class FieldValue extends FakerModuleGenerator
{

    /**
     * Field model class instance
     * @var \gplcart\core\models\Field $field
     */
    protected $field;

    /**
     * Field value model class instance
     * @var \gplcart\core\models\FieldValue $field_value
     */
    protected $field_value;

    /**
     * @param FieldModel $field
     * @param FieldValueModel $field_value
     */
    public function __construct(FieldModel $field, FieldValueModel $field_value)
    {
        parent::__construct();

        $this->field = $field;
        $this->field_value = $field_value;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->translation->text('Field value');
    }

    /**
     * Generate a single field value
     * @return bool
     */
    public function create()
    {
        $images = $this->getImages();
        $image = $images[array_rand($images)];

        $data = array(
            'path' => $image['path'],
            'title' => $this->faker->text(50),
            'field_id' => $this->getFieldId(),
            'color' => $this->faker->hexcolor(),
            'weight' => $this->faker->numberBetween(0, 20)
        );

        return (bool) $this->field_value->add($data);
    }

    /**
     * Returns a random field ID
     * @return integer
     */
    protected function getFieldId()
    {
        static $data = null;

        if (!isset($data)) {
            $data = $this->field->getList(array('limit' => array(0, 100)));
        }

        return array_rand($data);
    }

}
