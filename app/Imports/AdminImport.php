<?php

namespace App\Imports;

use App\Models\Admin;
use App\Models\Division;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AdminImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        DB::beginTransaction();
        try {
            DB::table('admins')->delete();
            
            foreach ($collection as $row) {
                
                Admin::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'division_id' => Division::where('slug', $row['division'])->first()->id,
                    'password' => Hash::make('244466666')
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'], 
            'division' => ['required', 'exists:divisions,slug'],
        ];
    }
    public function customValidationMessages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email',
            'division.required' => 'Division is required',
            'division.exists' => 'Division not found',
        ];
    }
    public function headingRow(): int
    {
        return 1;
    }
}
