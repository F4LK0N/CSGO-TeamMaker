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
        $this->expectExceptionMessage("Invalid value for 'value': '101'");
        new PlayerSkill(1, 101);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': '-1'");
        new PlayerSkill(1, -1);
        
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
    
    //public function testSkillNameInvalid()
    //{
    //    
    //}
}
