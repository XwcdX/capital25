<?php

namespace App\Exports;

use App\Models\Team;
use App\Models\Phase;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CoinPhase3Export implements FromCollection, WithHeadings
{
    public function collection()
    {
        $phase1End = Phase::where('phase', 1)->value('end_time');
        $phase2End = Phase::where('phase', 2)->value('end_time');
        $phase3End = Phase::where('phase', 3)->value('end_time');

        $teams = Team::where('valid', 1)
            ->with(['answers.question', 'transactions'])
            ->get();

        return $teams->map(function ($team) use ($phase1End, $phase2End, $phase3End) {
            $totalQna = $team->answers
                ->where('is_correct', 1)
                ->sum('question.points');

            $reducedGreen = $team->green_point - $totalQna;

            $greenTx = $team->transactions
                ->where('transaction_type', 'green_point');

            $sumBetween = function ($start, $end) use ($greenTx) {
                return $greenTx
                    ->filter(
                        fn($tx) =>
                        $tx->created_at->format('H:i:s') > $start
                        && $tx->created_at->format('H:i:s') <= $end
                    )
                    ->sum(
                        fn($tx) =>
                        $tx->action === 'credit'
                        ? $tx->amount
                        : -1 * $tx->amount
                    );
            };

            $phase1Sum = $greenTx
                ->filter(
                    fn($tx) =>
                    $tx->created_at->format('H:i:s') <= Carbon::parse($phase1End)->format('H:i:s')
                )
                ->sum(
                    fn($tx) =>
                    $tx->action === 'credit' ? $tx->amount : -1 * $tx->amount
                );
            $res1 = $phase1Sum * 1.5;

            $phase2Sum = $sumBetween($phase1End, $phase2End);
            $res2 = ($res1 + $phase2Sum) * 1.5;

            $phase3Sum = $sumBetween($phase2End, $phase3End);
            $res3 = ($res2 + $phase3Sum) * 1.5;

            $finalInvest = $res3;
            $coinPhase3 = $reducedGreen - $finalInvest;

            return [
                'Team Name' => $team->name,
                'Coin (Phase 3)' => $coinPhase3,
                'Green Point (Final Invest)' => $finalInvest,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Team Name',
            'Coin (Phase 3)',
            'Green Point (Final Invest)',
        ];
    }
}
