<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeamsWithUsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Team::with('users')->where('valid', 1)->get();
    }

    public function headings(): array
    {
        return [
            'Team Name',
            'Team Email',
            'Team School',
            'Team Domicile',
            'Proof of Payment',
            'User Name',
            'Gender',
            'Phone Number',
            'Line ID',
            'Consumption Type',
            'Food Allergy',
            'Drug Allergy',
            'Medical History',
            'Student Card'
        ];
    }

    public function map($team): array
    {
        $rows = [];

        foreach ($team->users as $user) {
            $rows[] = [
                $team->name,
                $team->email,
                $team->school,
                $team->domicile,
                asset($team->proof_of_payment),
                $user->name,
                $user->gender == 0 ? 'Male' : 'Female',
                $user->phone_number,
                $user->line_id,
                $this->getConsumptionType($user->consumption_type),
                $user->food_allergy,
                $user->drug_allergy,
                $user->medical_history,
                asset($user->student_card)
            ];
        }

        return $rows;
    }

    private function getConsumptionType($type)
    {
        $types = ['Normal', 'Vege', 'Vegan'];
        return $types[$type] ?? 'Unknown';
    }
}

