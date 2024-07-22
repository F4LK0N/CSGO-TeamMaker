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
            'playerSkills' => 'invalid'
        ]);
    }
    
    public function testPlayerSkillsInvalidDuplicated()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'playerSkills': empty-array.");
        new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 100],
                ['skill' => 'attack', 'value' => 100],
            ]
        ]);
    }
    
    public function testCreatePlayer()
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
    
    public function testInvalidSkillMissingFields()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'skill': Missing field.");
        new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack']
            ]
        ]);
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid value for 'value': Missing field.");
        new Player([
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['value' => 100]
            ]
        ]);
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
            'id' => null, // id is null because it's not set
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
