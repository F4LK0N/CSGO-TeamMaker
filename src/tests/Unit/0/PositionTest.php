<?
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Position;
use InvalidArgumentException;

class PositionTest extends TestCase
{
    public function testCreatePositionById()
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

    public function testCreatePositionByName()
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

    public function testInvalidPositionId()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'position_id': '999'");
        new Position(999);
    }

    public function testInvalidPositionName()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'position': 'invalid'");
        new Position('invalid');
    }

    public function testJsonSerialize()
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
