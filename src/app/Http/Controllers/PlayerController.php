<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Position;
use App\Models\PlayerSkill;
use InvalidArgumentException;

class PlayerController extends Controller
{
    public function list()
    {
        return Player::all();
    }

    public function add(Request $request)
    {
        $data = $request->only(['name', 'position', 'playerSkills']);
        
        $player = new Player($data);
        $player->save();

        foreach ($data['playerSkills'] as $skill) {
            $playerSkill = new PlayerSkill([
                'player_id' => $player->id,
                'skill_id' => (new Skill($skill['skill']))->getId(),
                'value' => $skill['value'],
            ]);
            $playerSkill->save();
        }

        return response()->json($player, 201);
    }

    public function show($id)
    {
        $player = Player::findOrFail($id);
        return response()->json($player);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'position' => 'sometimes|required|string',
            'playerSkills' => 'sometimes|required|array',
            'playerSkills.*.skill' => 'required_with:playerSkills|string',
            'playerSkills.*.value' => 'required_with:playerSkills|integer|min:0|max:100',
        ]);

        $player = Player::findOrFail($id);

        if (isset($data['name'])) {
            $player->setName($data['name']);
        }
        if (isset($data['position'])) {
            $player->setPosition($data['position']);
        }
        if (isset($data['playerSkills'])) {
            $player->playerSkills()->delete();
            $player->setPlayerSkills($data['playerSkills']);
            foreach ($data['playerSkills'] as $skill) {
                $playerSkill = new PlayerSkill([
                    'player_id' => $player->id,
                    'skill_id' => (new Skill($skill['skill']))->getId(),
                    'value' => $skill['value'],
                ]);
                $playerSkill->save();
            }
        }

        $player->save();

        return response()->json($player);
    }

    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();
        return response()->json(null, 204);
    }
}
