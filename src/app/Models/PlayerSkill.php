<?
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonSerializable;

class PlayerSkill extends Model implements JsonSerializable
{
    static public function isValidValue($value)
    {
        return is_int($value) && $value >= 0 && $value <= 100;
    }
    
    protected $fillable = [
        'player_id',
        'skill_id',
        'value',
    ];
    protected $guarded = [];
    
    private $id;
    private $player_id;
    private $skill;
    private $skill_id;
    private $value;

    public function __construct(array $attributes = [])
    {
        //parent::__construct($attributes);
        
        if (!isset($attributes['skill'])) {
            throw new InvalidArgumentException("Invalid value for 'skill': Missing field.");
        }
        if (!isset($attributes['value'])) {
            throw new InvalidArgumentException("Invalid value for 'value': Missing field.");
        }
        
        $this->setSkill($attributes['skill']);
        $this->setValue($attributes['value']);
    }
    
    public function setPlayerId($playerId){
        $this->player_id = $playerId;
    }
    
    private function setSkill($skill)
    {
        $this->skill = new Skill($skill);
        $this->skill_id = $this->skill->getId();
    }

    public function setValue($value)
    {
        if (!self::isValidValue($value)) {
            throw new InvalidArgumentException("Invalid value for 'value': '$value'");
        }
        $this->value = $value;
    }

    public function getSkill()
    {
        return $this->skill;
    }

    public function getValue()
    {
        return $this->value;
    }
    
    public function save(array $options = [])
    {
        $this->fill([
            'player_id' => $this->player_id,
            'skill_id' => $this->skill_id,
            'value' => $this->value,
        ]);
        parent::save($options);
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'skill' => $this->skill,
            'value' => $this->value,
        ];
    }
}
