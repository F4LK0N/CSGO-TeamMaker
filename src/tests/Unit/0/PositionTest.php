<?
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Position;
use InvalidArgumentException;

class PositionTest extends TestCase
{
    public function testIdInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'position': '-1'");
        new Position(-1);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'position': '3'");
        new Position(3);
    }
    
    public function testId()
    {
        $positions = [
            0 => 'defender',
            1 => 'midfielder',
            2 => 'forward'
        ];

        foreach ($positions as $id => $name) {
            $position = new Position($id);
            $this->assertEquals($id, $position->getId());
            $this->assertEquals($name, $position->getName());
        }
    }

    public function testNameInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'position': 'invalid'");
        new Position('invalid');
    }
    
    public function testName()
    {
        $positions = [
            'defender' => 0,
            'midfielder' => 1,
            'forward' => 2
        ];

        foreach ($positions as $name => $id) {
            $position = new Position($name);
            $this->assertEquals($id, $position->getId());
            $this->assertEquals($name, $position->getName());
        }
    }

    public function testJson()
    {
        $positions = [
            'defender',
            'midfielder',
            'forward'
        ];

        foreach ($positions as $name) {
            $position = new Position($name);
            $json = json_encode($position);
            $expected = json_encode($name);
            $this->assertJsonStringEqualsJsonString($expected, $json);
        }
    }
}
