<?php

namespace App\Observers;

use App\Models\Income;

class IncomeObserver
{
    public function creating(Income $income)
    {
        $income->amount = $this->formatAmountForDB($income->amount);
        $income->currency = strtoupper($income->currency);
        return $income;
    }

    public function created(Income $income)
    {
        $income->amount = $this->formatAmountForUser($income->amount);
        $income->currency = strtoupper($income->currency);
        return $income;
    }

    public function updating(Income $income)
    {
        $income->amount = $this->formatAmountForDB($income->amount);
        $income->currency = strtoupper($income->currency);
        return $income;
    }

    public function updated(Income $income)
    {
        $income->amount = $this->formatAmountForUser($income->amount);
        $income->currency = strtoupper($income->currency);
        return $income;
    }

    public function retrieved(Income $income)
    {
        $income->amount = $this->formatAmountForUser($income->amount);
        $income->currency = strtoupper($income->currency);
        return $income;
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
