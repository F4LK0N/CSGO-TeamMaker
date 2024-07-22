<?
namespace Tests\Integration;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
    static public function setUpBeforeClass(): void
    {
        
    }
    
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function testAdd(): void
    {
        $response = $this->post('/api/player', [
            'name' => 'John Doe',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'attack', 'value' => 80],
                ['skill' => 'speed', 'value' => 90],
            ]
        ]);

        $response->assertStatus(200);
    }
}
