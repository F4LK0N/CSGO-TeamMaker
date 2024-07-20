<?
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\PlayerSkill;
use App\Models\Skill;
use InvalidArgumentException;

class PlayerSkillTest extends TestCase
{
    public function testCreatePlayerSkill()
    {
        $playerSkill = new PlayerSkill(1, 85);

        $this->assertEquals(85, $playerSkill->getValue());
        $this->assertInstanceOf(Skill::class, $playerSkill->getSkill());
        $this->assertEquals('attack', $playerSkill->getSkill()->getName());
    }

    public function testInvalidPlayerSkillValue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': '150'");
        new PlayerSkill(1, 150);
    }

    public function testJsonSerialize()
    {
        $playerSkill = new PlayerSkill(2, 90);

        $json = json_encode($playerSkill);
        $expected = json_encode([
            'skill' => 'speed',
            'value' => 90
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $json);
    }
}
