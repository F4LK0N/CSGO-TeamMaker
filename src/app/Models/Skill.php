<?
namespace App\Models;

use InvalidArgumentException;

class Skill
{
    protected static $skills = [
        0 => 'defense',
        1 => 'attack',
        2 => 'speed',
        3 => 'strength',
        4 => 'stamina'
    ];

    public static function isValidName($name)
    {
        return in_array($name, self::$skills);
    }

    public static function isValidId($id)
    {
        return array_key_exists($id, self::$skills);
    }

    public static function getById($id)
    {
        if (!self::isValidId($id)) {
            throw new InvalidArgumentException("Invalid skill ID: $id");
        }
        $name = self::$skills[$id];
        return new self($name);
    }

    public $id;
    public $name;

    public function __construct($name)
    {
        if (!self::isValidName($name)) {
            throw new InvalidArgumentException("Invalid value for name: $name");
        }
        $this->name = $name;
        $this->id = array_search($name, self::$skills);
    }

    public function toArray()
    {
        return $this->name;
    }
}