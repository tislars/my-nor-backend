<?php

namespace App\Services;

use App\Models\Driver;

class EloService
{
    private $kFactor = 32;

    /**
     * @param Driver $driverA
     * @param Driver $driverB
     * @return array<string, int>
     */
    public function calculateElo(Driver $driverA, Driver $driverB, int $positionA, int $positionB): array
    {
        $ratingA = $driverA->elo;
        $ratingB = $driverB->elo;

        $expectedA = 1 / (1 + pow(10, ($ratingB - $ratingA) / 400));
        $expectedB = 1 / (1 + pow(10, ($ratingA - $ratingB) / 400));

        $scoreA = $positionA < $positionB ? 1 : ($positionA == $positionB ? 0.5 : 0);
        $scoreB = 1 - $scoreA;

        $changeA = (int) round($this->kFactor * ($scoreA - $expectedA));
        $changeB = (int) round($this->kFactor * ($scoreB - $expectedB));

        $driverA->elo += $changeA;
        $driverB->elo += $changeB;

        $driverA->save();
        $driverB->save();

        return [
            'changeA' => $changeA,
            'changeB' => $changeB,
        ];
    }
}
