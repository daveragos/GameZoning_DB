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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:owners',
            'password' => 'required|min:6',
        ]);

        $owner = Owner::create($data);
        return response()->json(['message' => 'Owner created successfully', 'data' => $owner], 201);
    }

        public function update(Request $request, $id)
        {
            $request->validate([
                'name' => 'sometimes|string|max:255', // Validation rule for name
                'email' => 'sometimes|email|unique:owners,email,' . $id,
                'password' => 'nullable|min:6', // Allow password to be updated
            ]);

            $owner = Owner::findOrFail($id);


            if ($request->has('name')) {
                $owner->name = $request->input('name');
            }

            if ($request->has('email')) {
                $owner->email = $request->input('email');
            }
            if ($request->has('password')) {
                $owner->password = bcrypt($request->input('password'));
            }

            $owner->save();

            return response()->json(['message' => 'Employee updated successfully', 'data' => $owner]);
        }

    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->delete();
        return response()->json(['message' => 'Owner deleted successfully']);
    }
}
