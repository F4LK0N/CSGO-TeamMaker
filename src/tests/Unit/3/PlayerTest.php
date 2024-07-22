<?
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Player;
use InvalidArgumentException;

class PlayerTest extends TestCase
{
    public function testNameInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'name': ''");
        new Player([
            'name' => '',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80]
            ]
        ]);
    }
    
    public function testPlayerSkillsInvalidNotArray()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'playerSkills': non-array.");
        new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => 'invalid'
        ]);
    }
    
    public function testPlayerSkillsInvalidEmptyArray()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'playerSkills': empty-array.");
        new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => []
        ]);
    }
    
    public function testPlayerSkillsInvalidDuplicated()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'playerSkills': duplicated skill 'attack'.");
        new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 100],
                ['skill' => 'attack', 'value' => 100],
            ]
        ]);
    }
    
    public function testPlayerSkillsInvalidMissingFields()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'skill': Missing field.");
        new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['value' => 100]
            ]
        ]);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': Missing field.");
        new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack']
            ]
        ]);
    }
    
    public function testPlayer()
    {
        $player = new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'speed', 'value' => 90],
            ]
        ]);

        $this->assertEquals('John Doe', $player->getName());
        $this->assertEquals('midfielder', $player->getPosition()->getName());
        $this->assertCount(2, $player->getPlayerSkills());
    }

    public function testJsonSerialize()
    {
        $player = new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'speed', 'value' => 90],
            ]
        ]);

        $json = json_encode($player);
        $expected = json_encode([
            'id' => 0,
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'speed', 'value' => 90],
            ]
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $json);
    }
}
