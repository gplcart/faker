<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker;

use gplcart\core\Module;

/**
 * Main class for Faker module
 */
class Main
{

    /**
     * Module class instance
     * @var \gplcart\core\Module $module
     */
    protected $module;

    /**
     * @param Module $module
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * Implements hook "library.list"
     * @param array $libraries
     */
    public function hookLibraryList(array &$libraries)
    {
        $libraries['faker'] = array(
            'name' => 'Faker',
            'description' => 'Faker is a PHP library that generates fake data for you',
            'url' => 'https://github.com/fzaninotto/Faker',
            'download' => 'https://github.com/fzaninotto/Faker/archive/v1.6.0.zip',
            'type' => 'php',
            'version' => '1.6.0',
            'module' => 'faker',
            'vendor' => 'fzaninotto/faker'
        );
    }

    /**
     * Implements hook "route.list"
     * @param mixed $routes
     */
    public function hookRouteList(&$routes)
    {
        $routes['admin/tool/faker'] = array(
            'menu' => array('admin' => 'Generate fake content'),
            'access' => 'module_faker_generate',
            'handlers' => array(
                'controller' => array('gplcart\\modules\\faker\\controllers\\Generator', 'editGenerator')
            )
        );
    }

    /**
     * Implements hook "user.role.permissions"
     * @param array $permissions
     */
    public function hookUserRolePermissions(array &$permissions)
    {
        $permissions['module_faker_generate'] = 'Faker: generate content';
    }

}
