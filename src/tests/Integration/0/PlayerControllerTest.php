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
    
//    public function testAdd(): void
//    {
//        self::truncateTables();
//        
//        $response = $this->postJson('/api/player', [
//            'name' => 'John Doe',
//            'position' => 'midfielder',
//            'playerSkills' => [
//                ['skill' => 'attack', 'value' => 80],
//                ['skill' => 'speed', 'value' => 90],
//            ]
//        ]);
//
//        $response->assertStatus(201);
//    }
}
