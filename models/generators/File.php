<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to files
 */
class File extends FakerModuleGenerator
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->translation->text('File');
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
            'entity' => '',
            'entity_id' => '',
            'title' => $this->faker->text(50),
            'description' => $this->faker->text(100),
            'weight' => $this->faker->numberBetween(0, 20),
            'path' => str_replace('\\', '/', gplcart_file_relative($image))
        );

        return (bool) $this->file->add($field);
    }

}
