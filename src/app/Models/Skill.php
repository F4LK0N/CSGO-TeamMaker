<?
namespace App\Models;

use InvalidArgumentException;
use JsonSerializable;

class Skill implements JsonSerializable
{
    static protected $skills = [
        0 => 'defense',
        1 => 'attack',
        2 => 'speed',
        3 => 'strength',
        4 => 'stamina'
    ];

    static public function isValid($value)
    {
        if (is_numeric($value)) {
            return array_key_exists($value, self::$skills);
        } else {
            return in_array($value, self::$skills);
        }
    }

    private $id;
    private $name;

    public function __construct($value)
    {
        if (is_numeric($value)) {
            $this->loadById($value);
        } else {
            $this->loadByName($value);
        }
    }

    private function loadById($id)
    {
        if (!self::isValid($id)) {
            throw new InvalidArgumentException("Invalid value for 'skill': '$id'");
        }
        $this->id = (int)$id;
        $this->name = self::$skills[$this->id];
    }

    private function loadByName($name)
    {
        if (!self::isValid($name)) {
            throw new InvalidArgumentException("Invalid value for 'skill': '$name'");
        }
        $this->name = $name;
        $this->id = array_search($name, self::$skills);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function jsonSerialize(): mixed
    {
        return $this->name;
    }
}
