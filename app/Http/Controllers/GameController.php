<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return response()->json(['data' => $games]);
    }

    public function show($id)
    {
        $game = Game::findOrFail($id);
        return response()->json(['data' => $game]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $game = Game::create($data);

        return response()->json(['message' => 'Game created successfully', 'data' => $game], 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $game = Game::findOrFail($id);
        $game->update($data);

        return response()->json(['message' => 'Game updated successfully', 'data' => $game]);
    }

    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return response()->json(['message' => 'Game deleted successfully']);
    }
}
