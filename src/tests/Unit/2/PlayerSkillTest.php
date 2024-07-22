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
        new PlayerSkill(['skill'=>1,'value'=>-1]);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': '101'");
        new PlayerSkill(['skill'=>1,'value'=>101]);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': 'a'");
        new PlayerSkill(['skill'=>1,'value'=>'a']);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': 'true'");
        new PlayerSkill(['skill'=>1,'value'=>true]);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': 'false'");
        new PlayerSkill(['skill'=>1,'value'=>false]);
    }
    
    public function testValue()
    {
        for ($i=0; $i<=100; $i++) {
            $playerSkill = new PlayerSkill(['skill'=>1,'value'=>$i]);
            $this->assertEquals($i, $playerSkill->getValue());
        }
    }
    
    public function testSkillInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'skill': 'invalid'");
        $skill = new PlayerSkill(['skill'=>'invalid','value'=>100]);
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
            $playerSkill = new PlayerSkill(['skill'=>$skill,'value'=>100]);
            $this->assertEquals($skill, $playerSkill->getSkill()->getName());
        }
    }
    
    public function testJson()
    {
        $playerSkill = new PlayerSkill(['skill'=>'defense','value'=>100]);
        $this->assertJsonStringEqualsJsonString('{"skill":"defense","value":100}', json_encode($playerSkill));
    }
}
