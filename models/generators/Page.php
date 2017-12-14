<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models\generators;

use gplcart\core\models\Page as PageModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to pages
 */
class Page extends FakerModuleGenerator
{

    /**
     * Page model class instance
     * @var \gplcart\core\models\Page $page
     */
    protected $page;

    /**
     * @param PageModel $page
     */
    public function __construct(PageModel $page)
    {
        parent::__construct();

        $this->page = $page;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->translation->text('Page');
    }

    /**
     * Generate a single page
     * @return bool
     */
    public function create()
    {
        $page = array(
            'user_id' => $this->getUserId(),
            'store_id' => $this->getStoreId(),
            'title' => $this->faker->text(100),
            'status' => $this->faker->boolean(),
            'description' => $this->faker->text(1000),
            'category_id' => $this->getCategoryId('catalog'),
            'meta_title' => $this->faker->text(60),
            'meta_description' => $this->faker->text(160),
            'alias' => $this->getAlias(),
            'images' => $this->getImages()
        );

        return (bool) $this->page->add($page);
    }

}
