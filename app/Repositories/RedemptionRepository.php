<?php

namespace App\Repositories;

use App\Models\Redemption;

class RedemptionRepository
{
    public function prizeRedemption(array $data): Redemption
    {
        return Redemption::create($data);
    }
}