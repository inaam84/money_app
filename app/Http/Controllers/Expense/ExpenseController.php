<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Models\Expense;
use App\Http\Resources\ExpenseResource;
use Illuminate\Http\Response;


class ExpenseController extends Controller
{
    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Expense successfully added',
            'expense' => ExpenseResource::make($expense),
        ], Response::HTTP_CREATED);
    }

    public function update(Expense $expense, StoreExpenseRequest $request)
    {
        $expense->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'currency' => $request->currency,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Expense successfully updated',
            'expense' => ExpenseResource::make($expense),
        ]);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Expense successfully deleted'
        ]); 
    }
}
