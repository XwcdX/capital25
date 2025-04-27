<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostDetailExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $teams = Team::where('valid', 1)
            ->withCount([
                'rallies as post_1_count' => function ($q) {
                    $q->where('post', 1);
                },
                'rallies as post_2_count' => function ($q) {
                    $q->where('post', 2);
                },
                'rallies as post_3_count' => function ($q) {
                    $q->where('post', 3);
                },
                'rallies as post_4_count' => function ($q) {
                    $q->where('post', 4);
                },
                'rallies as post_5_count' => function ($q) {
                    $q->where('post', 5);
                },
                'rallies as post_6_count' => function ($q) {
                    $q->where('post', 6);
                },
                'rallies as post_7_count' => function ($q) {
                    $q->where('post', 7);
                },
                'rallies as post_8_count' => function ($q) {
                    $q->where('post', 8);
                },
            ])
            ->orderByRaw('
                (post_1_count
            +post_2_count
            +post_3_count
            +post_4_count
            +post_5_count
            +post_6_count
            +post_7_count
            +post_8_count
                ) DESC
            ')
            ->get();

        return $teams->map(function ($team) {
            $total =
                $team->post_1_count +
                $team->post_2_count +
                $team->post_3_count +
                $team->post_4_count +
                $team->post_5_count +
                $team->post_6_count +
                $team->post_7_count +
                $team->post_8_count;

            return [
                'Team Name' => $team->name,
                'Post 1' => $team->post_1_count,
                'Post 2' => $team->post_2_count,
                'Post 3' => $team->post_3_count,
                'Post 4' => $team->post_4_count,
                'Post 5' => $team->post_5_count,
                'Post 6' => $team->post_6_count,
                'Post 7' => $team->post_7_count,
                'Post 8' => $team->post_8_count,
                'Total Rally Played' => $total,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Team Name',
            'Post 1',
            'Post 2',
            'Post 3',
            'Post 4',
            'Post 5',
            'Post 6',
            'Post 7',
            'Post 8',
            'Total Rally Played',
        ];
    }
}
