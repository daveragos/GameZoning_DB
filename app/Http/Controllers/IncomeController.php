<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Employee;
use App\Models\Game;
use Illuminate\Http\Request;

class IncomeController extends Controller
{

    //todo: Scenario: Retrieve income by employee_username
    public function getByEmployee(Request $request)
    {
        $request->validate([
            'employee_username' => 'required|exists:employees,username',
        ]);

        $incomes = Income::where('employee_username', $request->input('employee_username'))
            ->get();

        return response()->json(['data' => $incomes]);
    }

    //todo: Scenario: Retrieve income by employee_username and date
    public function getByEmployeeAndDate(Request $request)
    {
        $request->validate([
            'employee_username' => 'required|exists:employees,username',
            'date' => 'required|date',
        ]);

        $incomes = Income::where('employee_username', $request->input('employee_username'))
            ->where('date', $request->input('date'))
            ->get();

        return response()->json(['data' => $incomes]);
    }


    //todo: Scenario: Retrieve income by employee_username and game_name
    public function getByEmployeeAndGame(Request $request)
    {
        $request->validate([
            'employee_username' => 'required|exists:employees,username',
            'game_name' => 'required|exists:games,name',
        ]);

        $incomes = Income::where('employee_username', $request->input('employee_username'))
            ->where('game_name', $request->input('game_name'))
            ->get();

        return response()->json(['data' => $incomes]);
    }
    //todo: Scenario: Retrieve income by employee_username and game_name and date
    public function getByEmployeeGameAndDate(Request $request)
    {
        $request->validate([
            'employee_username' => 'required|exists:employees,username',
            'game_name' => 'required|exists:games,name',
            'date' => 'required|date',
        ]);

        $incomes = Income::where('employee_username', $request->input('employee_username'))
            ->where('game_name', $request->input('game_name'))
            ->where('date', $request->input('date'))
            ->get();

        return response()->json(['data' => $incomes]);
    }

    //todo: Scenario: Delete income by employee_username
    public function deleteByEmployee(Request $request)
{
    $request->validate([
        'employee_username' => 'required|exists:employees,username',
    ]);

    Income::where('employee_username', $request->input('employee_username'))->delete();

    return response()->json(['message' => 'Incomes deleted successfully']);
}

    //todo: Scenario: Delete income by employee_username and date
    public function deleteByEmployeeAndDate(Request $request)
    {
        $request->validate([
            'employee_username' => 'required|exists:employees,username',
            'date' => 'required|date',
        ]);

        Income::where('employee_username', $request->input('employee_username'))
            ->where('date', $request->input('date'))
            ->delete();

        return response()->json(['message' => 'Incomes deleted successfully']);
    }

    //todo: Scenario: Delete income by employee_username and game
    public function deleteByEmployeeAndGame(Request $request)
{
    $request->validate([
        'employee_username' => 'required|exists:employees,username',
        'game_name' => 'required|exists:games,name',
    ]);

    Income::where('employee_username', $request->input('employee_username'))
        ->where('game_name', $request->input('game_name'))
        ->delete();

    return response()->json(['message' => 'Incomes deleted successfully']);
}

    //todo: Scenario: Delete income by employee_username ,date and game
    public function deleteByEmployeeGameAndDate(Request $request)
    {
        $request->validate([
            'employee_username' => 'required|exists:employees,username',
            'game_name' => 'required|exists:games,name',
            'date' => 'required|date',
        ]);

        Income::where('employee_username', $request->input('employee_username'))
            ->where('game_name', $request->input('game_name'))
            ->where('date', $request->input('date'))
            ->delete();

        return response()->json(['message' => 'Incomes deleted successfully']);
    }

    //todo: Scenario: Update income by employee_username ,date and game

    public function updateByEmployeeGameAndDate(Request $request)
    {
        $request->validate([
            'employee_username' => 'required|exists:employees,username',
            'old_game_name' => 'required|exists:games,name',
            'old_date' => 'required|date',
            'new_game_name' => 'sometimes|exists:games,name',
            'new_date' => 'sometimes|date',
            'new_amount' => 'sometimes|numeric',
        ]);

        $income = Income::where('employee_username', $request->input('employee_username'))
            ->where('game_name', $request->input('old_game_name'))
            ->where('date', $request->input('old_date'))
            ->firstOrFail();

        if ($request->has('new_game_name')) {
            $income->game_name = Game::where('name', $request->input('new_game_name'))->firstOrFail()->id;
        }

        if ($request->has('new_date')) {
            $income->date = $request->input('new_date');
        }
        if ($request->has('new_amount')) {
            $income->amount = $request->input('new_amount');
        }

        $income->save();

        return response()->json(['message' => 'Income updated successfully', 'data' => $income]);
    }

    public function index()
    {
        $incomes = Income::all();
        return response()->json(['data' => $incomes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_username' => 'required|exists:employees,username',
            'game_name' => 'required|exists:games,name',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $income = Income::create([
            'employee_username' => $request->input('employee_username'),
            'game_name' => $request->input('game_name'),
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
            'employee_username' => 'sometimes|exists:employees,username',
            'game_name' => 'sometimes|exists:games,name',
            'amount' => 'sometimes|numeric',
            'date' => 'sometimes|date',
        ]);

        $income = Income::findOrFail($id);

        if ($request->has('employee_username')) {
            $employee = Employee::where('username', $request->input('employee_username'))->first();
            if ($employee) {
                $income->employee()->associate($employee);
            }
        }
        if ($request->has('game_name')) {
            $game = Game::where('name', $request->input('game_name'))->first();
            if ($game) {
                $income->game()->associate($game);
            }
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
