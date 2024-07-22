<?
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonSerializable;

class Player extends Model implements JsonSerializable
{
    static public function isValidName($name)
    {
        return is_string($name) && !empty($name);
    }
    
    protected $fillable = ['name', 'position_id'];
    private $position;
    private $playerSkills = [];

    // Construtor
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!isset($attributes['name'])) {
            throw new InvalidArgumentException("Invalid value for 'name': Missing field.");
        }
        if (!isset($attributes['position'])) {
            throw new InvalidArgumentException("Invalid value for 'position': Missing field.");
        }
        if (!isset($attributes['playerSkills'])) {
            throw new InvalidArgumentException("Invalid value for 'playerSkills': Missing field.");
        }
        
        $this->setName($attributes['name']);
        $this->setPosition($attributes['position']);
        $this->setPlayerSkills($attributes['playerSkills']);
    }

    // Métodos de instância
    public function setName($name)
    {
        if (!self::isValidName($name)) {
            throw new InvalidArgumentException("Invalid value for 'name': '$name'");
        }
        $this->attributes['name'] = $name;
    }

    public function setPosition($position)
    {
        $this->position = new Position($position);
        $this->attributes['position_id'] = $this->position->getId();
    }

    public function setPlayerSkills($playerSkills)
    {
        if (!is_array($playerSkills)) {
            throw new InvalidArgumentException("Invalid value for 'playerSkills': non-array.");
        }
        if (empty($playerSkills)) {
            throw new InvalidArgumentException("Invalid value for 'playerSkills': empty-array.");
        }
        foreach ($playerSkills as $index => $playerSkill) {
            $this->skills[] = new PlayerSkill($playerSkill);
        }
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getPlayerSkills()
    {
        return $this->playerSkills;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->attributes['id'],
            'name' => $this->attributes['name'],
            'position' => $this->position,
            'playerSkills' => $this->playerSkills,
        ];
    }
}
