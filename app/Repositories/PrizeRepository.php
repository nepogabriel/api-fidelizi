<?php

namespace App\Repositories;

use App\Models\Prize;

class PrizeRepository
{
    public function getPointsPrizeById(int $id): Prize|null
    {
        return Prize::query()
            ->select('points')
            ->where('id', '=', $id)
            ->first(); 
    }
}