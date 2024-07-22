<?
namespace App\Models;

use InvalidArgumentException;
use JsonSerializable;

class Position implements JsonSerializable
{
    static protected $positions = [
        0 => 'defender',
        1 => 'midfielder',
        2 => 'forward'
    ];

    static public function isValid($value)
    {
        if (is_numeric($value)) {
            return array_key_exists($value, self::$positions);
        } else {
            return in_array($value, self::$positions);
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
            throw new InvalidArgumentException("Invalid value for 'position': '$id'");
        }
        $this->id = (int)$id;
        $this->name = self::$positions[$this->id];
    }

    private function loadByName($name)
    {
        if (!self::isValid($name)) {
            throw new InvalidArgumentException("Invalid value for 'position': '$name'");
        }
        $this->name = $name;
        $this->id = array_search($name, self::$positions);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return $this->name;
    }
}
