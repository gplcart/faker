<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */

namespace gplcart\modules\faker\models;

use gplcart\core\Model,
    gplcart\core\Container;

/**
 * Base class for faker generators
 */
abstract class Generator extends Model
{

    /**
     * Faker class instance
     * @var \Faker\Generator $faker
     */
    protected $faker;

    /**
     * File model class instance
     * @var \gplcart\core\models\File $file
     */
    protected $file;

    /**
     * Store model class instance
     * @var \gplcart\core\models\Store $store
     */
    protected $store;

    /**
     * User model class instance
     * @var \gplcart\core\models\User $user
     */
    protected $user;

    /**
     * Category model class instance
     * @var \gplcart\core\models\Category $category
     */
    protected $category;

    /**
     * Alias model class instance
     * @var \gplcart\core\models\Alias $alias
     */
    protected $alias;

    /**
     * Library class instance
     * @var \gplcart\core\Library
     */
    protected $library;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->library = Container::get('gplcart\\core\\Library');
        $this->user = Container::get('gplcart\\core\\models\\User');
        $this->file = Container::get('gplcart\\core\\models\\File');
        $this->store = Container::get('gplcart\\core\\models\\Store');
        $this->alias = Container::get('gplcart\\core\\models\\Alias');
        $this->category = Container::get('gplcart\\core\\models\\Category');

        $this->setFakerInstance();
    }

    /**
     * Create a single entity
     * Require generators to have this method
     */
    abstract protected function create();

    /**
     * Returns a generator name
     * Require generators to have this method
     */
    abstract protected function getName();

    /**
     * Set Faker class instance
     * @return \Faker\Generator
     * @throws \RuntimeException
     */
    protected function setFakerInstance()
    {
        $this->library->load('faker');

        if (class_exists('Faker\\Factory')) {
            return $this->faker = \Faker\Factory::create();
        }
        throw new \InvalidArgumentException('Class "Faker\Factory" not found');
    }

    /**
     * Generate a given number of entities
     * @param integer $limit
     * @return integer
     */
    public function generate($limit = 20)
    {
        ini_set('memory_limit', -1);

        $created = 0;
        for ($i = 0; $i < $limit; $i++) {
            $created += (int) $this->create();
        }
        return $created;
    }

    /**
     * Returns a random array of images from the database
     * @staticvar array $files
     * @param bool $return_paths
     * @return array
     */
    protected function getImages($return_paths = true)
    {
        static $files = null;

        if (!isset($files)) {
            $files = $this->file->getList(array(
                'file_type' => 'image',
                'limit' => array(0, 300)
            ));
        }

        if (empty($files)) {
            return array();
        }

        $limit = $this->config->get('module_faker_entity_file_limit', 5);
        $images = array_slice($this->faker->shuffle($files), 0, $limit, true);

        if (!$return_paths) {
            return array_keys($images);
        }

        $paths = array();
        foreach ($images as $image) {
            $paths[] = array('path' => $image['path']);
        }

        return $paths;
    }

    /**
     * Returns a random store ID
     * @staticvar array $stores
     * @return integer
     */
    protected function getStoreId()
    {
        static $stores = null;
        if (!isset($stores)) {
            $stores = $this->store->getList(array('limit' => array(0, 100)));
        }
        return (int) array_rand($stores);
    }

    /**
     * Returns a random user ID
     * @staticvar array $users
     * @return integer
     */
    protected function getUserId()
    {
        static $users = null;
        if (!isset($users)) {
            $users = $this->user->getList(array('limit' => array(0, 100)));
        }
        return (int) array_rand($users);
    }

    /**
     * Returns a random category ID
     * @staticvar array $categories
     * @param string $type
     * @return integer
     */
    protected function getCategoryId($type)
    {
        static $categories = array();
        if (!isset($categories[$type])) {
            $options = array('limit' => array(0, 100), 'type' => $type);
            $categories[$type] = $this->category->getList($options);
        }
        return (int) array_rand($categories[$type]);
    }

    /**
     * Returns a unique URL alias
     * @return string
     */
    protected function getAlias()
    {
        return $this->alias->getUnique($this->faker->slug());
    }

    /**
     * Returns an array of available generator models
     * This method is static because we cannot instantiate abstract classes
     * @return array
     */
    public static function getList()
    {
        $generators = array();
        foreach (glob(__DIR__ . "/generators/*.php") as $file) {
            $id = strtolower(pathinfo($file, PATHINFO_FILENAME));

            try {
                $instance = Container::get("gplcart\\modules\\faker\\models\\generators\\$id");
            } catch (\ReflectionException $ex) {
                continue;
            }

            if ($instance instanceof \gplcart\modules\faker\models\Generator) {
                $generators[$id] = $instance;
            }
        }

        ksort($generators);
        return $generators;
    }

    /**
     * Returns a generator model instance
     * @param string $name
     * @return object|null
     */
    public static function get($name)
    {
        $generators = static::getList();
        if (empty($generators[$name])) {
            return null;
        }
        return $generators[$name];
    }

}