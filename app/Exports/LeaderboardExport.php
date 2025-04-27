<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaderboardExport implements FromCollection, WithHeadings
{
    /**
     * Return a collection of rows (one per team).
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Team::query()
            ->where('valid', 1)
            ->get(['name', 'email', 'school', 'domicile', 'green_points', 'coin'])
            ->map(function ($team) {
                return [
                    $team->name,
                    $team->email,
                    $team->school,
                    $team->domicile,
                    $team->green_points,
                    $team->coin,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Team Name',
            'Team Email',
            'Team School',
            'Team Domicile',
            'Green Point',
            'Coin',
        ];
    }
}
