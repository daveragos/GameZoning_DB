<?php
namespace App\Http\Controllers;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::all();
        return response()->json(['data' => $owners]);
    }

    public function show($id)
    {
        $owner = Owner::findOrFail($id);
        return response()->json(['data' => $owner]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:owners',
            'password' => 'required|min:6',
        ]);

        $owner = Owner::create($data);
        return response()->json(['message' => 'Owner created successfully', 'data' => $data], 201);
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:owners,email,' . $owner->id,
            'password' => 'required|min:6',
        ]);

        $owner->update($data);
        return response()->json(['message' => 'Owner updated successfully', 'data' => $owner]);
    }

    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->delete();
        return response()->json(['message' => 'Owner deleted successfully']);
    }
}
