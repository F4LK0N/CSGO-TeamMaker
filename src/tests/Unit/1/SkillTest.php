<?
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Skill;
use InvalidArgumentException;

class SkillTest extends TestCase
{
    public function testIdInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'skill': '-1'");
        new Skill(-1);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'skill': '5'");
        new Skill(5);
    }
    
    public function testId()
    {
        $skills = [
            0 => 'defense',
            1 => 'attack',
            2 => 'speed',
            3 => 'strength',
            4 => 'stamina'
        ];

        foreach ($skills as $id => $name) {
            $skill = new Skill($id);
            $this->assertEquals($id, $skill->getId());
            $this->assertEquals($name, $skill->getName());
        }
    }
    
    public function testNameInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'skill': 'invalid'");
        new Skill('invalid');
    }

    public function testName()
    {
        $skills = [
            'defense' => 0,
            'attack' => 1,
            'speed' => 2,
            'strength' => 3,
            'stamina' => 4
        ];

        foreach ($skills as $name => $id) {
            $skill = new Skill($name);
            $this->assertEquals($id, $skill->getId());
            $this->assertEquals($name, $skill->getName());
        }
    }

    public function testJson()
    {
        $skills = [
            'defense',
            'attack',
            'speed',
            'strength',
            'stamina'
        ];

        foreach ($skills as $name) {
            $skill = new Skill($name);
            $json = json_encode($skill);
            $expected = json_encode($name);
            $this->assertJsonStringEqualsJsonString($expected, $json);
        }
    }
}
