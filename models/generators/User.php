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
use gplcart\core\models\UserRole as UserRoleModel;
use gplcart\modules\faker\models\Generator as FakerModuleGenerator;

/**
 * Manages basic behaviors and data related to users
 */
class User extends FakerModuleGenerator
{

    /**
     * User role model class instance
     * @var \gplcart\core\models\UserRole $user_role
     */
    protected $user_role;

    /**
     * @param Config $config
     * @param Library $library
     * @param LanguageModel $language
     * @param UserModel $user
     * @param FileModel $file
     * @param StoreModel $store
     * @param AliasModel $alias
     * @param CategoryModel $category
     * @param UserRoleModel $user_role
     */
    public function __construct(Config $config, Library $library, LanguageModel $language,
            UserModel $user, FileModel $file, StoreModel $store, AliasModel $alias,
            CategoryModel $category, UserRoleModel $user_role)
    {
        parent::__construct($config, $library, $language, $user, $file, $store, $alias, $category);

        $this->user_role = $user_role;
    }

    /**
     * Returns the generator name
     * @return string
     */
    public function getName()
    {
        return $this->language->text('User');
    }

    /**
     * Returns a random role ID
     * @return integer
     */
    protected function getRoleId()
    {
        static $roles = null;
        if (!isset($roles)) {
            $roles = $this->user_role->getList(array('limit' => array(0, 100)));
        }
        return array_rand($roles);
    }

    /**
     * Generate a single user
     * @return bool
     */
    public function create()
    {
        $user = array(
            'name' => $this->faker->name(),
            'role_id' => $this->getRoleId(),
            'email' => $this->faker->email(),
            'store_id' => $this->getStoreId(),
            'status' => $this->faker->boolean(),
            'password' => $this->faker->password()
        );

        return (bool) $this->user->add($user);
    }

}
