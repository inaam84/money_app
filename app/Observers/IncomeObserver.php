<?php

namespace App\Observers;

use App\Models\Income;

class IncomeObserver
{
    public function creating(Income $income)
    {
        return $income->amount = $this->formatAmountForDB($income->amount);
    }

    public function created(Income $income)
    {
        return $income->amount = $this->formatAmountForUser($income->amount);
    }

    public function updating(Income $income)
    {
        return $income->amount = $this->formatAmountForDB($income->amount);
    }

    public function updated(Income $income)
    {
        return $income->amount = $this->formatAmountForUser($income->amount);
    }

    public function retrieved(Income $income)
    {
        return $income->amount = $this->formatAmountForUser($income->amount);
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
