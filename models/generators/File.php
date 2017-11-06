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
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to files
 */
class File extends FakerModuleGenerator
{

    /**
     * @param Config $config
     * @param Library $library
     * @param LanguageModel $language
     * @param UserModel $user
     * @param FileModel $file
     * @param StoreModel $store
     * @param AliasModel $alias
     * @param CategoryModel $category
     */
    public function __construct(Config $config, Library $library, LanguageModel $language,
            UserModel $user, FileModel $file, StoreModel $store, AliasModel $alias,
            CategoryModel $category)
    {
        parent::__construct($config, $library, $language, $user, $file, $store, $alias, $category);
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('File');
    }

    /**
     * Generate a single file
     * @return bool
     */
    public function create()
    {
        $directory = GC_DIR_UPLOAD . '/faker';

        if (!file_exists($directory) && !mkdir($directory, 0775)) {
            return false;
        }

        $topics = (array) $this->config->get('module_faker_image_topics', array('abstract', 'technics'));
        $image = $this->faker->image($directory, 500, 500, $topics[array_rand($topics)], true);

        $field = array(
            'id_key' => '',
            'id_value' => '',
            'title' => $this->faker->text(50),
            'description' => $this->faker->text(100),
            'weight' => $this->faker->numberBetween(0, 20),
            'path' => str_replace('\\', '/', $this->file->path($image))
        );

        return (bool) $this->file->add($field);
    }

}
