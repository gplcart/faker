<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @author Skeleton https://github.com/gplcart/skeleton
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\controllers;

use gplcart\modules\faker\models\Generator as FakerModuleGenerator;
use gplcart\core\controllers\backend\Controller as BackendController;

/**
 * Handles incoming requests and outputs data related to Faker module
 */
class Generator extends BackendController
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Route page callback to display the generator page
     */
    public function editGenerator()
    {
        $this->setTitleEditGenerator();
        $this->setBreadcrumbEditGenerator();

        $this->setData('generators', $this->getListGenerator());

        $this->submitGenerator();
        $this->outputEditGenerator();
    }

    /**
     * Returns an array of generator names
     * @return array
     */
    protected function getListGenerator()
    {
        $list = array();

        foreach (FakerModuleGenerator::getList() as $id => $model) {
            $list[$id] = $model->getName();
        }

        return gplcart_array_split($list, 4);
    }

    /**
     * Handles submitted data
     */
    protected function submitGenerator()
    {
        $entity = $this->getPosted('generate', null, true, 'string');

        if (empty($entity)) {
            return null;
        }

        $generator = FakerModuleGenerator::get($entity);

        if (empty($generator)) {
            return null;
        }

        $limit = $this->config("module_faker_{$entity}_limit", 20);
        $result = $generator->generate($limit);

        if (empty($result)) {
            $this->redirect('', $this->text('Content has not been generated'), 'warning');
        }

        $this->redirect('', $this->text('Generated @num entities', array('@num' => $result)), 'success');
    }

    /**
     * Set titles on the generator page
     */
    protected function setTitleEditGenerator()
    {
        $this->setBreadcrumbHome();
    }

    /**
     * Set breadcrumbs on the generator page
     */
    protected function setBreadcrumbEditGenerator()
    {
        $this->setTitle($this->text('Generate content'));
    }

    /**
     * Render and output the generator page
     */
    protected function outputEditGenerator()
    {
        $this->output('faker|generator');
    }

}
