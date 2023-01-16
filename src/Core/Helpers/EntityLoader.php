<?php

namespace Source\Core\Helpers;

//Singleton class EntityLoader to make sure we do not create a duplicate class of a specific client with an unique ID.
class EntityLoader
{
    /**
     * @var array $instances
     */
    private static $instances = [];

    public $classes = [];

    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton." . $GLOBALS['newline']);
    }

    public static function getInstance(): EntityLoader
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function load($class, $id)
    {
        if (!isset($this->classes[$class . '_' . $id]))
        {
            $this->classes[$class . '_' . $id] = new $class($id);
            
        }
        
        return $this->classes[$class . '_' . $id];
    }
}