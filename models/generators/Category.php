<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Language as LanguageModel,
    gplcart\core\models\CategoryGroup as CategoryGroupModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to categories
 */
class Category extends FakerModuleGenerator
{

    /**
     * Category group model class instance
     * @var \gplcart\core\models\CategoryGroup $category_group
     */
    protected $category_group;

    /**
     * Language model instance
     * @var \gplcart\core\models\Language $language
     */
    protected $language;

    /**
     * @param CategoryGroupModel $category_group
     * @param LanguageModel $language
     */
    public function __construct(CategoryGroupModel $category_group,
            LanguageModel $language)
    {
        parent::__construct();

        $this->language = $language;
        $this->category_group = $category_group;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('Category');
    }

    /**
     * Generate a single page
     * @return bool
     */
    public function create()
    {
        $group = $this->getCategoryGroup();

        $category = array(
            'weight' => $this->faker->numberBetween(0, 20),
            'user_id' => $this->getUserId(),
            'title' => $this->faker->text(100),
            'status' => $this->faker->boolean(),
            'description_1' => $this->faker->text(1000),
            'description_2' => $this->faker->text(1000),
            'parent_id' => $this->getCategoryId($group['type']),
            'category_group_id' => $group['category_group_id'],
            'meta_title' => $this->faker->text(60),
            'meta_description' => $this->faker->text(160),
            'alias' => $this->getAlias(),
            'images' => $this->getImages()
        );

        return (bool) $this->category->add($category);
    }

    /**
     * Returns a random category group
     * @return array
     */
    protected function getCategoryGroup()
    {
        static $groups = null;

        if (!isset($groups)) {
            $groups = $this->category_group->getList(array('limit' => array(0, 100)));
        }

        return $groups[array_rand($groups)];
    }

}
