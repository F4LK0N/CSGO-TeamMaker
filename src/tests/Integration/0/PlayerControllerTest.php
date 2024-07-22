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
    
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function testNameInvalid(): void
    {
        self::truncateTables();
        
        $response = $this->postJson('/api/player', [
            'name' => '',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'speed', 'value' => 90],
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => "Invalid value for 'name': Missing field.",
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
}
