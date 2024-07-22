<?
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\PlayerSkill;
use App\Models\Skill;
use InvalidArgumentException;

class PlayerSkillTest extends TestCase
{
    public function testValueInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': '-1'");
        new PlayerSkill(1, -1);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': '101'");
        new PlayerSkill(1, 101);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': 'a'");
        new PlayerSkill(1, 'a');
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': 'true'");
        new PlayerSkill(1, true);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': 'false'");
        new PlayerSkill(1, false);
    }
    
    public function testValue()
    {
        for ($i=0; $i<=100; $i++) {
            $skill = new PlayerSkill(1, $i);
            $this->assertEquals($i, $skill->getValue());
        }
    }
    
    public function testSkillInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'skill': 'invalid'");
        $skill = new PlayerSkill('invalid', 100);
    }
    
    public function testSkill()
    {
        $skills = [
            'defense' => 0,
            'attack' => 1,
            'speed' => 2,
            'strength' => 3,
            'stamina' => 4
        ];

        foreach ($skills as $skill => $id) {
            $playerSkill = new PlayerSkill($skill, 100);
            $this->assertEquals($skill, $playerSkill->getSkill()->getName());
        }
    }
    
    public function testJson()
    {
        $playerSkill = new PlayerSkill('defense', 100);
        $this->assertJsonStringEqualsJsonString('{"skill":"defense","value":100}', json_encode($playerSkill));
    }
}
