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
     * @param Config $config
     * @param Library $library
     * @param LanguageModel $language
     * @param UserModel $user
     * @param FileModel $file
     * @param StoreModel $store
     * @param AliasModel $alias
     * @param CategoryModel $category
     * @param FieldModel $field
     * @param FieldValueModel $field_value
     */
    public function __construct(Config $config, Library $library, LanguageModel $language,
            UserModel $user, FileModel $file, StoreModel $store, AliasModel $alias,
            CategoryModel $category, FieldModel $field, FieldValueModel $field_value)
    {
        parent::__construct($config, $library, $language, $user, $file, $store, $alias, $category);

        $this->field = $field;
        $this->field_value = $field_value;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('Field value');
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
