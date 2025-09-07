<?php

namespace App\Repositories;

use App\Models\Prize;
use Symfony\Component\HttpFoundation\Response;

class PrizeRepository
{

    public function findPrizeById(int $id): Prize
    {
        $prize = Prize::findOrFail($id);

        if (!$prize)
            throw new \Exception('Prêmio não encontrado.', Response::HTTP_NOT_FOUND);

        return $prize;
    }

    public function findMaximumPrize()
    {
        $maximumPrize = Prize::max('points');

        $prize = Prize::where('points', $maximumPrize)->first();

        if (!$prize)
            throw new \Exception('Prêmio não encontrado.', Response::HTTP_NOT_FOUND);

        return $prize;
    }

    public function getPointsPrizeById(int $id): Prize|null
    {
        return Prize::query()
            ->select('points')
            ->where('id', '=', $id)
            ->first(); 
    }
}