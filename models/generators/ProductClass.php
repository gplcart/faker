<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Field as FieldModel,
    gplcart\core\models\ProductClass as ProductClassModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to product classes
 */
class ProductClass extends FakerModuleGenerator
{

    /**
     * Field model instance
     * @var \gplcart\core\models\Field $field
     */
    protected $field;

    /**
     * Product class model instance
     * @var \gplcart\core\models\ProductClass $product_class
     */
    protected $product_class;

    /**
     * @param ProductClassModel $product_class
     * @param FieldModel $field
     */
    public function __construct(ProductClassModel $product_class, FieldModel $field)
    {
        parent::__construct();

        $this->field = $field;
        $this->product_class = $product_class;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->translation->text('Product class');
    }

    /**
     * Generate a single product class
     * @return bool
     */
    public function create()
    {
        $class = array(
            'title' => $this->faker->text(50),
            'status' => $this->faker->boolean()
        );

        $product_class_id = $this->product_class->add($class);

        if (empty($product_class_id)) {
            return false;
        }

        foreach ($this->getFields() as $field_id) {
            $field = array(
                'field_id' => $field_id,
                'required' => $this->faker->boolean(),
                'multiple' => $this->faker->boolean(),
                'product_class_id' => $product_class_id,
                'weight' => $this->faker->numberBetween(0, 20)
            );

            $this->product_class->addField($field);
        }

        return true;
    }

    /**
     * Returns a random array of field IDs
     * @return array
     */
    protected function getFields()
    {
        static $fields = null;

        if (!isset($fields)) {
            $fields = $this->field->getList(array('limit' => array(0, 300)));
        }

        if (empty($fields)) {
            return array();
        }

        $limit = $this->config->get('module_faker_product_class_field_limit', 20);
        $chunk = array_slice($this->faker->shuffle($fields), 0, $limit, true);
        return array_keys($chunk);
    }

}
