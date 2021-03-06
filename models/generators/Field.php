<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Field as FieldModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to fields
 */
class Field extends FakerModuleGenerator
{

    /**
     * Field model class instance
     * @var \gplcart\core\models\Field $field
     */
    protected $field;

    /**
     * @param FieldModel $field
     */
    public function __construct(FieldModel $field)
    {
        parent::__construct();

        $this->field = $field;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->translation->text('Field');
    }

    /**
     * Generate a single field
     * @return bool
     */
    public function create()
    {
        $types = $this->field->getTypes();
        $widgets = $this->field->getWidgetTypes();

        $field = array(
            'type' => array_rand($types),
            'widget' => array_rand($widgets),
            'title' => $this->faker->text(50),
            'weight' => $this->faker->numberBetween(0, 20)
        );

        return (bool) $this->field->add($field);
    }

}
