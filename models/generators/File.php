<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Language as LanguageModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to files
 */
class File extends FakerModuleGenerator
{

    /**
     * Language model instance
     * @var \gplcart\core\models\Language $language
     */
    protected $language;

    /**
     * @param LanguageModel $language
     */
    public function __construct(LanguageModel $language)
    {
        parent::__construct();

        $this->language = $language;
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
        $directory = GC_UPLOAD_DIR . '/faker';

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
