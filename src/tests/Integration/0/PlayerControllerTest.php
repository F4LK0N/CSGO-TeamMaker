<?
namespace Tests\Integration;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Player;
use App\Models\PlayerSkill;

class PlayerControllerTest extends TestCase
{
    static private function truncateTables(): void
    {
        DB::table('players')->truncate();
        DB::table('player_skills')->truncate();
    }

    public function testNameMissing(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack','value' => 80]
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'name': Missing field.",
        ]);
    }

    public function testPositionMissing(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'playerSkills' => [
                ['skill' => 'attack','value' => 80]
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'position': Missing field.",
        ]);
    }

    public function testPositionInvalid(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'invalid',
            'playerSkills' => [
                ['skill' => 'attack','value' => 80]
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'position': 'invalid'",
        ]);
    }

    public function testPlayerSkillsMissing(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'playerSkills': Missing field.",
        ]);
    }

    public function testPlayerSkillsInvalid(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => 'invalid',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'playerSkills': non-array.",
        ]);
    }

    public function testPlayerSkillsEmpty(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [],
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'playerSkills': empty-array.",
        ]);
    }

    public function testPlayerSkillsSkillMissing(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['value' => 80]
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'skill': Missing field.",
        ]);
    }

    public function testPlayerSkillsSkillInvalid(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'invalid', 'value' => 80]
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'skill': 'invalid'",
        ]);
    }

    public function testPlayerSkillsValueMissing(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack']
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'value': Missing field.",
        ]);
    }

    public function testPlayerSkillsValueInvalid(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => -1]
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'value': '-1'",
        ]);
    }

    public function testPlayerSkillsValueInvalid2(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 101]
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'value': '101'",
        ]);
    }

    public function testPlayerSkillsDuplicated(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'attack', 'value' => 90],
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'playerSkills': duplicated skill 'attack'.",
        ]);
    }

    public function testPlayerSkillsDuplicated2(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'speed', 'value' => 90],
                ['skill' => 'attack', 'value' => 100],
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'playerSkills': duplicated skill 'attack'.",
        ]);
    }

    public function testAdd(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'speed', 'value' => 90],
            ]
        ]);

        $response->assertStatus(201);
    }

    public function testAddDuplicated(): void
    {
        self::truncateTables();

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'speed', 'value' => 90],
            ]
        ]);

        $response = $this->postJson('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'speed', 'value' => 90],
            ]
        ]);

        $response->assertStatus(201);
    }
}
