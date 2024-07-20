<?
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonSerializable;

class PlayerSkill extends Model implements JsonSerializable
{
    protected $fillable = ['player_id', 'value'];

    static public function isValidValue($value)
    {
        return is_int($value) && $value >= 0 && $value <= 100;
    }

    private $skill;
    private $value;
    private $skill_id;

    public function __construct($skillValue, $value)
    {
        $this->setSkill($skillValue);
        $this->setValue($value);
    }

    private function setSkill($skillValue)
    {
        $this->skill = new Skill($skillValue);
        $this->skill_id = $this->skill->getId();
    }

    private function setValue($value)
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

    public function jsonSerialize()
    {
        return [
            'skill' => $this->skill,
            'value' => $this->value
        ];
    }
}
