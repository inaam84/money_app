<?php

namespace App\Http\Controllers\Income;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Income\StoreIncomeRequest;
use App\Http\Resources\IncomeResource;
use App\Models\Income;
use Illuminate\Http\Response;

class IncomeController extends BaseController
{
    public function index()
    {
        return IncomeResource::collection(Income::paginate(50));
    }

    public function store(StoreIncomeRequest $request)
    {
        $income = Income::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Income successfully added',
            'income' => IncomeResource::make($income),
        ], Response::HTTP_CREATED);
    }

    public function update(Income $income, StoreIncomeRequest $request)
    {
        $income->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'currency' => $request->currency,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Income successfully updated',
            'income' => IncomeResource::make($income),
        ]);
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Income successfully deleted'
        ]); 
    }
}
