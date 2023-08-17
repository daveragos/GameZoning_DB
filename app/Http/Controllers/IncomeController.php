<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::all();
        return response()->json(['data' => $incomes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'game_id' => 'required|exists:games,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $income = Income::create([
            'employee_id' => $request->input('employee_id'),
            'game_id' => $request->input('game_id'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
        ]);

        return response()->json(['message' => 'Income created successfully', 'data' => $income], 201);
    }

    public function show($id)
    {
        $income = Income::findOrFail($id);
        return response()->json(['data' => $income]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'sometimes|exists:employees,id',
            'game_id' => 'sometimes|exists:games,id',
            'amount' => 'sometimes|numeric',
            'date' => 'sometimes|date',
        ]);

        $income = Income::findOrFail($id);

        if ($request->has('employee_id')) {
            $income->employee_id = $request->input('employee_id');
        }
        if ($request->has('game_id')) {
            $income->game_id = $request->input('game_id');
        }
        if ($request->has('amount')) {
            $income->amount = $request->input('amount');
        }
        if ($request->has('date')) {
            $income->date = $request->input('date');
        }

        $income->save();

        return response()->json(['message' => 'Income updated successfully', 'data' => $income]);
    }

    public function destroy($id)
    {
        $income = Income::findOrFail($id);
        $income->delete();

        return response()->json(['message' => 'Income deleted successfully']);
    }
}
