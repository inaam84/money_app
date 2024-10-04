<?php

namespace App\Observers;

use App\Models\Expense;

class ExpenseObserver
{
    public function creating(Expense $expense)
    {
        $expense->amount = $this->formatAmountForDB($expense->amount);
        $expense->currency = strtoupper($expense->currency);
        return $expense;
    }

    public function created(Expense $expense)
    {
        $expense->amount = $this->formatAmountForUser($expense->amount);
        $expense->currency = strtoupper($expense->currency);
        return $expense;
    }

    public function updating(Expense $expense)
    {
        $expense->amount = $this->formatAmountForDB($expense->amount);
        $expense->currency = strtoupper($expense->currency);
        return $expense;
    }

    public function updated(Expense $expense)
    {
        $expense->amount = $this->formatAmountForUser($expense->amount);
        $expense->currency = strtoupper($expense->currency);
        return $expense;
    }

    public function retrieved(Expense $expense)
    {
        $expense->amount = $this->formatAmountForUser($expense->amount);
        $expense->currency = strtoupper($expense->currency);
        return $expense;
    }

    private function formatAmountForUser($amount)
    {
        return $amount = round($amount/100, 2);
    }

    private function formatAmountForDB($amount)
    {
        return $amount = $amount * 100;
    }
}
